<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        /* Add custom styles here */
        .collapse{
            justify-content: center;
            padding-left: 52%;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">

<div class="container-fluid">
    <img src="img2.webp" alt="logo" height="60px" width="70px">&nbsp;
  <h2>Voting System</h2>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link active text-dark" aria-current="page" href="admin/index.php">Back</a>
      </li>
  </div>
</div>
</nav>
    <div class="container mt-5">
        <center><h2>Students Data</h2></center><br>

        <!-- Search Form -->
        <form method="GET" action="student-list.php" class="mb-5">
            <div class="row g-3 align-items-center">
                <div class="col-lg-7">
                    <input type="text" class="form-control" id="search" name="search" placeholder="Search">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
                <div class="col-auto">
            <button type="submit" class="btn btn-danger" name="delete_all" onclick="return confirmDeleteAll()">Delete All</button>
        </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email ID</th>
                    <th>Roll No.</th>
                    <th>Department</th>
                    <th>Semester</th>
                    <th>Action</th>
                    <!-- Add more table headers if needed -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Connect to the database
                $servername = "localhost";
                $username = "your_username";
                $password = "your_password";
                $database = "votingsystem";
                $conn = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Check if the "Delete All" button is clicked
if(isset($_GET['delete_all'])) {
    // Truncate the students table
    $sql_truncate = "TRUNCATE TABLE students";
    if ($conn->query($sql_truncate) === TRUE) {
        echo '<script>alert("All records deleted successfully!");</script>';
    } else {
        echo '<script>alert("Error deleting records: ' . $conn->error . '");</script>';
    }
}

                // Query to fetch data from the students table and join with the courses table
                $sql = "SELECT students.student_id, students.username, students.email_id, students.roll_no, courses.department, students.semester
                        FROM students 
                        INNER JOIN courses ON students.course = courses.course_id";

                // Check if search term is provided
                if(isset($_GET['search']) && !empty($_GET['search'])) {
                    $search = $_GET['search'];
                    // Append WHERE clause to filter search results
                    $sql .= " WHERE students.username LIKE '%$search%' OR students.student_id LIKE '%$search%' OR courses.department LIKE '%$search%' OR students.semester LIKE '%$search%' OR students.roll_no LIKE '%$search%'";
                }

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["student_id"] . "</td>";
                        echo "<td>" . $row["username"] . "</td>";
                        echo "<td>" . $row["email_id"] . "</td>";
                        echo "<td>" . $row["roll_no"] . "</td>";
                        echo "<td>" . $row["department"] . "</td>";
                        echo "<td>" . $row["semester"] . "</td>";
                        echo "<td><form method='post'><input type='hidden' name='student_id' value='" . $row["student_id"] . "'><button type='submit' class='btn btn-danger' onclick='return confirmDelete()'>Delete</button></form></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No data found</td></tr>";
                }

                // Close the connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Ensure you have jQuery included if needed -->

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this record?");
        }
        function confirmDeleteAll() {
            return confirm("Are you sure you want to delete all the students recods?");
        }
    </script>
</body>
</html>
