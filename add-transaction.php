<?php
// Include config file
require_once "config.php";

if(isset($_GET['tid'])){
    $tid = $_GET['tid'];
    $query = mysqli_query($link, "select * from gb_item_transactions where id='$tid'");
    $stock_id = mysqli_fetch_array($query)['stock_id'];
    mysqli_query($link, "delete from gb_item_transactions where id='$tid'");
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
        $query1 = mysqli_query($link, "SELECT * FROM gb_item_transactions WHERE stock_id='$stock_id' AND id!='$transactionid' ORDER BY ID DESC LIMIT 1");
        $row = mysqli_fetch_array($query1);
        $query2 = mysqli_query($link, "SELECT COUNT(id) AS cnt FROM gb_item_transactions WHERE stock_id='$stock_id'");
        $cnt = mysqli_fetch_array($query2)['cnt'];
        if($row){
            if($type == 'Bought') {
                $on_hand_qnty = $row['on_hand_qnty'] + $qnty;
            } else {
                $on_hand_qnty = $row['on_hand_qnty'] - $qnty;
            }
            
            $avg_price = ($row['avg_price']*($cnt-1)+$price)/$cnt;
        } else {
            if($type == 'Bought') {
                $on_hand_qnty += $qnty;
            } else {
                $on_hand_qnty -= $qnty;
            }

            $avg_price = $price;
        }
        mysqli_query($link, "update gb_item_transactions set trans_type='$type', qnty='$qnty', price='$price', total='$total', trans_date='$date', on_hand_qnty='$on_hand_qnty', avg_price='$avg_price' where id='$transactionid'");
        header("location: stockform.php?stock_id=".$stock_id);
    } else {
        $query1 = mysqli_query($link, "SELECT * FROM gb_item_transactions WHERE stock_id='$stock_id' ORDER BY ID DESC LIMIT 1");
        $row = mysqli_fetch_array($query1);
        $query2 = mysqli_query($link, "SELECT COUNT(id) AS cnt FROM gb_item_transactions WHERE stock_id='$stock_id'");
        $cnt = mysqli_fetch_array($query2)['cnt'];
        if($row){
            if($type == 'Bought') {
                $on_hand_qnty = $row['on_hand_qnty'] + $qnty;
            } else {
                $on_hand_qnty = $row['on_hand_qnty'] - $qnty;
            }
            
            $avg_price = ($row['avg_price']*$cnt+$price)/($cnt+1);
        } else {
            if($type == 'Bought') {
                $on_hand_qnty += $qnty;
            } else {
                $on_hand_qnty -= $qnty;
            }

            $avg_price = $price;
        }
        mysqli_query($link, "insert into gb_item_transactions (stock_id, trans_type, qnty, price, total, trans_date, on_hand_qnty, avg_price) values ('$stock_id', '$type', '$qnty', '$price', '$total', '$date', '$on_hand_qnty', '$avg_price')");
        header("location: stockform.php?stock_id=".$stock_id);
    }
}
?>