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
        body {
            background-color: #f2f2f2;
        }

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

        .card-job {
            border: 2px solid rgba(0, 0, 0, 0.1);
            background-color: white;
            padding: 10px 10px 10px 20px;
            border-radius: 20px;
            transition: all 0.3s ease-in-out;
        }



        .container-job-kapsul {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .job-kapsul {
            font-size: .7rem;
            padding-left: 20px;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-right: 20px;
            border-radius: 8px;
            margin: 0;
            border: 1px solid rgba(0, 0, 0, 0.1);
            /* box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); */
            transition: all 0.3s ease-in-out;
        }

        .job-kapsul:hover {
            background-color: #4e4376;
            color: white;
        }

        .btn-custom-apply {
            background-color: #4e4376;
            color: white;
            font-size: .8rem;
            padding: 10px 20px;
            width:100%;
            border-radius: 25px;
            text-decoration: none;
        }

        .btn-custom-apply:hover {
            background-color: #0056b3;
            color: white;
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
            <div class="text-center mb-5">
                <h2 class="fs-1">Available Jobs</h2>
                <p style="color: rgba(0,0,0,0.6)">Browse through a variety of job opportunities and find the perfect fit for you.</p>
            </div>
            <div class="row justify-content-center mt-5 gap-4">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="col-md-5">
                            <div class="card-job">
                                <div class="mb-3">
                                    <h5 style="margin:0;text-transform: uppercase;" class="mt-2"><?= htmlspecialchars($row['title']) ?></h5>
                                    <p style="margin:0;color: rgba(0,0,0,0.5);font-size:.8rem;" class="fw-semibold"><?= htmlspecialchars($row['company_name']) ?></p>
                                    <div class="mt-5 container-job-kapsul justify-content-between">
                                        <p class="job-kapsul">Location: <?= htmlspecialchars($row['location']) ?></p>
                                        <p class="job-kapsul">Type: <?= htmlspecialchars($row['employment_type']) ?></p>
                                        <p class="job-kapsul">Salary: Rp. <?= htmlspecialchars(number_format($row['salary_range'])) ?></p>
                                    </div>
                                    <a href="login.php" class="mt-2 btn btn-custom-apply mt-3">Apply Now</a>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-4 mb-4">
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
                        </div> -->
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