<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Lab_5b";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $accessLevel = $_POST['accessLevel'];

    // Insert data into the users table
    $sql = "INSERT INTO users (matric, name, email, password, accessLevel) 
            VALUES ('$matric', '$name', '$email', '$password', '$accessLevel')";

    if ($conn->query($sql) === TRUE) {
        $success = "Registration successful! <a href='login.php'>Login here</a>";
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            color: #333;
        }

        form {
            max-width: 500px;
            margin: auto;
        }

        label {
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        a {
            text-decoration: none;
            color: #4CAF50;
            display: inline-block;
            margin-top: 20px;
        }

        a:hover {
            text-decoration: underline;
        }

        .message {
            margin-top: 20px;
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Registration Page</h2>

    <!-- Display success or error message -->
    <?php if (!empty($success)) { ?>
        <p class="message"><?php echo $success; ?></p>
    <?php } ?>
    <?php if (!empty($error)) { ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>

    <form action="register.php" method="POST">
        <label>Matric:</label><br>
        <input type="text" name="matric" required><br><br>

        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Access Level:</label><br>
        <select name="accessLevel" required>
            <option value="Lecturer">Lecturer</option>
            <option value="Student">Student</option>
        </select><br><br>

        <button type="submit">Register</button>
    </form>
    <a href="login.php">Login</a>
</body>
</html>
