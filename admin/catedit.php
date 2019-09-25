<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/Category.php';?>
<?php
if (!isset($_GET['editid'])||$_GET['editid']=='NULL'){
    echo "<script>window.location='catlist.php';</script>";
}else{
    $id=$_GET['editid'];
}

$cat=new Category();
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $category=$_POST['categoryName'];
    $category=$cat->catUpdate($category,$id);
}
?>
    <div class="grid_10">
        <div class="box round first grid">
            <h2>Update Category</h2>
            <div class="block copyblock">
                <?php
                if (isset($category)){
                    echo $category;
                }
                ?>

                <?php
                    $getCat=$cat->getCatById($id);
                    if ($getCat){
                        while ($result=$getCat->fetch_assoc()){
                ?>
                <form action="" method="post">
                    <table class="form">
                        <tr>
                            <td>
                                <input type="text" name="categoryName" value="<?php echo $result['categoryName']?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" name="submit" Value="Update" />
                            </td>
                        </tr>
                    </table>
                </form>
                        <?php } } ?>
            </div>
        </div>
    </div>
<?php include 'inc/footer.php';?>