<?php
require 'db.php';

// Query untuk mengambil data pekerjaan yang aktif dan belum expired
$query = "SELECT id, title, company_name, location, employment_type, salary_range 
            FROM tb_jobs 
            WHERE status = 'active'
            ORDER BY created_at DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Header Section */
        .header {
            height: 100vh;
            display: flex;
            padding: 10px 50px;
            justify-content: start;
            align-items: center;
            text-align: left;
            color: #fff;
            border-bottom-left-radius: 100px;
            border-bottom-right-radius: 100px;
            background: linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.7)),
                url('src/photos/background.jpg') no-repeat center center;
            /* background: url('src/photos/background.jpg') no-repeat center center; */
            background-size: cover;
        }

        .header div {
            max-width: 600px;
        }

        .header h1 {
            font-size: 3rem;
        }

        .btn-custom {
            background-color: #4e4376;
            color: white;
            font-size: 1rem;
            padding: 10px 20px;
            width: 250px;
            border-radius: 25px;
            text-decoration: none;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        /* Job List Section */
        .job-section {
            background-color: #f8f9fa;
            /* Soft gray background */
            padding: 50px 20px;
        }

        .job-list {
            background-color: #fff;
            /* White card background */
            padding: 20px;
            border-radius: 10px;
        }

        .job-list .card {
            border: none;
            /* Remove card border */
            margin-bottom: 20px;
            transition: transform 0.2s;
        }

        .job-list .card:hover {
            transform: translateY(-5px);
            /* Slight lift on hover */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .header {
                background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)),
                url('src/photos/background.jpg') no-repeat center center;
                border-bottom-left-radius: 50px;
                border-bottom-right-radius: 50px;
            }

            .header h1 {
                font-size: 2.5rem;
            }
            .header p {
                color: rgba(225, 225, 225, 0.8);
            }
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <div class="header">
        <div>
            <h1>Unlock Your Future with Our Job Portal</h1>
            <p>Explore countless opportunities and land the career you’ve always dreamed of—tailored to your skills and passions!</p>
            <a href="login.php" class="btn btn-custom">Log in to Get Started!</a>
        </div>
    </div>

    <!-- Job List Section -->
    <div class="job-section">
        <div class="container">
            <h2 class="text-center mb-4">Available Jobs</h2>
            <div class="row">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card job-list shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                                    <p class="card-text"><strong>Company:</strong> <?= htmlspecialchars($row['company_name']) ?></p>
                                    <p class="card-text"><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
                                    <p class="card-text"><strong>Type:</strong> <?= htmlspecialchars($row['employment_type']) ?></p>
                                    <p class="card-text"><strong>Salary:</strong> <?= htmlspecialchars($row['salary_range']) ?></p>
                                    <a href="login.php" class="btn btn-primary">Apply Now</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center">No jobs available at the moment. Please check back later!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>