<?php
$title = 'Add Symbol';
include_once 'header.php';
if (isset($_GET['symbol_err'])){
    $symbol_err = $_GET['symbol_err'];
} else {
    $symbol_err = "";
}

?>                   
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-body">
                    
                    <form action="add-stock.php" method="post">
                        <div class="form-group d-flex <?php echo (!empty($symbol_err)) ? 'has-error' : ''; ?>">
                            <label class="mx-2 p-2">ITEM</label>
                            <input type="text" class="form-control" placeholder="Enter Symbol" name="symbol"/>
                            <button type="submit" class="btn btn-primary mx-2">Add</button>
                        </div>
                        <span class="help-block"><?php echo $symbol_err; ?></span>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->
<?php
include_once 'footer.php';
?>