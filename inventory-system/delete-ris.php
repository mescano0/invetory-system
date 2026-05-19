<?php

include 'db.php';

$id = $_GET['id'];

mysqli_begin_transaction($conn);

try{

    // DELETE RIS ITEMS FIRST
    $delete_items = "DELETE FROM ris_items
    WHERE ris_id='$id'";

    mysqli_query($conn, $delete_items);

    // DELETE RIS HEADER
    $delete_ris = "DELETE FROM ris_requests
    WHERE id='$id'";

    mysqli_query($conn, $delete_ris);

    mysqli_commit($conn);

    header("Location: ris-list.php");
    exit;

}catch(Exception $e){

    mysqli_rollback($conn);

    echo "Delete Failed";

}

?>