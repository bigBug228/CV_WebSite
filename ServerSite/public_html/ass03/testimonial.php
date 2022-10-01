<?php include("../../mysql_connection.php"); ?>
<?php include("header.php"); ?>

<?php 
$query = "CREATE TABLE IF NOT EXISTS testimonial (id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL, sname varchar(20) NOT NULL, date varchar(20) NOT NULL, pfirst varchar(20) NOT NULL, comment varchar(255) NOT NULL, isApproved BOOLEAN);";
$result = mysqli_query($db_connection, $query);

if (isset($_SESSION['user'])) {
    echo "<a href='testimonial_add.php'>Add new testimonial</a>";
    echo "<br>";
    if($_SESSION['user']['isAdmin']) {
        echo "<a href='testimonial_manage.php'>Manage testimonial</a>";   
    }
}
?>
<div class="main">
    <div class=testimonialGrid>
        <?php 

            $query = "SELECT * FROM testimonial WHERE isApproved = TRUE";
            $result = mysqli_query($db_connection, $query);

            while($row = $result->fetch_assoc()) {
                echo 
                "<div class='testimonialBox'>
                    <p>Service name: {$row['sname']}</p>
                    <p>Parrent name: {$row['pfirst']}</p>
                    <p>Date: {$row['date']}</p>
                    <p>Comment: {$row['comment']}</p>
                </div>" . "<br>";
            }

        ?>
    </div>
</div>

<?php include("footer.php"); ?>