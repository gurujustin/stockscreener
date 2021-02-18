<?php
// Include config file
require_once "config.php";

$symbol_err = "";

if(empty(trim($_POST['symbol']))){
    $symbol_err = "Please enter symbol.";
} else{
    $symbol = trim($_POST["symbol"]);
}

if (empty($symbol_err)) {
    mysqli_query($link, "insert into stocks (symbol) values ('$symbol')");
    header("location: stockform.php?stock_id=".$link->insert_id);
} else {
    header("location: index.php?symbol_err=".$symbol_err);
}
?>