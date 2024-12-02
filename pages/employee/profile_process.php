<?php
session_start();
require '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $experience = $_POST['experience'];
    $skills = $_POST['skills'];

    $checkQuery = "SELECT id FROM tb_profiles WHERE user_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $updateQuery = "UPDATE tb_profiles SET full_name = ?, email = ?, phone_number = ?, address = ?, experience = ?, skills = ? WHERE user_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssssssi", $full_name, $email, $phone_number, $address, $experience, $skills, $user_id);
        $stmt->execute();
        echo "<script>alert('Profile updated successfully!'); window.location.href='index.php';</script>";
    } else {
        $insertQuery = "INSERT INTO tb_profiles (user_id, full_name, email, phone_number, address, experience, skills) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("issssss", $user_id, $full_name, $email, $phone_number, $address, $experience, $skills);
        $stmt->execute();
        echo "<script>alert('Profile updated successfully!'); window.location.href='index.php';</script>";
    }
}
