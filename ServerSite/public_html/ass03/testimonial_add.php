<?php include("../../mysql_connection.php"); ?>
<?php include("header.php"); ?>
<form action="testimonial_add.php" method="post">
    <label>Service name: </label>
    <input type="text" name="sname" value="<?php print (isset($_POST["sname"]) ? $_POST["sname"] : "");?>"><br>

    <label>Date:</label>
    <input type="date" name="date" value="<?php print (isset($_POST["date"]) ? $_POST["date"] : "");?>"><br>

    <label>Parrent First Name: </label>
    <input type="text" name="pfirst" value="<?php print (isset($_POST["pfirst"]) ? $_POST["pfirst"] : "");?>"><br>

    <label>Comment: </label>
    <input type="text" name="comment" value="<?php print (isset($_POST["comment"]) ? $_POST["comment"] : "");?>"><br>

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


    if (isset($_SESSION['user']) && $_SERVER["REQUEST_METHOD"] == "POST") {
        $errors = [];

        $sname = e($_POST["sname"]);
        if ($sname == "") {
            $errors[] = "Enter service name";
        }
        if (!preg_match ("/^[a-zA-z]*$/", $sname) ) {  
            $errors[] = "Only letters and whitespace are allowed";
        }

        $date = e($_POST["date"]);
        if ($date == "") {
            $errors[] = "Enter date";
        }

        $pfirst = e($_POST["pfirst"]);
        if ($pfirst == "") {
            $errors[] = "Enter parrents first name";
        }
        if (!preg_match ("/^[a-zA-z]*$/", $pfirst) ) {  
            $errors[] = "Only letters and whitespace are allowed";
        }

        $comment = e($_POST["comment"]);
        if ($comment == "") {
            $errors[] = "Enter your comment";
        }

        if (empty($errors)) {
            echo "Your form was submitted successfully!";

            $query = "CREATE TABLE IF NOT EXISTS testimonial (id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL, sname varchar(20) NOT NULL, date varchar(20) NOT NULL, pfirst varchar(20) NOT NULL, comment varchar(255) NOT NULL, isApproved BOOLEAN);";


            $query = "INSERT INTO testimonial (sname, date, pfirst, comment, isApproved) VALUES ('$sname', '$date', '$pfirst', '$comment', FALSE)";
            $result = mysqli_query($db_connection, $query);
            if ($result) {
                echo "Added to the database <br>";

                header('location: testimonial.php');
            } else {
                echo mysqli_error($db_connection) . "<br>"; 
            }
        }
    
        foreach($errors as $err) {
            echo $err . "<br>";
        
        }

    }
?>

<?php include("footer.php"); ?>