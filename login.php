<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom background styling */
        body {
            background: linear-gradient(120deg, #2b5876, #4e4376);
            height: 100vh;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .login-card h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }

        .login-card .form-label {
            color: #555;
        }

        .login-card .btn {
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .login-card .btn-primary {
            background-color: #4e4376;
            border: none;
        }

        .login-card .btn-primary:hover {
            background-color: #2b5876;
        }

        .login-card .btn-link {
            text-align: center;
            font-size: 1rem;
            color: #777;
        }

        .login-card .btn-link:hover {
            color: #4e4376;
        }

        .login-card .form-control {
            border-radius: 25px;
            padding: 20px;
        }

        .login-card .form-control:focus {
            box-shadow: 0 0 8px rgba(72, 107, 204, 0.6);
            border-color: #4e4376;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">

    <div class="login-card">
        <div class="card-body">
            <h1 class="card-title text-center mb-4">Login</h1>
            <form action="process_login.php" method="POST">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <a href="register.php" class="btn btn-link w-100 mt-3">Don't have an account? Register</a>
            </form>
        </div>
    </div>

</body>
</html>
