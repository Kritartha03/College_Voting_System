<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa; /* Light gray background */
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        .navbar {
            background-color: #007bff; /* Dark blue navbar */
            color: #ffffff; /* White text */
        }

        .navbar-brand img {
            height: 60px;
            width: 70px;
            margin-right: 10px;
        }

        .navbar-nav .nav-link {
            color: #ffffff; /* White text for navbar links */
        }

        .navbar-nav .nav-link:hover {
            color: #f8f9fa; /* Light gray text on hover */
        }

        .functions {
            margin-top: 30px;
        }

        .functions h2 {
            color: #343a40; /* Dark gray heading color */
            margin-bottom: 20px;
        }

        .functions a {
            display: inline-block;
            background-color: #007bff; /* Blue buttons */
            color: #ffffff; /* White text */
            text-decoration: none;
            padding: 12px 24px;
            margin-bottom: 10px;
            border-radius: 30px;
            transition: background-color 0.3s, transform 0.2s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .functions a:hover {
            background-color: #0056b3; /* Darker blue on hover */
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="img2.webp" alt="logo">
                Voting System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            My Profile
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../index.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>Admin Dashboard</h1>
        <div class="functions">
            <h2>Manage Election</h2>
            <a href="admin-index.php">Create Election</a>
            <h2>Manage Candidates</h2>
            <a href="verify.php">Edit Candidate</a>
            <a href="position.php">Position</a>
            <a href="courses.php">Courses</a>
        </div>
        <div class="functions">
            <h2>Voting Results</h2>
            <a href="view_results.php">View Results</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
