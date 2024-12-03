<?php
session_start();
require '../../db.php';

// Pastikan pengguna login sebagai admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../../login.php");
    exit();
}

$admin_id = $_SESSION['user_id']; // ID admin yang sedang login

// Ambil data dari form
$title = $_POST['title'];
$description = $_POST['description'];
$requirements = $_POST['requirements'];
$employment_type = $_POST['employment_type'];
$salary_range = $_POST['salary_range'];
$company_name = $_POST['company_name'];
$location = $_POST['location'];

// Insert pekerjaan baru dengan `created_by`
$stmt = $conn->prepare("INSERT INTO tb_jobs (title, description, requirements, employment_type, salary_range, company_name, location, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssi", $title, $description, $requirements, $employment_type, $salary_range, $company_name, $location, $admin_id);

if ($stmt->execute()) {
    header("Location: admin_dashboard.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}
?>
