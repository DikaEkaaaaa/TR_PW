<?php
session_start();
include '../../components/logout_button.php';
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
    <style>
        .card-custom {
            background-color: white;
            padding: 25px;
            border-radius: 20px;
        }
        .table-custom {
            background-color: white;
            padding: 25px;
            border-radius: 20px;
        }

        .btn-custom {
            border-radius: 25px;
        }
    </style>
</head>

<body class="bg-light">
    <h1 class="text-center my-4">Employer Dashboard</h1>
    <div class="row row-cols-1 p-4 row-cols-sm-2 gap-5 justify-content-center">

        <div class="col col-sm-3">
            <div class="card-custom">
                <div class="-body">
                    <h2 class="fs-4">Expand Your Team</h2>
                    <p style="color:rgba(0,0,0,0.6)" class="m-0  mb-4 fs-6">Find the perfect people to join your company.</p>
                    <form action="add.php" method="POST">
                        <button type="submit" class="btn btn-primary w-100 btn-custom">Post Your Job</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Daftar Lowongan -->
        <div class="col col-sm-7">
            <div class="table-custom">
                <div class="-body">
                    <h2 class="card-title fs-4 mb-4">Your Job List</h2>
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
                                            <a href="edit_job.php?id=<?= $job['id'] ?>" style="border-radius:30px;color:white;padding: 3px 15px;" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="delete_job.php?id=<?= $job['id'] ?>" style="border-radius:30px;color:white;padding: 3px 15px;" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                            <a href="view_applicants.php?job_id=<?= $job['id'] ?>" style="border-radius:30px;color:white;padding: 3px 15px;" class="btn btn-info btn-sm">View Applicants</a>
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
    </div>

</body>

</html>