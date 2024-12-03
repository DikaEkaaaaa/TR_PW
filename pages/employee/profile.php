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
    <div class="container pt-5">
        <h3>Personal info</h3>
        <form method="POST" role="form" class="gap-3 row" action="profile_process.php">
            <div class="row">
                <div class="col-2">
                    <label for="full_name" class="col-form-label">Full Name</label>
                </div>
                <div class="col-5">
                    <input type="text" class="form-control" name="full_name" value="<?= $profile['full_name'] ?? '' ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-2">
                    <label for="email" class="col-form-label">Email</label>
                </div>
                <div class="col-5">
                    <input type="email" class="form-control" name="email" value="<?= $profile['email'] ?? '' ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label for="phone_number" class="col-form-label">Phone Number</label>
                </div>
                <div class="col-5">
                    <input type="text" class="form-control" name="phone_number" value="<?= $profile['phone_number'] ?? '' ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label for="address" class="col-form-label">Address</label>
                </div>
                <div class="col-5">
                    <textarea class="form-control" name="address"><?= $profile['address'] ?? '' ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label for="experience" class="col-form-label">Experience</label>
                </div>
                <div class="col-5">
                    <textarea class="form-control" name="experience"><?= $profile['experience'] ?? '' ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label for="skills" class="row-form-label">Skills</label>
                </div>
                <div class="col-5">
                    <textarea class="form-control" name="skills"><?= $profile['skills'] ?? '' ?></textarea>
                </div>
            </div>
            <button type="submit" class="mt-5 col-auto btn btn-primary">Save Profile</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>