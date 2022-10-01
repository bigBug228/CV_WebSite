<?php include("../../mysql_connection.php"); ?>
<?php include("header.php"); ?>
<?php if (!isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] == 0) {
    header('location: login.php');
} ?>


<form action="registration_edit.php" method="post">
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
    <br>

    <label>Fee: </label>
    <input type="text" name="fee" value="<?php print(isset($_POST["fee"]) ? $_POST["fee"] : "")?>">
    <br>

    <input type="submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $errors = [];

    $duration = $_POST["duration"];
    if ($duration == "") {
        $errors[] = "Please choose the period of time";
    }

    $fee = (int)$_POST["fee"];
    if ($_POST["fee"] == "" || ($fee == 0 && $_POST["fee"] != "") || $fee < 0) {
        $errors[] = "Please enter a valid number";
    }

    if (empty($errors)) {
        $query = "CREATE TABLE IF NOT EXISTS fee (id int AUTO_INCREMENT PRIMARY KEY NOT NULL, duration varchar(255) NOT NULL, price int NOT NULL);";

        if (mysqli_query($db_connection, $query)) {
            $query = "SELECT * FROM fee WHERE duration='$duration' LIMIT 1;";
            $results = mysqli_query($db_connection, $query);

            if (mysqli_num_rows($results) == 1) {
                $query = "UPDATE fee SET price='$fee' WHERE duration='$duration';";
                $results = mysqli_query($db_connection, $query);

                if ($results) {
                    echo "Table is updated";
                }
            } else {
                $query = "INSERT INTO fee (duration, price) VALUES ('$duration', '$fee');";
                $result = mysqli_query($db_connection, $query);

                if ($result) {
                    echo "Added to the database";
                }
            }
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

<script src="fees.js"></script>
<?php include("footer.php"); ?>