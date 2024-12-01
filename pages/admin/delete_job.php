<?php
session_start();
require '../../db.php';

// Periksa apakah user sudah login dan memiliki role Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    echo "<script>alert('You are not logged in as an Admin. Please log in.'); window.location.href = '../../login.php';</script>";
    exit();
}

// Pastikan session 'nama' ada sebelum melanjutkan
if (!isset($_SESSION['nama'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href = '../../login.php';</script>";
    exit();
}

// Ambil ID pekerjaan yang ingin dihapus
$job_id = $_GET['id'] ?? 0;

if ($job_id) {
    // Cek apakah pekerjaan dengan ID tersebut ada
    $stmt = $conn->prepare("SELECT * FROM tb_jobs WHERE id = ?");
    $stmt->bind_param("i", $job_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Hapus pekerjaan dari tb_jobs
        $delete_stmt = $conn->prepare("DELETE FROM tb_jobs WHERE id = ?");
        $delete_stmt->bind_param("i", $job_id);

        // Jika penghapusan pekerjaan berhasil
        if ($delete_stmt->execute()) {
            // Hapus riwayat pekerjaan di tb_job_history
            $history_stmt = $conn->prepare("DELETE FROM tb_job_history WHERE job_id = ?");
            $history_stmt->bind_param("i", $job_id);
            $history_stmt->execute();

            echo "<script>alert('Job deleted successfully!'); window.location.href = 'admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Failed to delete job. Please try again.'); window.location.href = 'admin_dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('Job not found.'); window.location.href = 'admin_dashboard.php';</script>";
    }
} else {
    echo "<script>alert('Invalid job ID.'); window.location.href = 'admin_dashboard.php';</script>";
}
?>
