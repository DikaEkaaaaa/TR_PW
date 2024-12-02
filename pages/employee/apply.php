<?php
session_start();
include '../../components/logout_button.php';
require '../../db.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil user_id dari session
$user_id = $_SESSION['user_id'];

// Cek apakah user sudah mengisi profile
$profile_check = $conn->prepare("SELECT id FROM tb_profiles WHERE user_id = ?");
$profile_check->bind_param("i", $user_id);
$profile_check->execute();
$profile_result = $profile_check->get_result();

// Jika profile belum diisi, redirect ke halaman profile
if ($profile_result->num_rows == 0) {
    header("Location: profile.php");  // Arahkan ke halaman profile untuk mengisi data
    exit();
}

// Ambil ID pekerjaan yang dipilih
$job_id = $_GET['job_id'] ?? null;

if ($job_id) {
    // Periksa apakah pekerjaan sudah dilamar
    $check_application = $conn->prepare("SELECT id FROM tb_applications WHERE job_id = ? AND user_id = ?");
    $check_application->bind_param("ii", $job_id, $user_id);
    $check_application->execute();
    $application_result = $check_application->get_result();

    // Jika belum melamar, lakukan pendaftaran
    if ($application_result->num_rows == 0) {
        $insert_application = $conn->prepare("INSERT INTO tb_applications (user_id, job_id, status) VALUES (?, ?, 'Pending')");
        $insert_application->bind_param("ii", $user_id, $job_id);
        if ($insert_application->execute()) {
            echo '<script>alert("Success apply job"); window.location.href="index.php";</script>';
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "<script>alert('Anda sudah melamar pekerjaan ini.'); window.location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('Pekerjaan tidak ditemukan.'); window.location.href='index.php';</script>";
}
?>
