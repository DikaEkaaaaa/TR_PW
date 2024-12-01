<?php
session_start();
require '../../db.php';

// Periksa apakah user sudah login dan memiliki role Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    echo "<script>alert('You are not logged in as an Admin. Please log in.'); window.location.href = '../../login.php';</script>";
    exit();
}

// Pastikan session 'nama' ada sebelum melanjutkan
if (!isset($_SESSION['nama'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href = '../../login.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $job_id = $_POST['id'] ?? 0;
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $requirements = trim($_POST['requirements']);
    $employment_type = $_POST['employment_type'];
    $salary_range = trim($_POST['salary_range']);
    $company_name = trim($_POST['company_name']);
    $location = trim($_POST['location']);
    $status = trim($_POST['status']);
    $updated_by = $_SESSION['nama']; // Ambil 'nama' dari session

    // Validasi input
    if (empty($title) || empty($description) || empty($requirements) || empty($employment_type) || empty($company_name) || empty($location)) {
        echo "<script>alert('All fields are required.'); window.location.href = 'edit_job.php?id=$job_id';</script>";
        exit();
    }

    // Update pekerjaan di database
    $stmt = $conn->prepare("UPDATE tb_jobs SET title = ?, description = ?, requirements = ?, employment_type = ?, salary_range = ?, company_name = ?, location = ?, status = ? WHERE id = ?");
    $stmt->bind_param("ssssssssi", $title, $description, $requirements, $employment_type, $salary_range, $company_name, $location, $status, $job_id);

    if ($stmt->execute()) {
        // Insert riwayat ke tabel tb_job_history
        $history_stmt = $conn->prepare("INSERT INTO tb_job_history (job_id, title, status, updated_by) VALUES (?, ?, ?, ?)");
        $history_stmt->bind_param("isss", $job_id, $title, $status, $updated_by);
        $history_stmt->execute();

        echo "<script>alert('Job updated successfully!'); window.location.href = 'admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to update job. Please try again.'); window.location.href = 'edit_job.php?id=$job_id';</script>";
    }
}
?>
