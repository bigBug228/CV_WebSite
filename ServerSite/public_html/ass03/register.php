<?php include("../../mysql_connection.php"); ?>
<?php include("header.php"); ?>
<?php if (isset($_SESSION['user'])) {
    header('location: index.php');
} ?>
<form action="register.php" method="post">
    <label>First name: </label>
    <input type="text" name="fname" value="<?php print (isset($_POST["fname"]) ? $_POST["fname"] : "");?>"><br>

    <label>Last name: </label>
    <input type="text" name="lname" value="<?php print (isset($_POST["lname"]) ? $_POST["lname"] : "");?>"><br>

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


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $errors = [];

        $fname = e($_POST["fname"]);
        if ($fname == "") {
            $errors[] = "Enter your first name";
        }
        if (!preg_match ("/^[a-zA-z]*$/", $fname) ) {  
            $errors[] = "Only letters and whitespace are allowed";
        }

        $lname = e($_POST["lname"]);
        if ($lname == "") {
            $errors[] = "Enter your last name";
        }
        if (!preg_match ("/^[a-zA-z]*$/", $lname) ) {  
            $errors[] = "Only letters and whitespace are allowed";
        }

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
            echo "Your form was submitted successfully!";

            $query = "CREATE TABLE IF NOT EXISTS user (id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL, fname varchar(20) NOT NULL, lname varchar(20) NOT NULL, email varchar(255) NOT NULL, password varchar(255) NOT NULL, isAdmin BOOLEAN NOT NULL);";

            if (mysqli_query($db_connection, $query)) {
                echo "Table created <br>";
            } else {
                echo mysqli_error($db_connection) . "<br>";
            }

            $query = "SELECT email FROM user WHERE email = '$email'";
            $result = mysqli_query($db_connection, $query);
            if($result){
                $num = mysqli_num_rows($result);
                if ($num > 0) {
                    echo "The user with this email already exists <br>";
                } else {
                    $password = md5($password);

                    $query = "INSERT INTO user (fname, lname, email, password, isAdmin) VALUES ('$fname', '$lname', '$email', '$password', 0);";
                    $result = mysqli_query($db_connection, $query);
                    if ($result) {
                        echo "Added to the database <br>";

                        $logged_in_user_id = mysqli_insert_id($db_connection);

                        $_SESSION['user'] = getUserById($logged_in_user_id);
                        $_SESSION['success']  = "You are now logged in";
                        header('location: index.php');
                    } else {
                        echo mysqli_error($db_connection) . "<br>"; 
                    }
                }
            }
        } else {
            foreach($errors as $err) {
                echo $err . "<br>";
            }
        }

    }

    function getUserById($id){
        global $db_connection;
        $query = "SELECT * FROM user WHERE id=" . $id;
        $result = mysqli_query($db_connection, $query);
    
        $user = mysqli_fetch_assoc($result);
        return $user;
    }
?>

<?php include("footer.php"); ?>