<?php include 'inc/header.php'?>
<?php
if (!isset($_GET['catid']) || $_GET['catid']==NULL){
    echo "<script>window.location='404.php';</script>";
}else{
    $id=preg_replace('/[^-a-zA-Z0-9_]/','',$_GET['catid']);
}
?>

 <div class="main">
    <div class="content">
    	<div class="content_top">
    		<div class="heading">
    		<h3>Latest from Category</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
	      <div class="section group">
              <?php
                $getPro=$pd->getProductByCategory($id);
                if ($getPro){
                    while ($result=$getPro->fetch_assoc()){
              ?>

				<div class="grid_1_of_4 images_1_of_4">
                    <a href="details.php?proid=<?php echo $result['productId'];?>"><img src="admin/<?php echo $result['image'];?>" alt="" /></a>
                    <h2><?php echo $result['productName']?></h2>
                    <p><?php echo $fm->textShorten($result['body'],80);?></p>
                    <p><span class="price">$<?php echo $result['price'];?></span></p>
                    <div class="button"><span><a href="details.php?proid=<?php echo $result['productId'];?>" class="details">Details</a></span></div>
				</div>
                        <?php } }else{echo "<span style='color: red; font-size: 18px;'>No product available of this category!!!</span>";} ?>

			</div>

	
	
    </div>
 </div>
<?php include 'inc/footer.php'?>