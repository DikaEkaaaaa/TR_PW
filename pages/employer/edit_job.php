<?php
session_start();
require '../../db.php';

// Periksa apakah user memiliki role employer
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Employer') {
    header("Location: login.php");
    exit();
}

// Ambil ID pekerjaan yang ingin diedit
$job_id = $_GET['id'] ?? 0;

// Query untuk mengambil data pekerjaan yang ingin diedit
$stmt = $conn->prepare("SELECT * FROM tb_jobs WHERE id = ? AND created_by = ?");
$stmt->bind_param("ii", $job_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "<script>alert('Job not found or you do not have permission to edit it.'); window.location.href = 'dashboard.php';</script>";
    exit();
}

$job = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit Job</h1>
        <form action="update_job.php" method="POST">
            <input type="hidden" name="id" value="<?= $job['id'] ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Job Title</label>
                <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($job['title']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Job Description</label>
                <textarea name="description" id="description" class="form-control" rows="4" required><?= htmlspecialchars($job['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="requirements" class="form-label">Job Requirements</label>
                <textarea name="requirements" id="requirements" class="form-control" rows="4" required><?= htmlspecialchars($job['requirements']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="employment_type" class="form-label">Employment Type</label>
                <select name="employment_type" id="employment_type" class="form-select" required>
                    <option value="intern" <?= $job['employment_type'] === 'intern' ? 'selected' : '' ?>>Intern</option>
                    <option value="full-time" <?= $job['employment_type'] === 'full-time' ? 'selected' : '' ?>>Full-Time</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="salary_range" class="form-label">Salary Range</label>
                <input type="text" name="salary_range" id="salary_range" class="form-control" value="<?= htmlspecialchars($job['salary_range']) ?>">
            </div>
            <div class="mb-3">
                <label for="company_name" class="form-label">Company Name</label>
                <input type="text" name="company_name" id="company_name" class="form-control" value="<?= htmlspecialchars($job['company_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" id="location" class="form-control" value="<?= htmlspecialchars($job['location']) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Job</button>
        </form>
    </div>
</body>
</html>
