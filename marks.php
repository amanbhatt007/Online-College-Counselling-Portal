<?php
session_start(); // Start the session

// Define the session variable name
$session_variable_name = "username"; // Change this to the actual session variable name

// Get the session variable value if it's set
if (isset($_SESSION[$session_variable_name])) {
    $username = $_SESSION[$session_variable_name];
} else {
    $username = ""; // Set a default value if the session variable is not set
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Marks</title>
   <style>
/* Styles for header */
header {
    background-color: #3d29e9;
    color: #fff;
    padding: 10px;
    text-align: center;
    margin-bottom: 20px;
}

/* Styles for table */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
    padding: 8px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #f2f2f2;
    color: #2512b8;
}

/* Styles for table rows */
tr:hover {
    background-color: #f5f5f5;
}
</style>
</head>
<body>

<header>
   <h1>Highschool Marks</h1>
</header>

<?php
// Database connection parameters
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "dbaman";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); 
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if marks form is submitted
    if (isset($_POST['submit'])) {
        // Retrieve form data
        $username = $_POST['username'];
        $highschool_marks = $_POST['highschool_marks'];
        $physics_marks = $_POST['physics_marks'];
        $chemistry_marks = $_POST['chemistry_marks'];
        $math_marks = $_POST['math_marks'];
        // Calculate average marks
        $average_marks = ($physics_marks + $chemistry_marks + $math_marks) / 3;

        // Get selected branches from the form
        $selected_branches = isset($_POST['branch']) ? $_POST['branch'] : array();
        // Combine selected branches into a comma-separated string
        // Get selected branches for each field
$branch_1 = isset($_POST['branch_1']) ? $_POST['branch_1'] : NULL;
$branch_2 = isset($_POST['branch_2']) ? $_POST['branch_2'] : NULL;
$branch_3 = isset($_POST['branch_3']) ? $_POST['branch_3'] : NULL;

// Prepare SQL statement to insert user data into the database
$stmt = $conn->prepare("INSERT INTO marks (username, highschool_marks, physics_marks, chemistry_marks, math_marks, branch_1, branch_2, branch_3) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sddddsss", $username, $highschool_marks, $physics_marks, $chemistry_marks, $math_marks, $branch_1, $branch_2, $branch_3);


        // Execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to the home page after successful submission
            header("Location: http://127.0.0.1:5501/submit.html");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
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

</body>
</html>
