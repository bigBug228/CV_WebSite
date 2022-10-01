<?php include("../../mysql_connection.php"); ?>
<?php include("header.php"); ?>

<?php if (!isset($_SESSION['user'])) {
    header('location: login.php');
} ?>

<form action="child_reg.php" method="post">
    <label>First name: </label>
    <input type="text" name="fname" value="<?php print (isset($_POST["fname"]) ? $_POST["fname"] : "");?>"><br>

    <label>Last name: </label>
    <input type="text" name="lname" value="<?php print (isset($_POST["lname"]) ? $_POST["lname"] : "");?>"><br>

    <label>Size: </label>
    <input type="text" name="size" value="<?php print (isset($_POST["size"]) ? $_POST["size"] : "");?>"><br>

    <label>Age: </label>
    <input type="number" name="age" min="1" max="6" value="<?php print (isset($_POST["age"]) ? $_POST["age"] : "");?>"><br>
   
    <label for="child">Gender:</label>
    <select name="genders" id="genders">
        <option value="male">male</option>
        <option value="female">female</option>
        <option value="other">Other</option>
    </select><br>

    <label>Duration: </label>
    <select name="duration">
        <option value="">--</option>
        <option value="half_day-1" <?php print((isset($_POST["duration"]) && $_POST["duration"] == "half_day-1") ? 'selected' : "");?>>Half day: 1 day</option>
        <option value="half_day-3" <?php print((isset($_POST["duration"]) && $_POST["duration"] == "half_day-3") ? 'selected' : "");?>>Half day: 3 days</option>
        <option value="half_day-5" <?php print((isset($_POST["duration"]) && $_POST["duration"] == "half_day-5") ? 'selected' : "");?>>Half day: 5 days</option>
        <option value="full_day-1" <?php print((isset($_POST["duration"]) && $_POST["duration"] == "full_day-1") ? 'selected' : "");?>>Full day: 1 day</option>
        <option value="full_day-3" <?php print((isset($_POST["duration"]) && $_POST["duration"] == "full_day-3") ? 'selected' : "");?>>Full day: 3 days</option>
        <option value="full_day-5" <?php print((isset($_POST["duration"]) && $_POST["duration"] == "full_day-5") ? 'selected' : "");?>>Full day: 5 days</option>
    </select>
    
    <p id="fee-info"></p>
    <?php 
    if (isset($_SESSION['user']) && $_SESSION['user']['isAdmin'] == 1) {
        echo "<a href='registration_edit.php'>Edit fees</a><br>";
    }
    ?>

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
    function num($num){
        global $db_connection;
        $num = trim($num);
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

        $size = $_POST["size"];
        if ($size == "") {
            $errors[] = "Enter the size of your baby";
        }
        if (!preg_match ("/^[0-9]*$/", $size) ) {  
            $errors[] = "Only numbers and whitespace are allowed";
        }

        $age = $_POST["age"];
        if ($age == "") {
            $errors[] = "Enter age of your baby";
        }

        $gender = $_POST["genders"];
        if ($gender == "") {
            $errors[] = "Enter gender of your baby";
        }
        if (!preg_match ("/^[a-zA-z]*$/", $gender) ) {  
            $errors[] = "Only letters and whitespace are allowed";
        }

        $duration = $_POST["duration"];
        if ($duration == "") {
            $errors[] = "Please choose the period of time";
        }

        if (empty($errors)) {
            echo "Your form was submitted successfully!";

            $query = "CREATE TABLE IF NOT EXISTS child (child_id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,id int(11), fname varchar(20) NOT NULL, lname varchar(20) NOT NULL, size int(255) NOT NULL,age int(11) NOT NULL, gender varchar(20) NOT NULL, duration varchar(255) NOT NULL, FOREIGN KEY (id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE);";
            
            
            if (mysqli_query($db_connection, $query)) {
                echo "Table created <br>";
            } else {
                echo mysqli_error($db_connection) . "<br>";
            }
            // $query = "SELECT email FROM user WHERE email = '$email' AND lanme";
            // $result = mysqli_query($db_connection, $query);
            // if($result){
                // $num = mysqli_num_rows($result);
                // if ($num > 0) {
                //     echo "The user with this email already exists <br>";
                // } else {
                //     $password = md5($password);

                    $id=$_SESSION['user']['id'];
                    $query = "INSERT INTO child (fname, lname, size, age, gender, duration, id) VALUES ('$fname', '$lname', '$size', '$age','$gender','$duration','$id')";
                    $result = mysqli_query($db_connection, $query);
                    if ($result) {
                        echo "Added to the database <br>";

                        $reg_child_id = mysqli_insert_id($db_connection);

                        $_SESSION['child'] = getUserById($reg_child_id);
                        $_SESSION['success']  = "Child has been registered";
                        header('location: index.php');
                    } else {
                        echo mysqli_error($db_connection) . "<br>"; 
                    }
                // }
            // }
        } else {
            foreach($errors as $err) {
                echo $err . "<br>";
            }
        }

    }

    function getUserById($id){
        global $db_connection;
        $query = "SELECT * FROM child WHERE id=" . $id;
        $result = mysqli_query($db_connection, $query);
    
        $user = mysqli_fetch_assoc($result);
        return $user;
    }
?>

<script src="fees.js"></script>

<?php include("footer.php"); ?>