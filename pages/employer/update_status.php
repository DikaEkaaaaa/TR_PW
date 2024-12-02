<?php
session_start();
require '../../db.php';

// Cek apakah ada ID pelamar dan status yang valid
if (!isset($_GET['id']) || !isset($_GET['status']) || !in_array($_GET['status'], ['Accepted', 'Rejected'])) {
    echo "Invalid request!";
    exit();
}

$applicant_id = $_GET['id'];
$status = $_GET['status'];

// Query untuk mengupdate status pelamar
$stmt = $conn->prepare("UPDATE tb_applications SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $applicant_id);
$stmt->execute();

// Setelah update, alihkan ke halaman yang sama
header("Location: view_applicants.php?job_id=" . $_GET['job_id']);
exit();
