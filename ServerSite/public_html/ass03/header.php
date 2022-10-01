<?php include("../../../mysql_connection.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div class="header">
        <nav>
            <div id="nav-links">
                <a href="index.php">Main</a>
                <a href="testimonial.php">Testimonial</a>
                <a href="contact_us_manage.php">Contact Us</a>
                <h1>SPINOGRIZI</h1>
                <?php if (isset($_SESSION['user'])) : ?>
                    <a href="logout.php">Log out</a>
                    <a href="child_reg.php">Register Child</a>
                <?php endif ?>
            </div>
            
            <div id="register">
                <?php if (isset($_SESSION['user'])) {
                    echo "Hello, " . $_SESSION['user']['fname'];
                } else {?>
                        <a href="login.php">Log in</a>
                        <a href="register.php">Register</a>
                <?php } ?>
            </div>
        </nav>
    </div>
