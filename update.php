<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Lab_5b";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $matric = $_POST['matric'];
        $name = $_POST['name'];
        $accessLevel = $_POST['accessLevel'];

        $sql = "UPDATE users SET matric='$matric', name='$name', accessLevel='$accessLevel' WHERE id='$id'";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: users.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
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
    </style>
</head>
<body>
    <h2>Update User</h2>
    <form action="" method="POST">
        <label>Matric:</label><br>
        <input type="text" name="matric" value="<?php echo $row['matric']; ?>" required><br><br>

        <label>Name:</label><br>
        <input type="text" name="name" value="<?php echo $row['name']; ?>" required><br><br>

        <label>Access Level:</label><br>
        <select name="accessLevel" required>
            <option value="Lecturer" <?php if($row['accessLevel'] == 'Lecturer') echo 'selected'; ?>>Lecturer</option>
            <option value="Student" <?php if($row['accessLevel'] == 'Student') echo 'selected'; ?>>Student</option>
        </select><br><br>

        <button type="submit">Update</button>
        <a href="users.php">Cancel</a>
    </form>
</body>
</html>
