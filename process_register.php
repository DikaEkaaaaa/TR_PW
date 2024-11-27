<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT); // Hash password
    $role = $_POST['role'];

    // Masukkan data ke database
    $stmt = $conn->prepare("INSERT INTO tb_users (nama, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $password, $role);

    if ($stmt->execute()) {
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('Registrasi gagal: {$conn->error}'); window.location.href = 'register.php';</script>";
    }
}
?>
