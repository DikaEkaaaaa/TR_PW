<?php
session_start();
require '../../db.php';

// Periksa apakah user memiliki role Employer
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit();
}

// Ambil job_id dari URL
$job_id = $_GET['job_id'] ?? 0;

if ($job_id == 0) {
    echo "Job ID is invalid!";
    exit();
}

// Query untuk mengambil daftar pelamar berdasarkan job_id
$stmt = $conn->prepare("
    SELECT a.id AS applicant_id, p.full_name AS applicant_name, p.email AS applicant_email, a.status, a.applied_at
    FROM tb_applications a
    JOIN tb_profiles p ON a.user_id = p.user_id
    WHERE a.job_id = ?
");
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicants for Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Applicants for Job ID: <?= $job_id ?></h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Applied At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($applicant = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $applicant['applicant_id'] ?></td>
                        <td><?= htmlspecialchars($applicant['applicant_name']) ?></td>
                        <td><?= htmlspecialchars($applicant['applicant_email']) ?></td>
                        <td><?= htmlspecialchars($applicant['status']) ?></td>
                        <td><?= $applicant['applied_at'] ?></td>
                        <td>
                            <a href="update_status.php?id=<?= $applicant['applicant_id'] ?>&status=Accepted" class="btn btn-success btn-sm">Accept</a>
                            <a href="update_status.php?id=<?= $applicant['applicant_id'] ?>&status=Rejected" class="btn btn-danger btn-sm">Reject</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="admin_dashboard.php" class="mb-3 btn btn-secondary btn-sm">Back to Dashboard</a>
        <?php if ($result->num_rows == 0): ?>
            <p class="text-center">No applicants for this job yet!</p>
        <?php endif; ?>
    </div>
</body>
</html>
