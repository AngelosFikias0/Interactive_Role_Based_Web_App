<?php
// Login as user or as admin
session_start();
$message = '';
$messageClass = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = mysqli_connect('localhost', 'root', '', 'wapp');
    if (!$conn) {
        $message = "Connection failed: " . mysqli_connect_error();
        $messageClass = 'error';
    } else {
        // Handle user creation
        if (isset($_POST['submit'])) {
            $name = $_POST['name'] ?? '';
            $pass = $_POST['pass'] ?? '';

            if (empty($name) || empty($pass)) {
                $message = "Please fill out all fields";
                $messageClass = 'warning';
            } else {
                $name = mysqli_real_escape_string($conn, $name);
                $pass = mysqli_real_escape_string($conn, $pass);

                // Check if the user already exists
                $sql = "SELECT * FROM `users` WHERE `name` = '$name' UNION SELECT * FROM `admins` WHERE `name` = '$name' ";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $message = "User already exists";
                    $messageClass = 'error';
                } else {
                    // Insert new user
                    $sql = "INSERT INTO `users` (`name`, `passkey`) VALUES ('$name', '$pass')";
                    if (mysqli_query($conn, $sql)) {
                        $message = "User successfully created";
                        $messageClass = 'success';
                    } else {
                        $message = "Error creating user: " . mysqli_error($conn);
                        $messageClass = 'error';
                    }
                }
            }
        }

        // Handle login
        if (isset($_POST['submitD'])) {
            $nameL = $_POST['nameL'] ?? '';
            $passL = $_POST['passL'] ?? '';
        
            if (empty($nameL) || empty($passL)) {
                $message = "Please fill out all fields";
                $messageClass = 'warning';
            } else {
                $nameL = mysqli_real_escape_string($conn, $nameL);
                $passL = mysqli_real_escape_string($conn, $passL);
                $sql_user = "SELECT * FROM `users` WHERE `name` = '$nameL' AND `passkey` = '$passL'";
                $sql_admin = "SELECT * FROM `admins` WHERE `name` = '$nameL' AND `passkey` = '$passL'";
                $result_user = mysqli_query($conn, $sql_user);
                $result_admin = mysqli_query($conn, $sql_admin);

                if (mysqli_num_rows($result_user) > 0) {
                    $_SESSION['username'] = $nameL;
                    $_SESSION['user_type'] = 'user';
                    header('Location: Dashboard.php');
                    exit();
                } elseif (mysqli_num_rows($result_admin) > 0) {
                    $_SESSION['username'] = $nameL;
                    $_SESSION['user_type'] = 'admin';
                    header('Location: Admin_dashboard.php');
                    exit();
                } else {
                    $message = "Invalid username or password";
                    $messageClass = 'error';
                }
            }
        }
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web App</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1 {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin: 0;
        }
        hr {
            border: 0;
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }
        .message {
            padding: 15px;
            border-radius: 4px;
            max-width: 500px;
            margin: 20px auto;
            text-align: center;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .message.warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
        form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"], input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        
        @media (max-width: 768px) {
    body {
        padding: 10px;
    }

    h1 {
        font-size: 24px;
        padding: 15px;
    }

    hr {
        margin: 15px 0;
    }

    .message {
        max-width: 100%;
        margin: 10px auto;
        padding: 10px;
    }

    form {
        max-width: 100%;
        padding: 15px;
    }

    label {
        font-size: 14px;
    }

    input[type="text"], input[type="password"] {
        width: calc(100% - 22px);
    }

    input[type="submit"] {
        width: 100%;
        padding: 15px;
        font-size: 18px;
    }
}
    </style>
</head>
<body>

<h1>Welcome to the Web Application</h1>
<hr>

<?php if (!empty($message)): ?>
    <div class="message <?php echo htmlspecialchars($messageClass); ?>">
        <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>

<form action="" method="post">
    <label for="name">Create user:</label>
    Name: <input type="text" name="name" id="name">
    Password: <input type="password" name="pass" id="pass">
    <input type="submit" name="submit" value="Create">
</form>

<form action="" method="post">
    <label for="nameL">Login:</label>
    Name: <input type="text" name="nameL" id="nameL">
    Password: <input type="password" name="passL" id="passL">
    <input type="submit" name="submitD" value="Login">
</form>

</body>
</html>
