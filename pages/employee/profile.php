<?php
session_start();
require '../../db.php';

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM tb_profiles WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>Edit Profile</h2>
        <form method="POST" action="profile_process.php">
            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="full_name" value="<?= $profile['full_name'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?= $profile['email'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="phone_number" value="<?= $profile['phone_number'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" name="address"><?= $profile['address'] ?? '' ?></textarea>
            </div>
            <div class="mb-3">
                <label for="experience" class="form-label">Experience</label>
                <textarea class="form-control" name="experience"><?= $profile['experience'] ?? '' ?></textarea>
            </div>
            <div class="mb-3">
                <label for="skills" class="form-label">Skills</label>
                <textarea class="form-control" name="skills"><?= $profile['skills'] ?? '' ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Profile</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
