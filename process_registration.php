<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Management</title>
   <style>
/* Styles for header */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Header styles */
header {
    background-color: #3d29e9;
    color: #fff;
    padding: 20px 0;
    text-align: center;
    margin-bottom: 20px;
    position: sticky;
    top: 0;
    z-index: 1000;
}

h1 {
    margin: 0;
}

/* Table styles */
.table-container {
    max-height: 500px;
    overflow: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #4CAF50;
    color: white;
}

tr:hover {
    background-color: #f2f2f2;
}

/* Form styles */
.form-container {
    margin-bottom: 20px;
    text-align: center;
}

input[type=text], input[type=password] {
    padding: 10px;
    width: 100%;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input[type=submit] {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    text-decoration: none;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 5px;
}

input[type=submit]:hover {
    background-color: #45a049;
}


</style>

</head>

<body>

<header style="position: relative; z-index: 1;">
   <h1>User Management</h1>
</header>


<?php
// Database connection parameters
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "dbaman";

// Establish connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $occupation = isset($_POST['occupation']) ? $_POST['occupation'] : null;
    $school_name = isset($_POST['school_name']) ? $_POST['school_name'] : null;
    $high_school_marks = isset($_POST['high_school_marks']) ? $_POST['high_school_marks'] : null;
    $intermediate_marks = isset($_POST['intermediate_marks']) ? $_POST['intermediate_marks'] : null;
    $address = isset($_POST['address']) ? $_POST['address'] : null;
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];

    // Check if passwords match
    if ($password !== $c_password) {
        echo "Error: Passwords do not match";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to insert user data into the database
    $stmt = $conn->prepare("INSERT INTO users (username, email, occupation, school_name, high_school_marks, intermediate_marks, address, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssddss", $username, $email, $occupation, $school_name, $high_school_marks, $intermediate_marks, $address, $hashed_password);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Redirect to the home page after successful registration
        header("Location: http://127.0.0.1:5501/home.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Define SQL query
$sql = "SELECT u.username, u.email, u.occupation, u.school_name, u.high_school_marks, u.intermediate_marks, u.address, 
        m.physics_marks, m.chemistry_marks, m.math_marks, m.branch_1, m.branch_2, m.branch_3, m.allocated_branch,
        ((m.physics_marks + m.chemistry_marks + m.math_marks) / 3) AS average_marks
        FROM users u
        LEFT JOIN marks m ON u.username = m.username";


// Check if the sort button is clicked
if (isset($_POST['sort'])) {
    $sql .= " ORDER BY average_marks DESC";
}

// Execute the query
$result = $conn->query($sql);

// Output table if data is found
if ($result->num_rows > 0) {
    echo "<table><tr><th>Username</th><th>Email</th><th>Occupation</th><th>School Name</th><th>High School Marks</th>
            <th>Intermediate Marks</th><th>Physics Marks</th><th>Chemistry Marks</th><th>Math Marks</th>
            <th>Branch 1</th><th>Branch 2</th><th>Branch 3</th><th>Average Percentage</th><th>Allocation</th><th>Allocated Branch</th></tr>";
    
    // Output data
    while ($row = $result->fetch_assoc()) {
        $average_percentage = $row["average_marks"];
        echo "<tr><td>" . $row["username"] . "</td><td>" . $row["email"] . "</td><td>" . $row["occupation"] . "</td>
                <td>" . $row["school_name"] . "</td><td>" . $row["high_school_marks"] . "</td><td>" . $row["intermediate_marks"] . "</td>
                <td>" . $row["physics_marks"] . "</td><td>" . $row["chemistry_marks"] . "</td><td>" . $row["math_marks"] . "</td>
                <td>" . $row["branch_1"] . "</td><td>" . $row["branch_2"] . "</td><td>" . $row["branch_3"] . "</td>
                <td>" . number_format($average_percentage, 0) . "%</td>
                <td>
                    <form action='allocate_branch.php' method='post'>
                        <input type='hidden' name='username' value='" . $row["username"] . "'>
                        <select name='branch'>
                            <option value='Computer Science Engineering'>Computer Science Engineering</option>
                            <option value='Electronics Engineering'>Electronics Engineering</option>
                            <option value='Mechanical Engineering'>Mechanical Engineering</option>
                            <option value='Civil Engineering'>Civil Engineering</option>
                            <option value='Electrical Engineering'>Electrical Engineering</option>
                            <option value='Chemical Engineering'>Chemical Engineering</option>
                            <option value='Aerospace Engineering'>Aerospace Engineering</option>
                            <option value='Biomedical Engineering'>Biomedical Engineering</option>
                            <option value='Industrial Engineering'>Industrial Engineering</option>
                        </select>
                        <input type='submit' value='Allocate'>
                    </form>
                </td><td>" . $row["allocated_branch"] . "</td></tr>";
    }
    
    echo "</table>";
} else {
    echo "No users found";
}

// Close the database connection
$conn->close();
?>


<!-- Add logout button -->
<div style="text-align: center; margin-bottom: 20px;">
   <form id="logoutForm" action="logout.php" method="post">
      <input type="submit" value="Log Out" name="logout" class="btn">
   </form>
</div>

<!-- Add sort button -->
<div style="text-align: center; margin-bottom: 20px;">
   <form action="" method="post">
      <input type="submit" value="Sort" name="sort">
   </form>
</div>
<script>
   // Function to log out and redirect to the login page
   function logoutAndRedirect() {
      // Submit the logout form
      document.getElementById("logoutForm").submit();
      // Redirect to the login page
      window.location.href = "http://127.0.0.1:5501/login.html";
   }
</script>

</body>
</html>
