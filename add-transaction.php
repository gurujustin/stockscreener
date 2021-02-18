<?php
// Include config file
require_once "config.php";

if(isset($_GET['tid'])){
    $tid = $_GET['tid'];
    $query = mysqli_query($link, "select * from transactions where id='$tid'");
    $stock_id = mysqli_fetch_array($query)['stock_id'];
    mysqli_query($link, "delete from transactions where id='$tid'");
    header("location: stockform.php?stock_id=".$stock_id);
} else {
    $stock_id = $_POST['stockid'];
    $type = $_POST['type'];
    $qnty = $_POST['qnty'];
    $price = $_POST['price'];
    $total = $qnty * $price;
    $date = $_POST['date'];
    
    if(isset($_POST['transactionid'])) {
        $transactionid = $_POST['transactionid'];
        mysqli_query($link, "update transactions set type='$type', qnty='$qnty', price='$price', total='$total', date='$date' where id='$transactionid'");
        header("location: stockform.php?stock_id=".$stock_id);
    } else {
        mysqli_query($link, "insert into transactions (stock_id, type, qnty, price, total, date) values ('$stock_id', '$type', '$qnty', '$price', '$total', '$date')");
        header("location: stockform.php?stock_id=".$stock_id);
    }
}
?>