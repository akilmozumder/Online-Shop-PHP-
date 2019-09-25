<?php include 'inc/header.php'?>
<?php
    if (isset($_GET['delproid'])){
        $delid=$_GET['delproid'];
        $deldata=$pd->delWishListData($delid);
    }
?>
<div class="main">
    <div class="content">
        <div class="cartoption">
            <div class="cartpage">
                <h2>WishList</h2>
                <?php
                    if (isset($deldata)){
                        echo $deldata;
                    }
                ?>
                <table class="tblone">
                    <tr>
                        <th>SL</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $cmrId=Session::get("cusId");
                    $getProduct=$pd->getWishListData($cmrId);
                    if ($getProduct){
                        $i=0;
                        while ($result=$getProduct->fetch_assoc()){
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $result['productName'];?></td>
                                <td>$<?php echo $result['price'];?></td>
                                <td><img src="admin/<?php echo $result['image'];?>" alt=""/></td>
                                <td>
                                    <a href="details.php?proid=<?php echo $result['productId'];?>" class="details">Buy Now</a> ||
                                    <a onclick="return confirm('Are you sure to remove?')" href="?delproid=<?php echo $result['productId'];?>" class="details">Remove</a>
                                </td>
                            </tr>
                        <?php } } ?>

                </table>
            </div>
            <div class="shopping">
                <div class="shopleft" style="width: 100%; text-align: center;">
                    <a href="index.php"> <img src="images/shop.png" alt="" /></a>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php include 'inc/footer.php'?>
