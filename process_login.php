<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim(htmlspecialchars($_POST['nama'])); // Filter input
    $password = trim($_POST['password']);

    // Periksa apakah input kosong
    if (empty($nama) || empty($password)) {
        echo "<script>alert('Nama dan password harus diisi!'); window.location.href = 'login.php';</script>";
        exit();
    }

    // Gunakan prepared statement untuk keamanan
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
                header("Location: pages/admin/admin_dashboard.php");
            } elseif ($user['role'] === 'Employer') {
                header("Location: pages/employer/dashboard.php");
            } else {
                header("Location: pages/employee/index.php");
            }
            exit();
        }
    }

    // Pesan kesalahan generik
    echo "<script>alert('Nama pengguna atau password salah!'); window.location.href = 'login.php';</script>";
}
?>
