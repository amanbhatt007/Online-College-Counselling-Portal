<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allocated Branch</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('background.jpg'); /* Add your background image URL here */
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            padding-top: 100px;
        }
        .allocated-branch {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
        }
        .allocated-branch h3 {
            margin-bottom: 20px;
        }
        .allocated-branch p {
            margin-bottom: 20px;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="allocated-branch">
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

            // Get the username from the request parameter
            if(isset($_GET['username'])) {

            $username = $_GET['username'];

            // Prepare a SQL statement with a placeholder for username
            $sql = "SELECT allocated_branch FROM marks WHERE username = ?";

            // Prepare the statement
            $stmt = $conn->prepare($sql);

            // Bind the username parameter to the prepared statement
            $stmt->bind_param("s", $username);

            // Execute the prepared statement
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Fetch allocated branch
                $row = $result->fetch_assoc();
                $allocatedBranch = $row['allocated_branch'];
            } else {
                $allocatedBranch = "No allocated branch found for the user.";
            }

            // Close the prepared statement
            $stmt->close();

            // Close database connection
            $conn->close();

            // Embed the allocated branch directly into the HTML
            echo '<h3>Allocated Branch:</h3>';
            echo '<p id="allocatedBranchText">' . $allocatedBranch . '</p>';

        } else {
            echo "Username parameter is missing.";
        }

            ?>
            <a href="http://127.0.0.1:5501/main.html" class="btn">Logout</a>
        </div>
    </div>
</body>
</html>
