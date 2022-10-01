<?php include("../../mysql_connection.php"); ?>
<?php include("header.php"); ?>
<?php 
if (isset($_GET['id'])){
    $id=$_GET['id'];
    $delete =mysqli_query($db_connection,"DELETE FROM contactUs WHERE id='$id';");
}
$query = "CREATE TABLE IF NOT EXISTS contactUs (id int AUTO_INCREMENT PRIMARY KEY NOT NULL, fname varchar(20) NOT NULL, lname varchar(20) NOT NULL, email varchar(50) NOT NULL, phone varchar(20) NOT NULL, message varchar(255) NOT NULL, operation varchar(255) NOT NULL);";

    $select ="SELECT * FROM contactUs";
    $query = mysqli_query($db_connection,$select);
?>
<div class="main">
    <table border="1" cellpadding ="0">   
        <tr>
            <th>id</th>
            <th>fname</th>
            <th>lname</th>
            <th>email</th>
            <th>phone</th>
            <th>message</th>
            <th>operation</th>

        </tr>
        <?php
        $num =mysqli_num_rows($query);
        if($num>0){
            while ($result=mysqli_fetch_assoc($query)){
                echo "
                <tr>
            <td>".$result['id']."</td>
            <td>".$result['fname']."</td>
            <td>".$result['lname']."</td>
            <td>".$result['email']."</td>
            <td>".$result['phone']."</td>
            <td>".$result['message']."</td>
            <td>
            <a href='contact_us.php? id=".$result['id']."' class='btn'>DELETE</a>
            </td>
        </tr>
                ";
            }
        }
        ?>
    </table>
</div>
<?php include("footer.php"); ?>