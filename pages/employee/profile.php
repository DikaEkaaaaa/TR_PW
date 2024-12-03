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
    <style>
        body {
            background-color: #f8f9fa;
        }

        .profile-container {
            display: flex;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 1500px;
            margin: 0 auto;
        }

        .gradient-section {
            flex: 1;
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            padding: 50px;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }

        .gradient-section h2 {
            font-size: 2.2rem;
            margin-bottom: 15px;
        }

        .gradient-section p {
            font-size: 1.1rem;
            margin-top: 10px;
        }

        .form-section {
            flex: 2;
            padding: 50px;
        }

        .right-section {
            flex: 1.5;
            padding: 40px;
            background-color: #f1f1f1;
            border-left: 2px solid #e0e0e0;
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            margin-bottom: 15px;
        }

        .form-header h3 {
            font-size: 1.9rem;
            font-weight: bold;
        }

        .form-header p {
            color: #6c757d;
            font-size: 1rem;
        }

        .form-group label {
            font-weight: bold;
        }

        .example-section h5 {
            font-size: 1.3rem;
            color: #333;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .example-section ul {
            padding-left: 25px;
        }

        .example-section ul li {
            font-size: 1rem;
            margin-bottom: 12px;
        }

        .example-section ul li span {
            font-weight: bold;
            color: #007bff;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="profile-container">
            <!-- Gradient Section -->
            <div class="gradient-section">
                <h2>Welcome to Your Profile</h2>
                <p>Keep your information up-to-date and manage your profile effectively.</p>
            </div>

            <!-- Form Section -->
            <div class="form-section">
                <div class="form-header">
                    <img src="https://via.placeholder.com/90" alt="Profile Picture">
                    <h3>Your Profile</h3>
                    <p>Manage and update your personal information here.</p>
                </div>

                <form method="POST" action="profile_process.php">
                    <!-- Personal Information Section -->
                    <div class="mb-4">
                        <h5>Personal Information</h5>
                        <div class="mb-3 row">
                            <label for="full_name" class="col-3 col-form-label">Full Name</label>
                            <div class="col-9">
                                <input type="text" class="form-control" name="full_name" value="<?= $profile['full_name'] ?? '' ?>" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="email" class="col-3 col-form-label">Email</label>
                            <div class="col-9">
                                <input type="email" class="form-control" name="email" value="<?= $profile['email'] ?? '' ?>" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="phone_number" class="col-3 col-form-label">Phone Number</label>
                            <div class="col-9">
                                <input type="text" class="form-control" name="phone_number" value="<?= $profile['phone_number'] ?? '' ?>" required>
                            </div>
                        </div>
                    </div>

                    <!-- Address Section -->
                    <div class="mb-4">
                        <h5>Address</h5>
                        <div class="mb-3 row">
                            <label for="address" class="col-3 col-form-label">Address</label>
                            <div class="col-9">
                                <textarea class="form-control" name="address" rows="3"><?= $profile['address'] ?? '' ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Information Section -->
                    <div class="mb-4">
                        <h5>Professional Information</h5>
                        <div class="mb-3 row">
                            <label for="experience" class="col-3 col-form-label">Experience</label>
                            <div class="col-9">
                                <textarea class="form-control" name="experience" rows="3"><?= $profile['experience'] ?? '' ?></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="skills" class="col-3 col-form-label">Skills</label>
                            <div class="col-9">
                                <textarea class="form-control" name="skills" rows="3"><?= $profile['skills'] ?? '' ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-5">Save Profile</button>
                    </div>
                </form>
            </div>

            <!-- Example Section -->
            <div class="right-section">
                <div class="example-section">
                    <h5>Example of Proper Form Filling</h5>
                    <ul>
                        <li><span>Full Name:</span> John Doe</li>
                        <li><span>Email:</span> john.doe@example.com</li>
                        <li><span>Phone Number:</span> 08123456789</li>
                        <li><span>Address:</span> 123 Main Street, Jakarta, Indonesia</li>
                        <li><span>Experience:</span> 5 years in software development</li>
                        <li><span>Skills:</span> PHP, Laravel, JavaScript, React.js</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
