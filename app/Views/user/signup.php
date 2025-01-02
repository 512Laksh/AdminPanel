<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Link to custom CSS -->
    <style>
        body {
            background-color: #f8f9fa; 
        }
        .login-container {
            max-width: 400px; /* Set max width for the form */
            margin: auto; /* Center the form */
            padding: 20px; /* Add padding */
            background-color: white; /* White background for the form */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }
        .login-title {
            margin-bottom: 20px; /* Space below the title */
            text-align: center; /* Center the title */
        }
        .btn-custom {
            background-color: #007bff; /* Custom button color */
            color: white; /* Button text color */
        }
        .btn-custom:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="login-container">
        <h2 class="login-title">Sign Up</h2>
        <form action="<?= base_url("signup")?>" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">User Name</label>
                <input type="text" class="form-control" id="email" name="uname" placeholder="Enter your User Name" required>
                <div class="alert text-danger mb-0"><?= isset($validation) ? $validation->getError('uname') : ''; ?></div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your Email" required>
                <div class="alert text-danger mb-0"><?= isset($validation) ? $validation->getError('email') : ''; ?></div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="pass" placeholder="Enter your password" required>
                <div class="alert text-danger mb-0"><?= isset($validation) ? $validation->getError('pass') : ''; ?></div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Role</label>
                <input type="text" class="form-control" id="password" name="acesslevel" placeholder="Enter your Role" required>
                <div class="alert text-danger mb-0"><?= isset($validation) ? $validation->getError('acesslevel') : ''; ?></div>
            </div>
            <button type="submit" class="btn btn-custom w-100">Sign Up</button>
        </form>
        <div class="mt-3 text-center">
        <a href="<?= base_url('log');?>"><span>Already have an account? </span></a>     
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>