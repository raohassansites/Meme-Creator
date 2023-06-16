<?php
require('db_connect.php');
$sql = "DELETE FROM createdmemes WHERE id='" . $_GET["id"] . "'";
if (mysqli_query($conn, $sql)) {
    echo "Record deleted successfully";
    header("location:mymemes.php");
} else {
    echo "Error deleting record: ";
}

?>