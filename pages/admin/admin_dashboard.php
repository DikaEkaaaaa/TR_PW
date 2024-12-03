<?php
session_start();
include '../../components/logout_button.php';
require '../../db.php';

// Cek apakah user adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../../login.php");
    exit();
}

// Ambil ID admin yang sedang login
$admin_id = $_SESSION['user_id'];

// Ambil pekerjaan yang hanya dibuat oleh admin ini
$stmt = $conn->prepare("SELECT * FROM tb_jobs WHERE created_by = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();

// Ambil riwayat pekerjaan untuk pekerjaan yang dibuat oleh admin ini
$history_stmt = $conn->prepare("
    SELECT h.job_id, h.title, h.status, h.updated_at, h.updated_by 
    FROM tb_job_history h 
    JOIN tb_jobs j ON h.job_id = j.id 
    WHERE j.created_by = ? 
    ORDER BY h.updated_at DESC
");
$history_stmt->bind_param("i", $admin_id);
$history_stmt->execute();
$history_result = $history_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Admin Dashboard</h1>

        <!-- Form Tambah Lowongan -->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">Add New Job</h2>
                <form action="create_job.php" method="POST">
                    <div class="mb-3">
                        <label for="title" class="form-label">Job Title</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Job Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="requirements" class="form-label">Job Requirements</label>
                        <textarea name="requirements" id="requirements" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="employment_type" class="form-label">Employment Type</label>
                        <select name="employment_type" id="employment_type" class="form-select" required>
                            <option value="intern">Intern</option>
                            <option value="full-time">Full-Time</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="salary_range" class="form-label">Salary Range</label>
                        <input type="text" name="salary_range" id="salary_range" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="company_name" class="form-label">Company Name</label>
                        <input type="text" name="company_name" id="company_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" name="location" id="location" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Job</button>
                </form>
            </div>
        </div>

        <!-- Tabel Lowongan Pekerjaan -->
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Manage Jobs</h2>
                <?php if ($result->num_rows > 0): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Employment Type</th>
                                <th>Company Name</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($job = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $job['id'] ?></td>
                                    <td><?= htmlspecialchars($job['title']) ?></td>
                                    <td><?= $job['employment_type'] ?></td>
                                    <td><?= htmlspecialchars($job['company_name']) ?></td>
                                    <td><?= htmlspecialchars($job['location']) ?></td>
                                    <td><?= htmlspecialchars($job['status']) ?></td>
                                    <td>
                                        <a href="edit_job.php?id=<?= $job['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="delete_job.php?id=<?= $job['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                        <a href="view_applicants.php?job_id=<?= $job['id'] ?>" class="btn btn-info btn-sm">View Applicants</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No jobs available.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Riwayat Lowongan -->
        <div class="card mt-4">
            <div class="card-body">
                <h2 class="card-title">Job History</h2>
                <?php if ($history_result->num_rows > 0): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Job ID</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Updated At</th>
                                <th>Updated By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($history = $history_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $history['job_id'] ?></td>
                                    <td><?= htmlspecialchars($history['title']) ?></td>
                                    <td><?= htmlspecialchars($history['status']) ?></td>
                                    <td><?= $history['updated_at'] ?></td>
                                    <td><?= htmlspecialchars($history['updated_by']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No history available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
