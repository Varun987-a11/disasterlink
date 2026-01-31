<?php
session_start();
include '../includes/config.php'; // Path preserved

// Handle login submission - LOGIC UNTOUCHED
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header("Location: ../admin/dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Portal | DisasterLink</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --dl-admin-dark: #0f172a;
            --dl-admin-accent: #334155;
            --dl-primary: #00bcd4;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            background: white;
            border: none;
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            width: 100%;
            max-width: 420px;
            overflow: hidden;
        }

        .card-header-custom {
            background-color: var(--dl-admin-dark);
            padding: 40px 20px;
            text-align: center;
            color: white;
        }

        .card-header-custom i {
            font-size: 2.5rem;
            color: var(--dl-primary);
            margin-bottom: 10px;
            display: block;
        }

        .card-header-custom h3 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.02em;
        }

        .card-body {
            padding: 40px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--dl-admin-accent);
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: var(--dl-primary);
            box-shadow: 0 0 0 4px rgba(0, 188, 212, 0.1);
        }

        .btn-login {
            background-color: var(--dl-admin-dark);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: #1e293b;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.15);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: var(--dl-primary);
        }

        .alert-danger {
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 500;
            border: none;
            background-color: #fef2f2;
            color: #b91c1c;
            padding: 12px;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="login-card">
        <div class="card-header-custom">
            <i class="bi bi-shield-lock-fill"></i>
            <h3>Admin Access</h3>
            <p class="small text-white-50 mb-0 mt-2">DisasterLink Management Portal</p>
        </div>

        <div class="card-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger mb-4">
                    <i class="bi bi-exclamation-circle-fill me-2"></i><?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST" autocomplete="off">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="username" name="username" required autofocus>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-login">
                    Sign In to Dashboard
                </button>
            </form>

            <a href="../index.php" class="back-link">
                <i class="bi bi-arrow-left me-1"></i> Back to Public Site
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>