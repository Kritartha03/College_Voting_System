<?php
include('../main/connect.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#" style="font-size: x-small;">
                        <?php 
                            session_start();
                            echo $_SESSION['email'];
                        ?>
                    </a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="admin-index.php" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>New Election</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="verify.php" class="sidebar-link">
                        <i class="lni lni-agenda"></i>
                        <span>Manage Candidate</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="position.php" class="sidebar-link">
                        <i class="lni lni-agenda"></i>
                        <span>Manage Positions</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="courses.php" class="sidebar-link">
                        <i class="lni lni-agenda"></i>
                        <span>Manage Courses</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-popup"></i>
                        <span>Notification</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="result.php" class="sidebar-link">
                        <i class="lni lni-popup"></i>
                        <span>Results</span>
                    </a>
                </li>
            </ul>
            <li class="sidebar-item">
                    <a href="admin-pass.php" class="sidebar-link">
                        <i class="lni lni-cog"></i>
                        <span>Change Password</span>
                    </a>
                </li>
                <?php if(isset($_SESSION['email'])): ?>
            <div class="sidebar-footer">
                <a href="../index.php?logout=true" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
            <?php endif; ?>
        </aside>
        <main class="content px-3 py-4">
            <?php include('position.php');?>                
        </main>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>