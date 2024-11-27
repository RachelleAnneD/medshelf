<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db_connection.php';

$barangayId = isset($_GET['barangay_id']) ? intval($_GET['barangay_id']) : 0;

// Fetch all patient details for the selected barangay
$sql = "SELECT p.*, b.barangay_name 
        FROM patients p
        JOIN barangays b ON p.barangay_id = b.id
        WHERE p.barangay_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $barangayId);
$stmt->execute();
$result = $stmt->get_result();

$barangayName = '';
if ($barangayId > 0) {
    $barangayNameQuery = "SELECT barangay_name FROM barangays WHERE id = ?";
    $barangayStmt = $conn->prepare($barangayNameQuery);
    $barangayStmt->bind_param('i', $barangayId);
    $barangayStmt->execute();
    $barangayResult = $barangayStmt->get_result();
    $barangayRow = $barangayResult->fetch_assoc();
    $barangayName = $barangayRow['barangay_name'] ?? 'Unknown Barangay';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients in Barangay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Patients in <?= htmlspecialchars($barangayName) ?></h1>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']) ?></td>
                            <td>
                                <button class="btn btn-primary btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#patientModal" 
                                        data-patient='<?= json_encode($row) ?>'>
                                    Edit Details
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No patients found for this barangay.</p>
        <?php endif; ?>
    </div>

    <!-- Modal for Editing Patient Details -->
    <div class="modal fade" id="patientModal" tabindex="-1" aria-labelledby="patientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="patientModalLabel">Edit Patient Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPatientForm" method="POST" action="update_patient.php">
                        <input type="hidden" name="patientid" id="patientId">
                        <input type="hidden" name="barangay_id" value="<?= $barangayId ?>">
                        <div class="mb-3">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname">
                        </div>
                        <div class="mb-3">
                            <label for="mname" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="mname" name="mname">
                        </div>
                        <div class="mb-3">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname">
                        </div>
                        <div class="mb-3">
                            <label for="nickname" class="form-label">Nickname</label>
                            <input type="text" class="form-control" id="nickname" name="nickname">
                        </div>
                        <div class="mb-3">
                            <label for="mobile_number" class="form-label">Mobile Number</label>
                            <input type="text" class="form-control" id="mobile_number" name="mobile_number">
                        </div>
                        <!-- Add additional fields as needed -->
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const patientModal = document.getElementById('patientModal');
            const editPatientForm = document.getElementById('editPatientForm');

            patientModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const patient = JSON.parse(button.getAttribute('data-patient'));

                // Populate form fields
                editPatientForm.patientid.value = patient.patientid;
                editPatientForm.fname.value = patient.fname || '';
                editPatientForm.mname.value = patient.mname || '';
                editPatientForm.lname.value = patient.lname || '';
                editPatientForm.nickname.value = patient.nickname || '';
                editPatientForm.mobile_number.value = patient.mobile_number || '';
                // Add more fields as needed
            });
        });
    </script>
</body>

</html>
