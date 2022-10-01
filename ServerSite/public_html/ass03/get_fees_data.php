<?php 
include("../../mysql_connection.php");

function get_fees() {
    global $db_connection;

    $query = "SHOW TABLES LIKE 'fee';";
    $results = mysqli_query($db_connection, $query);
    $table = mysqli_fetch_array($results);

    if (isset($table[0])) {

        $query = "SELECT * FROM fee";
        $results = mysqli_query($db_connection, $query);

        if (mysqli_num_rows($results) > 0) {
            $data = [];
            while($row = mysqli_fetch_array($results)){
                $data[] = $row;
            }

            echo json_encode($data);
        }  else {
            echo "Wrong username or password";
        }
    }

    return [];
}

$fees = get_fees();
?>