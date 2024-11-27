<?php
session_start();
require '../../db.php';

// Periksa apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $requirements = trim($_POST['requirements']);
    $employment_type = $_POST['employment_type'];
    $salary_range = trim($_POST['salary_range']);
    $company_name = trim($_POST['company_name']);
    $location = trim($_POST['location']);
    $created_by = $_SESSION['user_id'];

    // Insert ke database
    $stmt = $conn->prepare("INSERT INTO tb_jobs (title, description, requirements, employment_type, salary_range, company_name, location, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssi", $title, $description, $requirements, $employment_type, $salary_range, $company_name, $location, $created_by);

    if ($stmt->execute()) {
        echo "<script>alert('Job created successfully!'); window.location.href = 'dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to create job: {$conn->error}'); window.location.href = 'dashboard.php';</script>";
    }
}
?>
