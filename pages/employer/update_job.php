<?php
session_start();
require '../../db.php';

// Periksa apakah user memiliki role Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Employer') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $job_id = $_POST['id'] ?? 0;
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $requirements = trim($_POST['requirements']);
    $employment_type = $_POST['employment_type'];
    $salary_range = trim($_POST['salary_range']);
    $company_name = trim($_POST['company_name']);
    $location = trim($_POST['location']);

    // Validasi input
    if (empty($title) || empty($description) || empty($requirements) || empty($employment_type) || empty($company_name) || empty($location)) {
        echo "<script>alert('All fields are required.'); window.location.href = 'edit_job.php?id=$job_id';</script>";
        exit();
    }

    // Update pekerjaan di database
    $stmt = $conn->prepare("UPDATE tb_jobs SET title = ?, description = ?, requirements = ?, employment_type = ?, salary_range = ?, company_name = ?, location = ? WHERE id = ?");
    $stmt->bind_param("sssssssi", $title, $description, $requirements, $employment_type, $salary_range, $company_name, $location, $job_id);

    if ($stmt->execute()) {
        echo "<script>alert('Job updated successfully!'); window.location.href = 'admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to update job. Please try again.'); window.location.href = 'edit_job.php?id=$job_id';</script>";
    }
}
?>
