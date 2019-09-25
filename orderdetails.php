<?php include 'inc/header.php'?>
<?php
$login=Session::get("cuslogin");
if ($login==false){
    header("Location:login.php");
}
?>
<style>
    .tblone tr td{text-align: justify;}
</style>
<?php
if (isset($_GET['customerId'])){
    $id=$_GET['customerId'];
    $time=$_GET['time'];
    $price=$_GET['price'];
    $confirm=$ct->confirmOrder($id,$time,$price);

}
?>
<div class="main">
    <div class="content">
        <div class="section group">
            <div class="order">
                <h2>Your Order Details</h2>
                <table class="tblone">
                    <tr>
                        <th>SL</th>
                        <th >Product Name</th>
                        <th >Image</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $cmrId=Session::get("cusId");
                    $getPro=$ct->getAllProduct($cmrId);
                    if ($getPro){
                        $i=0;
                        $total=0;
                        $sum=0;
                        while ($result=$getPro->fetch_assoc()){
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $result['productName'];?></td>
                                <td><img src="admin/<?php echo $result['image'];?>" alt=""/></td>
                                <td><?php echo $result['quantity'];?></td>
                                <td>
                                    <?php
                                    echo $result['price'];
                                    ?>
                                </td>
                                <td><?php echo $fm->formatDate($result['date']);?></td>
                                <td>
                                    <?php
                                        if ($result['status']=='0'){
                                            echo "Pending";
                                        }elseif($result['status']=='1'){
                                            echo "Shifted";
                                        }else{
                                            echo "Ok";
                                        }
                                    ?>
                                </td>
                                <?php
                                    if ($result['status']=='1'){ ?>
                                        <td><a href="?customerId=<?php echo $cmrId;?>&price=<?php echo $result['price'];?>&time=<?php echo $result['date'];?>">Confirm</a>
                                        </td>
                                <?php    }elseif($result['status']=='2'){ ?>
                                        <td>Ok</td>
                                    <?php }elseif($result['status']=='0'){  ?>
                                        <td>N/A</td>
                                        <?php } ?>
                            </tr>
                        <?php } } ?>


                </table>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php include 'inc/footer.php'?>
