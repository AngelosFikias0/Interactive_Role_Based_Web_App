<?php
// User main dashboard
session_start();

// Redirect to login page if not logged in
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

// Handle new post creation
if (isset($_POST['post'])) {
    $username = $_POST['username'] ?? '';
    $postMessage = $_POST['message'] ?? '';

    if (empty($username) || empty($postMessage)) {
        $_SESSION['message'] = "Please fill out all fields";
        $_SESSION['messageClass'] = 'warning';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $username = mysqli_real_escape_string($conn, $username);
        $postMessage = mysqli_real_escape_string($conn, $postMessage);
        $sql = "INSERT INTO `posts` (`username`, `message`) VALUES ('$username', '$postMessage')";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['message'] = "Post successfully created";
            $_SESSION['messageClass'] = 'success';
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $_SESSION['message'] = "Error creating post: " . mysqli_error($conn);
            $_SESSION['messageClass'] = 'error';
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    }
}

// Fetch posts from the database
$sql = "SELECT * FROM `posts` ORDER BY `created_at` DESC";
$result = mysqli_query($conn, $sql);

// Count the number of posts made by the user
$username = $_SESSION['username'];
$sql_count = "SELECT COUNT(*) AS post_count FROM `posts` WHERE `username` = '$username'";
$count_result = mysqli_query($conn, $sql_count);
$count_data = mysqli_fetch_assoc($count_result);
$postCount = $count_data['post_count'];

mysqli_close($conn);

// Retrieve and clear session messages
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $messageClass = $_SESSION['messageClass'];
    unset($_SESSION['message']);
    unset($_SESSION['messageClass']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        h1 {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin: 0;
        }

        h2 {
            color: violet;
            text-align: center;
            margin: 20px 0;
        }

        .container {
            display: flex;
            flex: 1;
            height: calc(100vh - 160px);
        }

        .profile {
            width: 250px;
            background-color: #f4f4f4;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            height: 100%;
            position: relative;
        }

        .profile h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .profile button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            width: 100%;
            text-align: center;
        }

        .profile button:hover {
            background-color: #0056b3;
        }

        .profile .message-count {
            position: absolute;
            bottom: 20px;
            left: 20px;
            font-size: 16px;
            color: #333;
            bottom:90px;
        }

        .content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #fff;
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

        input[type="text"], textarea {
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

        .post {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 10px auto;
            padding: 10px;
            max-width: 600px;
        }

        .post .username {
            font-weight: bold;
            color: #007bff;
        }

        .post .timestamp {
            font-size: 0.8em;
            color: #888;
        }

        .post .message {
            margin-top: 10px;
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
        font-size: 14px;
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
        padding: 2px 5px;
    }
}
    </style>
</head>
<body>

<h1>Welcome to your Dashboard</h1>
<h2>Share your thoughts with others!</h2>

<div class="container">
    <div class="profile">
        <a href="Profiles.php" style="text-decoration:none;">
            <button>View Profile</button>
        </a>
        <div class="message-count">
            You have made <?php echo htmlspecialchars($postCount); ?> messages
        </div>
    </div>

    <div class="content">
        <?php if (!empty($message)): ?>
            <div class="message <?php echo htmlspecialchars($messageClass); ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <label for="username">Your Name:</label>
            <input type="text" name="username" id="username" required value="<?php echo htmlspecialchars($_SESSION['username']); ?>" readonly>
            <label for="message">Your Post:</label>
            <textarea name="message" id="message" rows="4" required></textarea>
            <input type="submit" name="post" value="Post">
        </form>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="post">
                    <div class="username"><?php echo htmlspecialchars($row['username']); ?></div>
                    <div class="timestamp"><?php echo htmlspecialchars($row['created_at']); ?></div>
                    <div class="message"><?php echo nl2br(htmlspecialchars($row['message'])); ?></div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No posts yet</p>
        <?php endif; ?>
    </div>

</div>
</body>
</html>
