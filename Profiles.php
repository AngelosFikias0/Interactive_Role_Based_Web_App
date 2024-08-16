<?php
// Profile page
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'user') {
    header('Location: Login.php');
    exit();
}

// Initialize variables
$message = '';
$messageClass = '';

// Connect to database
$conn = mysqli_connect('localhost', 'root', '', 'wapp');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch current user profile details
$username = $_SESSION['username'];
$sql = "SELECT * FROM `users` WHERE `name` = '$username'";
$result = mysqli_query($conn, $sql);
$userData = mysqli_fetch_assoc($result);

// Handle profile update
if (isset($_POST['update'])) {
    $newUsername = $_POST['username'] ?? '';

    if (empty($newUsername)) {
        $message = "Please fill out the username field";
        $messageClass = 'warning';
    } else {
        $newUsername = mysqli_real_escape_string($conn, $newUsername);

        // Check if the new username already exists
        $sql_check = "SELECT * FROM `users` WHERE `name` = '$newUsername'";
        $result_check = mysqli_query($conn, $sql_check);

        if (mysqli_num_rows($result_check) > 0) {
            $message = "Username already in use. Please choose another.";
            $messageClass = 'error';
        } else {
            // Update the username
            $sql_update = "UPDATE `users` SET `name` = '$newUsername' WHERE `name` = '$username'";
            if (mysqli_query($conn, $sql_update)) {
                // Update the session username
                $_SESSION['username'] = $newUsername;
                $username = $newUsername; // Update the local variable

                // Refresh user data with the updated username
                $sql = "SELECT * FROM `users` WHERE `name` = '$newUsername'";
                $result = mysqli_query($conn, $sql);
                $userData = mysqli_fetch_assoc($result);

                $message = "Username successfully updated";
                $messageClass = 'success';
            } else {
                $message = "Error updating username: " . mysqli_error($conn);
                $messageClass = 'error';
            }
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
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
        input[type="text"] {
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
        .Dash{
            text-align:center;
        }
        a {
            display: inline-block;
            background-color: violet;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px; 
            font-size: 16px; 
            font-weight: bold; 
            transition: background-color 0.3s ease; 
        }

        a:hover {
            background-color: darkviolet; 
        }

        @media (max-width: 768px) {
    body {
        padding: 10px;
    }

    h1 {
        font-size: 24px;
        padding: 15px;
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

    input[type="text"] {
        width: calc(100% - 20px);
        padding: 8px;
        font-size: 14px;
    }

    input[type="submit"] {
        width: 100%;
        padding: 10px;
        font-size: 16px;
    }

    .Dash {
        font-size: 16px;
    }

    a {
        font-size: 16px;
        padding: 10px 15px;
    }
}
    </style>
</head>
<body>
    <h1>Your Profile</h1>

    <?php if (!empty($message)): ?>
        <div class="message <?php echo htmlspecialchars($messageClass); ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($userData['name']); ?>" required>
        <input type="submit" name="update" value="Update Profile">
    </form>

    <p class="Dash"><a href="Dashboard.php">Go back to Dashboard</a></p>
</body>
</html>
