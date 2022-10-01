<?php include("../../mysql_connection.php"); ?>
<?php include("header.php"); ?>

<?php if (isset($_SESSION['user']) && $_SESSION['user']['isAdmin']==1) : ?>
                    <a href="contact_us.php">Contact Us Manage</a>
                <?php endif ?>
<form action="contact_us_manage.php" method="post">
    <label>First name: </label>
    <input type="text" name="fname" value="<?php print (isset($_POST["fname"]) ? $_POST["fname"] : "");?>"><br>

    <label>Last name: </label>
    <input type="text" name="lname" value="<?php print (isset($_POST["lname"]) ? $_POST["lname"] : "");?>"><br>

    <label>Email: </label>
    <input type="email" name="email" value="<?php print (isset($_POST["email"]) ? $_POST["email"] : "");?>"><br>
    <label>Phone: </label>
    <input type="text" name="phone" value="<?php print (isset($_POST["phone"]) ? $_POST["phone"] : "");?>"><br>
    <label>Message:</label>
    <textarea id="message" name="message" rows="4" cols="50" value ="<?php print (isset($_POST["message"]) ? $_POST["message"] : "");?>"></textarea>
    <input type="submit">
</form>

<?php 
$query = "CREATE TABLE IF NOT EXISTS contactUs (id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL, fname varchar(255) NOT NULL, lname varchar(255) NOT NULL, email varchar(255) NOT NULL, phone int(11) NOT NULL, message varchar(255));";
$result = mysqli_query($db_connection, $query);
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
        $message = $_POST["message"];
        $phone = $_POST["phone"];
        if ($phone == "") {
            $errors[] = "Enter your phone";
        }
        if (!preg_match ("/^[0-9]{10}+$/", $phone) ) {  
            $errors[] = "Check phone number";
        }
        
        if (empty($errors)) {
            echo "Your form was submitted successfully!";

            $query = "CREATE TABLE IF NOT EXISTS contactUs (id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL, fname varchar(255) NOT NULL, lname varchar(255) NOT NULL, email varchar(255) NOT NULL, phone int(11) NOT NULL, message varchar(255));";

            $query="INSERT INTO contactUs (fname, lname, email, phone, message) VALUES ('$fname','$lname','$email','$phone','$message');";
            $result = mysqli_query($db_connection, $query);
            if ($result) {
                echo "Added to the database <br>";
            } else {
                echo mysqli_error($db_connection) . "<br>"; 
             }
        } else {
            foreach($errors as $err) {
                echo $err . "<br>";
            }
        }
    }
?>

<?php include("footer.php"); ?>