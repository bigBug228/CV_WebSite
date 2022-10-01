<?php include("../../mysql_connection.php"); ?>
<?php include("header.php"); ?>
<?php if (isset($_SESSION['user'])) {
    header('location: index.php');
} ?>

<form action="login.php" method="post">
    <label>Email: </label>
    <input type="email" name="email" value="<?php print (isset($_POST["email"]) ? $_POST["email"] : "");?>"><br>

    <label>Password: </label>
    <input type="password" name="password" value="<?php print (isset($_POST["password"]) ? $_POST["password"] : "");?>"><br>
    <input type="submit">
</form>

<?php
    function e($str) {
        global $db_connection;
        $str = trim($str);
        $str = stripslashes($str); 
        $str = strip_tags($str); 
        $str = mysqli_real_escape_string($db_connection, $str);
        return $str;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
        $errors = [];

        $email = e($_POST["email"]);
        if ($email == "") {
            $errors[] = "Enter your email";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }

        $password = e($_POST["password"]);
        if ($password == "") {
            $errors[] = "Enter your password";
        }

        if (empty($errors)) {
            $password = md5($password);

            $query = "SELECT * FROM user WHERE email='$email' AND password='$password' LIMIT 1";
            $results = mysqli_query($db_connection, $query);

            if (mysqli_num_rows($results) == 1) {
                $logged_in_user = mysqli_fetch_assoc($results);
                $_SESSION['user'] = $logged_in_user;
                header('location: index.php');	
            }  else {
                echo "Wrong username or password";
            }
        } else {
            foreach($errors as $err) {
                echo $err . "<br>";
            }
        }
    }
?>

<?php include("footer.php"); ?>