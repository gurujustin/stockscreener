<?php
// Include config file
require_once "config.php";

if(isset($_GET['ratingid'])){
    $ratingid = $_GET['ratingid'];
    $query = mysqli_query($link, "select * from gb_item_rating where id='$ratingid'");
    $stock_id = mysqli_fetch_array($query)['stock_id'];
    mysqli_query($link, "delete from gb_item_rating where id='$ratingid'");
    header("location: stockform.php?stock_id=".$stock_id);
} else {
    $stock_id = $_POST['stockid'];
    $company = $_POST['company'];
    $rating = $_POST['rating'];
    $price_target = $_POST['price_target'];
    $rate_date = $_POST['date'];
    
    if(isset($_POST['ratingid'])) {
        $ratingid = $_POST['ratingid'];
        mysqli_query($link, "update gb_item_rating set company='$company', rating='$rating', price_target='$price_target', rate_date='$rate_date' where id='$ratingid'");
        header("location: stockform.php?stock_id=".$stock_id);
    } else {
        mysqli_query($link, "insert into gb_item_rating (stock_id, company, rating, price_target, rate_date) values ('$stock_id', '$company', '$rating', '$price_target', '$rate_date')");
        header("location: stockform.php?stock_id=".$stock_id);
    }
}
?>