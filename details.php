<?php include 'inc/header.php'?>
<?php
    if (isset($_GET['proid'])){
        $id=preg_replace('/[^-a-zA-Z0-9_]/','',$_GET['proid']);
    }

    if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])){
        $quantity=$_POST['quantity'];
        $addCart=$ct->addToCart($quantity,$id);
    }
?>
<?php
    if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['compare'])){
    $productId=$_POST['productId'];
    $insertCompare= $pd->insertCompareData($cmrId,$productId);
}
?>
<?php
if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['wishlist'])){
    $saveList= $pd->saveToWishList($cmrId,$id);
}
?>
<style>
    .myButton{width: 100px; float: left; margin-right: 50px;}
</style>

 <div class="main">
    <div class="content">
    	<div class="section group">
				<div class="cont-desc span_1_of_2">
                    <?php
                        $getSinglePd=$pd->getSingleProduct($id);
                        if ($getSinglePd){
                            while ($result=$getSinglePd->fetch_assoc()){
                    ?>
					<div class="grid images_3_of_2">
						<img src="admin/<?php echo $result['image'];?>" alt="" />
					</div>
				<div class="desc span_3_of_2">
					<h2><?php echo $result['productName'];?> </h2>
					<div class="price">
						<p>Price: <span>$<?php echo $result['price'];?></span></p>
						<p>Category: <span><?php echo $result['categoryName'];?></span></p>
						<p>Brand:<span><?php echo $result['brandName'];?></span></p>
					</div>
				<div class="add-cart">
					<form action="" method="post">
						<input type="number" class="buyfield" name="quantity" value="1"/>
						<input type="submit" class="buysubmit" name="submit" value="Buy Now"/>
					</form>				
				</div>
                    <span style="color: red; font-size: 18px;">
                    <?php
                        if (isset($addCart)){
                            echo $addCart;
                        }
                    ?>
                    </span>
                    <?php
                        if (isset($insertCompare)){
                            echo $insertCompare;
                        }
                        if (isset($saveList)){
                        echo $saveList;
                    }
                    ?>
                 <?php
                 $login=Session::get("cuslogin");
                 if ($login==true){ ?>
                    <div class="add-cart">
                        <div class="myButton">
                        <form action="" method="post">
                            <input type="hidden" class="buyfield" name="productId" value="<?php echo $result['productId'];?>"/>
                            <input type="submit" class="buysubmit" name="compare" value="Added to Compare"/>
                        </form>
                     </div>
                     </div>
                    <div class="myButton">
                            <form action="" method="post">
                                <input type="submit" class="buysubmit" name="wishlist" value="Save to Wishlist"/>
                            </form>
                        </div>
                     </div>
                    </div>
                 <?php } ?>
			</div>
			<div class="product-desc">
			<h2>Product Details</h2>
                <p><?php echo $result['body'];?></p>
	    </div>
                    <?php } } ?>
				
	</div>
				<div class="rightsidebar span_3_of_1">
					<h2>CATEGORIES</h2>
					<ul>
                        <?php
                            $getAllCat=$cat->getAllCat();
                            if ($getAllCat){
                                while ($getcat=$getAllCat->fetch_assoc()){

                        ?>
				      <li><a href="productbycat.php?catid=<?php echo $getcat['catId'];?>"><?php echo $getcat['categoryName'];?></a></li>
                        <?php } } ?>
    				</ul>
    	
 				</div>
 		</div>
 	</div>
	</div>
<?php include 'inc/footer.php'?>

