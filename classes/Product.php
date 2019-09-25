<?php
$filepath=realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helper/Format.php');
?>

<?php

/**
 * Created by PhpStorm.
 * Customer: Akil
 * Date: 12/10/2017
 * Time: 6:19 PM
 */
class Product
{
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db=new Database();
        $this->fm=new Format();
    }
    public function insertProduct($data,$file){
        $productName=$this->fm->validation($data['productName']);
        $catId=$this->fm->validation($data['catId']);
        $brandId=$this->fm->validation($data['brandId']);
        $body=$this->fm->validation($data['body']);
        $price=$this->fm->validation($data['price']);
        $type=$this->fm->validation($data['type']);



        $productName=mysqli_real_escape_string($this->db->link,$productName);
        $catId=mysqli_real_escape_string($this->db->link,$catId);
        $brandId=mysqli_real_escape_string($this->db->link,$brandId);
        $body=mysqli_real_escape_string($this->db->link,$body);
        $price=mysqli_real_escape_string($this->db->link,$price);
        $type=mysqli_real_escape_string($this->db->link,$type);

        $permited  = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
        $uploaded_image = "upload/".$unique_image;



        if ($productName=="" || $catId=="" || $brandId=="" || $body=="" || $price=="" || $file_name=="" || $type=="")
        {
            return $msg= "<span class='error'>Field must not be empty...</span>";
        }
        elseif ($file_size >1048567) {
            return  $msg= "<span class='error'>Image Size should be less then 1MB!</span>";
        } elseif (in_array($file_ext, $permited) === false) {
            return $msg= "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
        } else {
            move_uploaded_file($file_temp, $uploaded_image);
            $query="INSERT INTO tbl_product(productName,catId,brandId,body,price,image,type) VALUES ('$productName','$catId','$brandId','$body','$price','$uploaded_image','$type')";
            $result=$this->db->insert($query);
            if ($result){
                $msg="<span class='success'>Product inserted successfully!!</span>";
                return $msg;
            }else{
                $msg="<span class='error'>Product inserted failed!!</span>";
                return $msg;
                }

            }
        }

        public function getAllProduct(){
            $query="select p.*, c.categoryName, b.brandName
            from tbl_product as p, tbl_category as c, tbl_brand as b 
            WHERE p.catId=c.catId AND p.brandId=b.brandId
            ORDER BY p.productId DESC 
            ";
           // $query="SELECT * FROM tbl_product order by productId DESC ";
            $result=$this->db->select($query);
            return $result;

        }

        public function getProductById($id){
            $query="SELECT * FROM tbl_product WHERE productId='$id'";
            $result=$this->db->select($query);
            return $result;
        }

        public function updateProduct($data,$file,$id){
            $productName=$this->fm->validation($data['productName']);
            $catId=$this->fm->validation($data['catId']);
            $brandId=$this->fm->validation($data['brandId']);
            $body=$this->fm->validation($data['body']);
            $price=$this->fm->validation($data['price']);
            $type=$this->fm->validation($data['type']);



            $productName=mysqli_real_escape_string($this->db->link,$productName);
            $catId=mysqli_real_escape_string($this->db->link,$catId);
            $brandId=mysqli_real_escape_string($this->db->link,$brandId);
            $body=mysqli_real_escape_string($this->db->link,$body);
            $price=mysqli_real_escape_string($this->db->link,$price);
            $type=mysqli_real_escape_string($this->db->link,$type);

            $permited  = array('jpg', 'jpeg', 'png', 'gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
            $uploaded_image = "upload/".$unique_image;

            if ($productName=="" || $catId=="" || $brandId=="" || $body=="" || $price=="" || $type=="")
            {
                return $msg= "<span class='error'>Field must not be empty...</span>";
            }else {
                if (!empty($file_name)) {

                    if ($file_size > 1048567) {
                        return $msg= "<span class='error'>Image Size should be less then 1MB!</span>";
                    } elseif (in_array($file_ext, $permited) === false) {
                        return $msg= "<span class='error'>You can upload only:-" . implode(', ', $permited) . "</span>";
                    } else {
                        move_uploaded_file($file_temp, $uploaded_image);
                        $query = "UPDATE tbl_product 
                            SET
                             productName='$productName',
                             catId='$catId',
                             brandId='$brandId',
                             body='$body',
                             price='$price',
                             image='$uploaded_image',
                             type='$type'
                             WHERE productId=$id";
                        $updated_row = $this->db->update($query);
                        if ($updated_row) {
                            return $msg= "<span class='success'>Data Updated Successfully. </span>";
                        } else {
                            return $msg= "<span class='error'>Data Not Updated !</span>";
                        }
                    }
                } else {
                    $query = "UPDATE tbl_product 
                            SET
                             productName='$productName',
                             catId='$catId',
                             brandId='$brandId',
                             body='$body',
                             price='$price',
                             type='$type'
                             WHERE productId=$id";
                    $updated_row = $this->db->update($query);
                    if ($updated_row) {
                        return $msg= "<span class='success'>Data Updated Successfully. </span>";
                    } else {
                        return $msg= "<span class='error'>Data Not Updated !</span>";
                    }

                }

            }
        }
    public function delete($id){
        $query="select * from tbl_product where productId='$id' ";
        $getData=$this->db->select($query);
        if ($getData){
            while ($delImg=$getData->fetch_assoc()){
                $dellink=$delImg['image'];
                unlink($dellink);
            }
        }
        $delquery="DELETE FROM tbl_product WHERE productId='$id'";
        $result=$this->db->delete($delquery);
        if ($result){
            $msg="<span class='success'>Product deleted successfully!!</span>";
            return $msg;
        }else {
            $msg = "<span class='error'>Product deleted failed!!</span>";
            return $msg;
        }
    }

    public function getFeaturePd(){
        $query="SELECT * FROM tbl_product WHERE type='0' order by productId DESC LIMIT 4";
        $result=$this->db->select($query);
        return $result;
    }
    public function getNewProduct(){
        $query="SELECT * FROM tbl_product order by productId DESC LIMIT 4";
        $result=$this->db->select($query);
        return $result;
    }
    public function getSingleProduct($id){
        $query="select p.*, c.categoryName, b.brandName
            from tbl_product as p, tbl_category as c, tbl_brand as b 
            WHERE p.catId=c.catId AND p.brandId=b.brandId AND p.productId='$id'";
        $result=$this->db->select($query);
        return $result;
    }
    public function getLatestIphone(){
        $query="SELECT * FROM tbl_product WHERE brandId='1' order by productId DESC LIMIT 1";
        $result=$this->db->select($query);
        return $result;
    }
    public function getLatestSamsung(){
        $query="SELECT * FROM tbl_product WHERE brandId='2' order by productId DESC LIMIT 1";
        $result=$this->db->select($query);
        return $result;
    }
    public function getLatestAcer(){
        $query="SELECT * FROM tbl_product WHERE brandId='3' order by productId DESC LIMIT 1";
        $result=$this->db->select($query);
        return $result;
    }
    public function getLatestCanon(){
        $query="SELECT * FROM tbl_product WHERE brandId='4' order by productId DESC LIMIT 1";
        $result=$this->db->select($query);
        return $result;
    }
    public function getProductByCategory($id){
        $catId=mysqli_real_escape_string($this->db->link,$id);
        $query="SELECT * FROM tbl_product WHERE catId='$catId'";
        $result=$this->db->select($query);
        return $result;
    }

    public function insertCompareData($cmrId,$compareId)
    {
        $cmrId = mysqli_real_escape_string($this->db->link, $cmrId);
        $productId = mysqli_real_escape_string($this->db->link, $compareId);
        $cquery = "SELECT * FROM tbl_compare WHERE cmrId='$cmrId' AND productId='$productId'";
        $check = $this->db->select($cquery);
        if ($check){
            $msg="<span style='color: red'> Already added this product!!</span>";
            return $msg;
        }

        $query = "SELECT * FROM tbl_product WHERE productId='$productId'";
        $result = $this->db->select($query)->fetch_assoc();
        if ($result) {
            $productId = $result['productId'];
            $productName = $result['productName'];
            $price = $result['price'];
            $image = $result['image'];
            $query = "INSERT INTO tbl_compare(cmrId,productId,productName,price,image) VALUES ('$cmrId','$productId','$productName','$price','$image')";
            $inserted_row = $this->db->insert($query);
            if ($inserted_row){
                $msg="<span style='color: green'> Product added to compare list successfully!!</span>";
                return $msg;

            }else{
                $msg="<span style='color: red'> Compare added failed!!</span>";
                return $msg;
            }
        }
    }
    public function getComparedProduct($cmrId){
        $query="SELECT * FROM tbl_compare WHERE cmrId='$cmrId' order by id DESC";
        $result=$this->db->select($query);
        return $result;
    }

    public function deleteCompareData($cmrId){
        $query="DELETE FROM tbl_compare WHERE cmrId='$cmrId'";
        $result=$this->db->delete($query);
    }

    public function saveToWishList($cmrId,$id){
        $cmrId = mysqli_real_escape_string($this->db->link, $cmrId);
        $productId = mysqli_real_escape_string($this->db->link, $id);
        $cquery = "SELECT * FROM tbl_wishlist WHERE cmrId='$cmrId' AND productId='$productId'";
        $check = $this->db->select($cquery);
        if ($check){
            $msg="<span style='color: red'> Already added this product!!</span>";
            return $msg;
        }

        $query = "SELECT * FROM tbl_product WHERE productId='$productId'";
        $result = $this->db->select($query)->fetch_assoc();
        if ($result) {
            $productId = $result['productId'];
            $productName = $result['productName'];
            $price = $result['price'];
            $image = $result['image'];
            $query = "INSERT INTO tbl_wishlist(cmrId,productId,productName,price,image) VALUES ('$cmrId','$productId','$productName','$price','$image')";
            $inserted_row = $this->db->insert($query);
            if ($inserted_row){
                $msg="<span style='color: green'> Product added to Wishlist successfully!!</span>";
                return $msg;

            }else{
                $msg="<span style='color: red'> added failed!!</span>";
                return $msg;
            }
        }
    }

    public function getWishListData($cmrId){
        $query="SELECT * FROM tbl_wishlist WHERE cmrId='$cmrId' order by id DESC";
        $result=$this->db->select($query);
        return $result;

    }

    public function delWishListData($id){
        $query="DELETE FROM tbl_wishlist WHERE productId='$id'";
        $result=$this->db->delete($query);
        if ($result){
            $msg="<span style='color: red; font-size: 18px'>Product removed successfully..</span>";
            return $msg;
        }
    }

    public function getAllAcerProduct(){
        $query="Select * from tbl_product WHERE brandId='3' ORDER BY productId DESC LIMIT 4";
        $result=$this->db->select($query);
        return $result;
    }
    public function getAllSamsungProduct(){
        $query="Select * from tbl_product WHERE brandId='2' ORDER BY productId DESC LIMIT 4";
        $result=$this->db->select($query);
        return $result;
    }
    public function getAllCanonProduct(){
        $query="Select * from tbl_product WHERE brandId='4' ORDER BY productId DESC LIMIT 4";
        $result=$this->db->select($query);
        return $result;
    }




}