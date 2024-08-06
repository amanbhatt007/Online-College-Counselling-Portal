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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['branch'])) {
    // Retrieve form data
    $username = $_POST['username'];
    $branch = $_POST['branch'];

    // Prepare SQL statement to update user's branch in the database
    $stmt = $conn->prepare("UPDATE marks SET allocated_branch = ? WHERE username = ?");
    $stmt->bind_param("ss", $branch, $username);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo ("The Branch is Allocated Succesfully");
        // Redirect back to the user management page
        header("Location: http://localhost/myapp/process_registration.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();

