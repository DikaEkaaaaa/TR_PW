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
            /* background: linear-gradient(120deg, #2b5876, #4e4376); */
            background-color: #2b5876;
            height: 100vh;
            padding: 10px;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 35px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .login-card h1 {
            font-size: 2rem;
            font-weight: bold;
            /* color: #333; */
            color: #4e4376;
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

        .login-card .btn-link-custom {
            text-align: center;
            color: #777;
        }

        .login-card .btn-link-custom:hover {
            color: #4e4376;
            text-decoration: underline;
        }

        .login-card .form-control {
            border-radius: 25px;
            padding: 10px 0px 10px 20px;
            font-size: 1rem;
        }

        .login-card .form-submit {
            background-color: #4e4376;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: bold;
            padding: 10px;
            color: #ffffff;
        }

        .login-card .form-control:focus {
            box-shadow: 0px 0px 10px rgba(72, 107, 204, 0.4);
            /* border-color: #4e4376; */
            border-color: rgba(72, 107, 204, 0.6);
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
                    <input placeholder="John Doe" type="text" name="nama" id="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input placeholder="*******" type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="mt-4">
                    <button type="submit" class="form-submit btn btn-primary w-100">Login</button>
                    <a href="register.php" class="btn btn-link-custom w-100 mt-3 fs-6 fw-normal">Don't have an account? Register</a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>