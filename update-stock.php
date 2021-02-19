<?php
// Include config file
require_once "config.php";

$stock_id = $_POST['stockid'];

$trigger_price = $_POST['trigger_price'];
$projection_price = $_POST['projection_price'];
if(isset($_POST['recommended'])){
    $recommended = 'Y';
} else {
    $recommended = 'N';
}
$recom_date = $_POST['recom_date'];
$recom_type = "";
$param = $_POST['param'];
$i = 0;
foreach($param as $item){
    $i = $i+1;
    if($i != count($param)){
        $recom_type .= $item.',';
    } else {
        $recom_type .= $item;
    }
}

$date_created = $_POST['date_created'];

mysqli_query($link, "update gb_item set trigger_price='$trigger_price', projection_price='$projection_price', recommended='$recommended', recom_date='$recom_date', recom_type='$recom_type', date_created='$date_created' where id='$stock_id'");
header("location: stockform.php?stock_id=".$stock_id);
?>