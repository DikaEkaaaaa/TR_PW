<?php
session_start();
require '../../db.php';

// Periksa apakah user memiliki role employer
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Employer') {
    header("Location: login.php");
    exit();
}

// Ambil pendaftar berdasarkan `job_id`
$job_id = $_GET['job_id'] ?? 0;
$stmt = $conn->prepare("
    SELECT a.id, a.nama, a.email, a.cv, a.status 
    FROM tb_applicants a 
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
    <title>Applicants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Job Applicants</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>CV</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($applicant = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $applicant['id'] ?></td>
                        <td><?= htmlspecialchars($applicant['nama']) ?></td>
                        <td><?= htmlspecialchars($applicant['email']) ?></td>
                        <td><a href="uploads/<?= $applicant['cv'] ?>" target="_blank">View CV</a></td>
                        <td><?= $applicant['status'] ?></td>
                        <td>
                            <a href="update_status.php?id=<?= $applicant['id'] ?>&status=lolos" class="btn btn-success btn-sm">Mark as Passed</a>
                            <a href="update_status.php?id=<?= $applicant['id'] ?>&status=tidak" class="btn btn-danger btn-sm">Mark as Failed</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
