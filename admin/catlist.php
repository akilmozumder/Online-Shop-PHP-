<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
include '../classes/Category.php';
$cat=new Category();
?>
<?php
    if(isset($_GET['delid'])){
        $id=$_GET['delid'];
        $delcat=$cat->deleteCategory($id);
    }
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Category List</h2>
                <?php
                    if (isset($delcat)){
                        echo $delcat;
                    }
                ?>
                <div class="block">        
                    <table class="data display datatable" id="example">
					<thead>

						<tr>
							<th>Serial No.</th>
							<th>Category Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
                    <?php
                    $getCat=$cat->getAllCat();
                    if ($getCat){
                        $i=0;
                        while ($result=$getCat->fetch_assoc()){
                            $i++;
                            ?>
						<tr class="odd gradeX">
							<td><?php echo $i;?></td>
							<td><?php echo $result['categoryName']?></td>
							<td><a href="catedit.php?editid=<?php echo $result['catId'];?>">Edit</a> || <a onclick="return confirm('Are you sure to delete?')" href="?delid=<?php echo $result['catId'];?>">Delete</a></td>
						</tr>
                    <?php } } ?>

					</tbody>
				</table>
               </div>
            </div>
        </div>
<script type="text/javascript">
	$(document).ready(function () {
	    setupLeftMenu();

	    $('.datatable').dataTable();
	    setSidebarHeight();
	});
</script>
<?php include 'inc/footer.php';?>

