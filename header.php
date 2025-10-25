<?php 
//Include configuration file 
require_once './config.php'; 
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>IN2120 Blog</title>
    <link rel="stylesheet" href="./assets/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
</head>

<body>
    
    <header class="site-header">
        <div class="container">
            
            <a class="brand" href="/index.php">IN2120 Blog</a>

            
            <nav>
                <a href="./index.php">Home</a>

                <!-- checks if user is logged in -->
                <?php if (isLoggedIn()): ?>
                    <!-- If user is logged in: show Create Post + Logout options -->
                    <a href="./create.php">New Post</a>

                    <!-- Show username in logout link -->
                    <a href="./logout.php">Logout (<?php echo $_SESSION['user']['username']; ?>)</a>
                <?php else: ?>
                    <!-- If user is NOT logged in: show Login + Register links -->
                    <a href="./login.php">Login</a>
                    <a href="./register.php">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="container">
