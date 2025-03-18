<?php
    $title = "CrypVest";
    $modul = "Login";
    $version = "1.0";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title." | ".$modul;?></title>
    <link rel="icon" href="favicon/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/style-login.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form id="loginForm" action="login-check.php" method="post">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button class="btn-primary" type="submit">Login</button>
        </form>
    </div>

    <script src="js/login.js">
    </script>
</body>
</html>