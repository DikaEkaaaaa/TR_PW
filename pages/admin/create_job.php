<?php
session_start();
require '../../db.php';

// Periksa apakah user memiliki role Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $requirements = trim($_POST['requirements']);
    $employment_type = $_POST['employment_type'];
    $salary_range = trim($_POST['salary_range']);
    $company_name = trim($_POST['company_name']);
    $location = trim($_POST['location']);

    // Query untuk menambahkan pekerjaan baru
    $stmt = $conn->prepare("INSERT INTO tb_jobs (title, description, requirements, employment_type, salary_range, company_name, location, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssssss", $title, $description, $requirements, $employment_type, $salary_range, $company_name, $location);

    if ($stmt->execute()) {
        echo "<script>alert('Job added successfully!'); window.location.href = 'admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to add job.'); window.location.href = 'admin_dashboard.php';</script>";
    }
}
?>
