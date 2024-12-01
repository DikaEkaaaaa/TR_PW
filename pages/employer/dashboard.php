<?php
session_start();
require '../../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Employer') {
    header("Location: login.php");
    exit();
}

$created_by = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM tb_jobs WHERE created_by = ?");
$stmt->bind_param("i", $created_by);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Employer Dashboard</h1>
        
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">Create Job</h2>
                <form action="add.php" method="POST">
                    <button type="submit" class="btn btn-primary w-100">Add Job</button>
                </form>
            </div>
        </div>

        <!-- Daftar Lowongan -->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">Your Jobs</h2>
                <?php if ($result->num_rows > 0): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Employment Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($job = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $job['id'] ?></td>
                                    <td><?= htmlspecialchars($job['title']) ?></td>
                                    <td><?= $job['employment_type'] ?></td>
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
                    <p>No jobs created yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
