<?php
// Include config file
require_once "config.php";

if(isset($_GET['edid'])){
    $edid = $_GET['edid'];
    $query = mysqli_query($link, "select * from gb_item_ed where id='$edid'");
    $stock_id = mysqli_fetch_array($query)['stock_id'];
    mysqli_query($link, "delete from gb_item_ed where id='$edid'");
    header("location: stockform.php?stock_id=".$stock_id);
} else {
    $stock_id = $_POST['stockid'];
    $ed_date = $_POST['ed_date'];
    $ed_price = $_POST['ed_price'];
    $ed_chg = $_POST['ed_chg'];
    
    if(isset($_POST['edid'])) {
        $edid = $_POST['edid'];
        mysqli_query($link, "update gb_item_ed set ed_date='$ed_date', ed_price='$ed_price', ed_chg='$ed_chg' where id='$edid'");
        header("location: stockform.php?stock_id=".$stock_id);
    } else {
        mysqli_query($link, "insert into gb_item_ed (stock_id, ed_date, ed_price, ed_chg) values ('$stock_id', '$ed_date', '$ed_price', '$ed_chg')");
        header("location: stockform.php?stock_id=".$stock_id);
    }
}
?>