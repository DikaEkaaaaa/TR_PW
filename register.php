<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom background styling */
        body {
            background: linear-gradient(120deg, #2b5876, #4e4376);
            height: 100vh;
        }

        .register-card {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        .register-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .register-card h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }

        .register-card .form-label {
            color: #555;
        }

        .register-card .btn {
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .register-card .btn-success {
            background-color: #28a745;
            border: none;
        }

        .register-card .btn-success:hover {
            background-color: #218838;
        }

        .register-card .btn-link {
            text-align: center;
            font-size: 1rem;
            color: #777;
        }

        .register-card .btn-link:hover {
            color: #28a745;
        }

        .register-card .form-control {
            border-radius: 25px;
            padding: 20px;
        }

        .register-card .form-control:focus {
            box-shadow: 0 0 8px rgba(72, 107, 204, 0.6);
            border-color: #28a745;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">

    <div class="register-card">
        <div class="card-body">
            <h1 class="card-title text-center mb-4">Register</h1>
            <form action="process_register.php" method="POST">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="Employer">Employer</option>
                        <option value="Employee">Employee</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success w-100">Register</button>
                <a href="login.php" class="btn btn-link w-100 mt-3">Already have an account? Login</a>
            </form>
        </div>
    </div>

</body>
</html>
