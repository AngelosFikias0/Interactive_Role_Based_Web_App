<?php
// Admin main dashboard
session_start();

// Redirect to login page if not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'admin') {
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

// Handle user deletion
if (isset($_POST['delete'])) {
    $userId = $_POST['userId'] ?? '';

    if (!empty($userId)) {
        $userId = mysqli_real_escape_string($conn, $userId);
        $sql = "DELETE FROM `users` WHERE `id` = '$userId'";

        if (mysqli_query($conn, $sql)) {
            $message = "User successfully deleted";
            $messageClass = 'success';
        } else {
            $message = "Error deleting user: " . mysqli_error($conn);
            $messageClass = 'error';
        }
    }
}

// Fetch users from the database
$sql = "SELECT * FROM `users`";
$result = mysqli_query($conn, $sql);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: #fff;
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
        form {
            display: inline;
        }
        input[type="submit"] {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #c82333;
        }
        
        @media (max-width: 768px) {
    body {
        padding: 10px;
    }

    h1 {
        font-size: 24px;
        padding: 15px;
    }

    table {
        width: 100%;
        margin: 10px 0;
        border: none;
        font-size: 14px;
    }

    th, td {
        padding: 8px;
        text-align: left;
    }

    th {
        font-size: 16px;
    }

    .message {
        max-width: 100%;
        margin: 10px auto;
        padding: 10px;
    }

    form {
        display: block;
        margin-top: 10px;
    }

    input[type="submit"] {
        width: 100%;
        padding: 10px;
        font-size: 16px;
    }
}
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <?php if (!empty($message)): ?>
        <div class="message <?php echo htmlspecialchars($messageClass); ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td>
                            <form action="" method="post" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                <input type="hidden" name="userId" value="<?php echo htmlspecialchars($row['id']); ?>">
                                <input type="submit" name="delete" value="Delete">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No users found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
