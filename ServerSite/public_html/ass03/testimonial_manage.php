<?php include("../../mysql_connection.php"); ?>
<?php include("header.php"); ?>
<div class="main">
    <div class=testimonialGrid>
        <?php 
        if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
            $query = "SELECT * FROM testimonial";
            $result = mysqli_query($db_connection, $query);
    
            $query = "";
            while($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $isApproved = 0;
                if (isSet($_POST[$id])) {
                    $isApproved = 1;
                }
                $query = $query . "UPDATE testimonial SET isApproved='$isApproved' WHERE id='$id'; ";
            }
            $db_connection->multi_query($query);
            header("Refresh:0");
        } else {
            $query = "SELECT * FROM testimonial";
            $result = mysqli_query($db_connection, $query);
            echo '<form action="testimonial_manage.php" method="post">';

            while($row = $result->fetch_assoc()) {
                $isChecked = "";
                if ($row["isApproved"]) {
                    $isChecked = "checked";
                }
                echo 
                "<div class='testimonialBox'>
                    <p>Service name: {$row['sname']}</p>
                    <p>Parrent name: {$row['pfirst']}</p>
                    <p>Date: {$row['date']}</p>
                    <p>Comment: {$row['comment']}</p>
                    is approved: <input type=checkbox name='$row[id]' $isChecked>
                </div>" . "<br>";
            }
            echo '<input type="submit">';
            echo '</form>';
        }
        ?>
    </div>
</div>

<?php include("footer.php"); ?>