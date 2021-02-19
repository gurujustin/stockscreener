<?php
// Include config file
require_once "config.php";

if(isset($_GET['noteid'])){
    $noteid = $_GET['noteid'];
    $query = mysqli_query($link, "select * from gb_item_notes where id='$noteid'");
    $stock_id = mysqli_fetch_array($query)['stock_id'];
    mysqli_query($link, "delete from gb_item_notes where id='$noteid'");
    header("location: stockform.php?stock_id=".$stock_id);
} else {
    $stock_id = $_POST['stockid'];
    $notes_date = $_POST['notes_date'];
    $notes = $_POST['notes'];
    
    if(isset($_POST['noteid'])) {
        $noteid = $_POST['noteid'];
        mysqli_query($link, "update gb_item_notes set notes_date='$notes_date', notes='$notes' where id='$noteid'");
        header("location: stockform.php?stock_id=".$stock_id);
    } else {
        mysqli_query($link, "insert into gb_item_notes (stock_id, notes_date, notes) values ('$stock_id', '$notes_date', '$notes')");
        header("location: stockform.php?stock_id=".$stock_id);
    }
}
?>