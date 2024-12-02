<?php
session_start();
require '../../db.php';

$job_id = $_GET['job_id'] ?? 0;
$user_id = $_SESSION['user_id'] ?? null;

// Ambil detail pekerjaan berdasarkan job_id
$job_query = $conn->prepare("SELECT * FROM tb_jobs WHERE id = ?");
$job_query->bind_param("i", $job_id);
$job_query->execute();
$job_result = $job_query->get_result();
$job = $job_result->fetch_assoc();

// Ambil status aplikasi untuk pekerjaan ini
$app_status_query = $conn->prepare("SELECT status FROM tb_applications WHERE job_id = ? AND user_id = ?");
$app_status_query->bind_param("ii", $job_id, $user_id);
$app_status_query->execute();
$app_status_result = $app_status_query->get_result();
$app_status = $app_status_result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center mb-4">Job Application Detail</h2>
        
        <h4>Job Title: <?= htmlspecialchars($job['title']) ?></h4>
        <p><strong>Company:</strong> <?= htmlspecialchars($job['company_name']) ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars($job['location']) ?></p>
        <p><strong>Employment Type:</strong> <?= htmlspecialchars($job['employment_type']) ?></p>
        <p><strong>Salary:</strong> <?= htmlspecialchars($job['salary_range']) ?></p>
        
        <h4>Status: <?= $app_status['status'] ?? 'No application found' ?></h4>
        
        <a href="index.php" class="btn btn-secondary">Back to Job List</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
