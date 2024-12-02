<?php
session_start();
include '../../components/logout_button.php';
require '../../db.php';

// Query untuk mengambil data pekerjaan berdasarkan filter
$employment_type = $_GET['employment_type'] ?? '';
$query = "SELECT * FROM tb_jobs WHERE status = 'active'";
if (!empty($employment_type)) {
    $query .= " AND employment_type = '$employment_type'";
}
$query .= " ORDER BY created_at DESC";
$result = $conn->query($query);

// Cek apakah user sudah melamar pekerjaan tertentu
$user_id = $_SESSION['user_id'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .job-list {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="container-fluid text-center bg-dark text-white py-5">
        <h1>Welcome to Job Portal</h1>
        <p>Find Your Dream Job</p>
        <?php if (isset($_SESSION['user_id'])): ?>
            <h4>Welcome, <?= $_SESSION['nama'] ?></h4>
            <a href="profile.php" class="btn btn-light">View Profile</a>
        <?php else: ?>
            <a href="login.php" class="btn btn-primary">Login to Apply</a>
        <?php endif; ?>
    </div>

    <!-- Filter Section -->
    <div class="container my-5">
        <form method="GET" action="">
            <div class="row">
                <div class="col-md-3">
                    <select name="employment_type" class="form-select">
                        <option value="">All Jobs</option>
                        <option value="intern" <?= $employment_type == 'intern' ? 'selected' : '' ?>>Internship</option>
                        <option value="full-time" <?= $employment_type == 'full-time' ? 'selected' : '' ?>>Full-Time</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Job List Section -->
    <div class="container">
        <h2 class="text-center mb-4">Available Jobs</h2>
        <div class="row">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    // Cek apakah user sudah melamar pekerjaan ini
                    $job_id = $row['id'];
                    $check_application = $conn->prepare("SELECT id FROM tb_applications WHERE job_id = ? AND user_id = ?");
                    $check_application->bind_param("ii", $job_id, $user_id);
                    $check_application->execute();
                    $application_result = $check_application->get_result();
                    ?>

                    <div class="col-md-4 mb-4">
                        <div class="card job-list shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                                <p class="card-text"><strong>Company:</strong> <?= htmlspecialchars($row['company_name']) ?></p>
                                <p class="card-text"><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
                                <p class="card-text"><strong>Type:</strong> <?= htmlspecialchars($row['employment_type']) ?></p>
                                <p class="card-text"><strong>Salary:</strong> <?= htmlspecialchars($row['salary_range']) ?></p>

                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <?php if ($application_result->num_rows > 0): ?>
                                        <!-- Jika sudah melamar, tampilkan View Detail dan nonaktifkan Apply -->
                                        <a href="view_application_detail.php?job_id=<?= $row['id'] ?>" class="btn btn-secondary">View Detail</a>
                                    <?php else: ?>
                                        <!-- Jika belum melamar, tampilkan tombol Apply -->
                                        <a href="apply.php?job_id=<?= $row['id'] ?>" class="btn btn-primary">Apply Now</a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="login.php" class="btn btn-primary">Login to Apply</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">No jobs available at the moment. Please check back later!</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
