<?php
// Include config file
require_once "config.php";

session_start();

$username = $_SESSION['username'];
$query = mysqli_query($link, "select * from users where username='$username'");
$userid = mysqli_fetch_array($query)['id'];

$symbol_err = "";

if(empty(trim($_POST['symbol']))){
    $symbol_err = "Please enter symbol.";
} else{
    $symbol = trim($_POST["symbol"]);
}

if (empty($symbol_err)) {
    mysqli_query($link, "insert into gb_item (item, userid) values ('$symbol', '$userid')");
    header("location: stockform.php?stock_id=".$link->insert_id);
} else {
    header("location: index.php?symbol_err=".$symbol_err);
}
?>