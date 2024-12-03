<?php
session_start();
require '../../db.php';

$job_id = $_GET['job_id'] ?? 0;
$user_id = $_SESSION['user_id'] ?? null;

// Pastikan user sudah login
if (!$user_id) {
    header("Location: login.php");
    exit();
}

// Ambil detail pekerjaan berdasarkan job_id
$job_query = $conn->prepare("SELECT * FROM tb_jobs WHERE id = ?");
$job_query->bind_param("i", $job_id);
$job_query->execute();
$job_result = $job_query->get_result();
$job = $job_result->fetch_assoc();

// Cek apakah profil pengguna sudah lengkap
$profile_query = $conn->prepare("SELECT id FROM tb_profiles WHERE user_id = ?");
$profile_query->bind_param("i", $user_id);
$profile_query->execute();
$profile_result = $profile_query->get_result();
$profile_complete = $profile_result->num_rows > 0; // True jika profil sudah ada

// Ambil status aplikasi untuk pekerjaan ini
$app_status_query = $conn->prepare("SELECT status FROM tb_applications WHERE job_id = ? AND user_id = ?");
$app_status_query->bind_param("ii", $job_id, $user_id);
$app_status_query->execute();
$app_status_result = $app_status_query->get_result();
$app_status = $app_status_result->fetch_assoc();

// Memastikan salary_range diparse dengan benar
$salary_raw = $job['salary_range'];

// Hapus karakter non-numerik (kecuali titik desimal) dan parse sebagai float
$salary_clean = preg_replace('/[^0-9.]/', '', $salary_raw);
$salary = floatval($salary_clean);

// Format gaji menjadi format Rupiah
$salary_formatted = "Rp " . number_format($salary, 0, ',', '.');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .job-details {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-container {
            margin-top: 20px;
        }
        .alert-warning {
            margin-top: 20px;
        }
        .btn-group {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .detail-label {
            font-weight: bold;
        }
        .detail-value {
            text-align: right;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <!-- Header Section -->
    <div class="text-center mb-4">
        <h2 class="mb-3">Job Application Detail</h2>
        <p class="lead">Make sure to review the job details before applying</p>
    </div>

    <!-- Job Details Section -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="job-details">
                <h4 class="text-center"><?= htmlspecialchars($job['title']) ?></h4>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <p class="detail-label">Company:</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-value"><?= htmlspecialchars($job['company_name']) ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p class="detail-label">Location:</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-value"><?= htmlspecialchars($job['location']) ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p class="detail-label">Employment Type:</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-value"><?= htmlspecialchars($job['employment_type']) ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p class="detail-label">Salary:</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-value"><?= $salary_formatted ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p class="detail-label">Requirements:</p>
                        </div>
                        <div class="col-6">
                            <p class="detail-value"><?= htmlspecialchars($job['requirements'])?></p>
                        </div>
                    </div>
                </div>
                <hr>
                <h5>Description:</h5>
                <p><?= nl2br(htmlspecialchars($job['description'])) ?></p>

                <!-- Status Aplikasi -->
                <div class="mb-3">
                    <h5 class="detail-value">Status: <?= $app_status['status'] ?? 'No application found' ?></h5>
                </div>

                <div class="btn-container">
                    <!-- Cek apakah profil lengkap -->
                    <?php if (!$profile_complete): ?>
                        <div class="alert alert-warning">
                            <strong>Your profile is incomplete. Please complete your profile to apply for this job.</strong>
                            <br>
                            <a href="profile.php" class="btn btn-warning">Complete Profile</a>
                        </div>
                    <?php else: ?>
                        <!-- Tombol sesuai status aplikasi -->
                        <div class="btn-group">
                            <?php if (empty($app_status)): ?>
                                <!-- Tombol Apply Now jika belum melamar -->
                                <a href="apply.php?job_id=<?= $job['id'] ?>" class="btn btn-primary">Apply Now</a>
                            <?php elseif ($app_status['status'] == 'Pending'): ?>
                                <a href="remove_apply.php?job_id=<?= $job['id'] ?>" class="btn btn-danger">Remove Apply</a>
                            <?php elseif ($app_status['status'] == 'Accepted'): ?>
                                <button class="btn btn-success" disabled>You Have Been Accepted</button>
                            <?php elseif ($app_status['status'] == 'Rejected'): ?>
                                <button class="btn btn-danger" disabled>You Have Been Rejected</button>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Tombol kembali ke daftar pekerjaan -->
                    <a href="index.php" class="btn btn-secondary btn-group mt-3">Back to Job List</a>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
