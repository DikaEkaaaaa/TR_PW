<?php
session_start();
include '../../components/logout_button.php';
require '../../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$employment_type = $_GET['employment_type'] ?? '';
$query = "SELECT * FROM tb_jobs WHERE status = 'active'";
if (!empty($employment_type)) {
    $query .= " AND employment_type = '$employment_type'";
}
$query .= " ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header-section {
            background: linear-gradient(90deg, #1e3c72, #2a5298);
            color: white;
            min-height: 200px;
            display: flex;
            justify-content: start;
            align-items: center;
            padding: 0px 20px;
            border-bottom: 3px solid #333;
        }

        .header-section h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .header-section p {
            font-size: 1.25rem;
        }

        .job-list {
            background-color: #fff;
            padding: 10px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .job-list:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-body p {
            font-size: 1rem;
        }

        .btn-primary,
        .btn-info {
            border-radius: 25px;
            padding: 5px 20px;
            /* width: 30%; */
        }

        .filter-section {
            /* margin: 40px 40px; */
            padding: 20px 20px;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 30px 0;
            text-align: center;
            margin-top: 40px;
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
            /* flex-wrap: wrap; */
            /* gap: 10px; */
        }

        .job-kapsul {
            font-size: .7rem;
            padding-left: 10px;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-right: 10px;
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
            width: 100%;
            border-radius: 25px;
            text-decoration: none;
        }

        .btn-custom-apply:hover {
            background-color: #0056b3;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container-fluid header-section">
        <div>

            <?php if (isset($_SESSION['user_id'])): ?>
                <h4>Hello, <?= $_SESSION['nama'] ?></h4>
                <a href="profile.php" class="btn btn-primary">View Profile</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary">Login to Apply</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="container filter-section">
        <form method="GET" action="">
            <div class="row gap-2">
                <div class="col-md-3">
                    <select name="employment_type" class="form-select">
                        <option value="">All Jobs</option>
                        <option value="intern" <?= $employment_type == 'intern' ? 'selected' : '' ?>>Internship</option>
                        <option value="full-time" <?= $employment_type == 'full-time' ? 'selected' : '' ?>>Full-Time</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
    </div>

    <div class="container">
        <h2 class="text-center mb-4">Available Jobs</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    $job_id = $row['id'];
                    $check_application = $conn->prepare("SELECT id FROM tb_applications WHERE job_id = ? AND user_id = ?");
                    $check_application->bind_param("ii", $job_id, $user_id);
                    $check_application->execute();
                    $application_result = $check_application->get_result();
                    ?>

                    <div class="col">
                        <div class="">
                            <div class="card-job">
                                <div class="mb-3">
                                    <h5 style="margin:0;text-transform: uppercase;" class="mt-2"><?= htmlspecialchars($row['title']) ?></h5>
                                    <p style="margin:0;color: rgba(0,0,0,0.5);font-size:.8rem;" class="fw-semibold"><?= htmlspecialchars($row['company_name']) ?></p>
                                    <div class="mt-5 container-job-kapsul justify-content-between">
                                        <p class="job-kapsul">Location: <?= htmlspecialchars($row['location']) ?></p>
                                        <p class="job-kapsul">Type: <?= htmlspecialchars($row['employment_type']) ?></p>
                                        <p class="job-kapsul">Salary: Rp. <?= htmlspecialchars(number_format($row['salary_range'])) ?></p>
                                    </div>
                                    <?php if (isset($_SESSION['user_id'])): ?>
                                        <a href="view_application_detail.php?job_id=<?= $row['id'] ?>" class="mt-2 btn btn-custom-apply mt-3">View Detail</a>
                                    <?php else: ?>
                                        <a href="login.php" class="mt-2 btn btn-custom-apply mt-3">Login to Apply</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="card job-list shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                                <p class="card-text"><strong>Company:</strong> <?= htmlspecialchars($row['company_name']) ?></p>
                                <p class="card-text"><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
                                <p class="card-text"><strong>Type:</strong> <?= htmlspecialchars($row['employment_type']) ?></p>
                                <p class="card-text"><strong>Salary:</strong> <?= htmlspecialchars($row['salary_range']) ?></p>

                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="view_application_detail.php?job_id=<?= $row['id'] ?>" class="btn btn-info">View Detail</a>
                                <?php else: ?>
                                    <a href="login.php" class="btn btn-primary">Login to Apply</a>
                                <?php endif; ?>
                            </div>
                        </div> -->
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">No jobs available at the moment. Please check back later!</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="footer">
        <p>&copy; 2024 Job Portal. All Rights Reserved.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>