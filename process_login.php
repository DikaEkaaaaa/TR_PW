<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $password = trim($_POST['password']);

    // Gunakan prepared statement
    $stmt = $conn->prepare("SELECT id, nama, password, role FROM tb_users WHERE nama = ?");
    $stmt->bind_param("s", $nama);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['nama'] = $user['nama'];

            // Redirect sesuai role
            if ($user['role'] === 'Admin') {
                header("Location: admin_dashboard.php");
            } elseif ($user['role'] === 'Employer') {
                header("Location: employer_dashboard.php");
            } else {
                header("Location: employee_dashboard.php");
            }
            exit();
        } else {
            echo "<script>alert('Password salah!'); window.location.href = 'login.php';</script>";
        }
    } else {
        echo "<script>alert('Nama tidak ditemukan!'); window.location.href = 'login.php';</script>";
    }
}
?>
