<?php include 'inc/header.php'?>

<?php
$login=Session::get("cuslogin");
if ($login==false){
    header("Location:login.php");
}
?>
<?php
    if (isset($_GET['orderid'])&& $_GET['orderid']=='order'){
        $cmrId=Session::get("cusId");
        $insertOrder=$ct->orderProduct($cmrId);
        $delData=$ct->deleteCart();
        header("Location:success.php");
    }
?>
<style>
    .divison{width: 50%; float: left;}
    .tblone{width: 500px; margin: 0px auto; border: 2px solid #ddd; }
    .tblone tr td{text-align: justify;}
    .tbltwo{float:right;text-align:left; width: 60%; border: 2px solid #ddd; margin-right: 14px; margin-top: 12px;}
    .tbltwo tr td{text-align: justify; padding: 5px 10px;}
    .ordernow{padding-bottom: 30px;}
    .ordernow a{width: 200px; margin:20px auto 0; text-align: center; padding: 5px; font-size: 30px; display: block; background: #ff0000; color:#fff; border-radius: 3px;}
</style>

<div class="main">
    <div class="content">
        <div class="section group">
            <div class="divison">
                <table class="tblone">
                    <tr>
                        <td>No</td>
                        <td>Product</td>
                        <td>Price</td>
                        <td>Quantity</td>
                        <td>Total</td>
                    </tr>
                    <?php
                    $getCart=$ct->getAllCart();
                    if ($getCart){
                        $i=0;
                        $total=0;
                        $sum=0;
                        $qty=0;
                        while ($result=$getCart->fetch_assoc()){
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $result['productName'];?></td>
                                <td>$<?php echo $result['price'];?></td>
                                <td><?php echo $result['quantity'];?></td>
                                <td>
                                    <?php
                                    $total=$result['quantity'] * $result['price'];
                                    echo $total;
                                    ?>
                                </td>
                            </tr>
                            <?php
                            $qty=$qty+$result['quantity'];
                            $sum= $sum+$total;
                            ?>

                        <?php } } ?>


                </table>
                <table class="tbltwo">
                    <tr>
                        <td>Quantity</td>
                        <td> : </td>
                        <td><?php echo $qty;?></td>
                    </tr>
                    <tr>
                    <tr>
                        <td>Sub Total</td>
                        <td> : </td>
                        <td>$<?php echo $sum;?></td>
                    </tr>
                    <tr>
                        <td>VAT</td>
                        <td> : </td>
                        <td>10%($<?php echo $vat=$sum*0.1;?>)</td>
                    </tr>
                    <tr>
                        <td>Grand Total</td>
                        <td> : </td>
                        <td>
                            <?php
                            $vat=$sum*0.1;
                            $gtotal=$vat+$sum;
                            echo "$".$gtotal;
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="divison">
                <table class="tblone">
                    <?php
                    $cmrId=Session::get("cusId");
                    $cmrData=$cmr->customerData($cmrId);
                    if ($cmrData){
                        while ($result=$cmrData->fetch_assoc()){
                            ?>
                            <tr>
                                <td colspan="3"><h2>Your Details</h2></td>
                            </tr>
                            <tr>
                                <td width="20%">Name</td>
                                <td width="5%">:</td>
                                <td><?php echo $result['name'];?></td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td><?php echo $result['address'];?></td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>:</td>
                                <td><?php echo $result['phone'];?></td>
                            </tr>
                            <tr>
                                <td>City</td>
                                <td>:</td>
                                <td><?php echo $result['city'];?></td>
                            </tr>
                            <tr>
                                <td>Country</td>
                                <td>:</td>
                                <td><?php echo $result['country'];?></td>
                            </tr>
                            <tr>
                                <td>Zip-Code</td>
                                <td>:</td>
                                <td><?php echo $result['zip'];?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td><?php echo $result['email'];?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><a href="updateprofile.php">Update Details</td>
                            </tr>
                        <?php } } ?>
                </table>
            </div>

        </div>
    </div>
    <div class="ordernow">
        <a href="?orderid=order">Order</a>
    </div>
</div>
<?php include 'inc/footer.php'?>
