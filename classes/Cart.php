<?php
$filepath=realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helper/Format.php');
?>
<?php

/**
 * Created by PhpStorm.
 * Customer: Akil
 * Date: 12/12/2017
 * Time: 12:35 PM
 */
class Cart
{
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db=new Database();
        $this->fm=new Format();
    }

    public function addToCart($quantity,$id){
        $quantity=$this->fm->validation($quantity);
        $quantity=mysqli_real_escape_string($this->db->link,$quantity);
        $productId=mysqli_real_escape_string($this->db->link,$id);
        $sessionId=session_id();

        $squery="SELECT * FROM tbl_product WHERE productId='$productId'";
        $result=$this->db->select($squery)->fetch_assoc();

        $productName=$result['productName'];
        $price=$result['price'];
        $image=$result['image'];

        $chkQuery="SELECT * FROM tbl_cart WHERE productId='$productId' AND sessionId='$sessionId'";
        $getPro=$this->db->select($chkQuery);
        if ($getPro){
            return $msg="Product Already Added!";
        }
        else {

            $query = "INSERT INTO tbl_cart(sessionId,productId,productName,price,quantity,image) VALUES ('$sessionId','$productId','$productName','$price','$quantity','$image')";
            $result = $this->db->insert($query);
            if ($result) {
                header("Location:cart.php");
            } else {
                header("Location:404.php");
            }
        }

    }

    public function getAllCart(){
        $sId=session_id();
        $squery="SELECT * FROM tbl_cart WHERE sessionId='$sId'";
        $result=$this->db->select($squery);
        return $result;

    }

    public function updateCartQuantity($cartId,$quantity){
        $cartId=$this->fm->validation($cartId);
        $quantity=$this->fm->validation($quantity);
        $cartId=mysqli_real_escape_string($this->db->link,$cartId);
        $quantity=mysqli_real_escape_string($this->db->link,$quantity);

        $query = "UPDATE tbl_cart 
                            SET
                             quantity='$quantity' 
                             WHERE cartId='$cartId'";
        $updated_row = $this->db->update($query);
        if ($updated_row) {
            header("Location:cart.php");
        } else {
            return $msg= "<span style='color: red; font-size: 18px;'>Quantity Not Updated !</span>";
        }
    }

    public function deleteProductFromCart($delid){
        $delid=mysqli_real_escape_string($this->db->link,$delid);
        $query="DELETE FROM tbl_cart WHERE cartId='$delid'";
        $result=$this->db->delete($query);
        if ($result){
            echo "<script>Window.location='cart.php';</script>";
        }
    }
    public function checkCartData(){
        $sId=session_id();
        $query="SELECT * FROM tbl_cart WHERE sessionId='$sId'";
        $result=$this->db->select($query);
        return $result;
    }
    public function deleteCart(){
        $sid=session_id();
        $query="Delete from tbl_cart WHERE sessionId='$sid'";
        $result=$this->db->delete($query);
        return $result;
    }
    public function orderProduct($cmrId){
        $sId=session_id();
        $query="SELECT * FROM tbl_cart WHERE sessionId='$sId'";
        $getProduct=$this->db->select($query);
        if ($getProduct){
            while ($result=$getProduct->fetch_assoc()){
                $productId=$result['productId'];
                $productName=$result['productName'];
                $quantity=$result['quantity'];
                $price=$result['price']*$quantity;
                $image=$result['image'];
                $query = "INSERT INTO tbl_order(cmrId,productId,productName,quantity,price,image) VALUES ('$cmrId','$productId','$productName','$quantity','$price','$image')";
                $result = $this->db->insert($query);
            }
        }


    }
    public function payableAmount($cmrId){
        $query="SELECT price FROM tbl_order WHERE cmrId='$cmrId' AND date=now()";
        $result=$this->db->select($query);
        return $result;
    }
    public function getAllProduct($cmrId){
        $query="SELECT * FROM tbl_order WHERE cmrId='$cmrId' ORDER BY date DESC ";
        $result=$this->db->select($query);
        return $result;
    }
    public function chkOrder($cmrId){
        $query="SELECT * FROM tbl_order WHERE cmrId='$cmrId'";
        $result=$this->db->select($query);
        return $result;
    }
    public function getAllOrderDetails(){
        $query="SELECT * FROM tbl_order ORDER BY date DESC ";
        $result=$this->db->select($query);
        return $result;
    }
    public function shiftedOrder($id,$time,$price){
        $id=mysqli_real_escape_string($this->db->link,$id);
        $time=mysqli_real_escape_string($this->db->link,$time);
        $price=mysqli_real_escape_string($this->db->link,$price);

        $query="Update tbl_order SET status='1' WHERE cmrId='$id' AND date='$time' AND price='$price'";
        $result=$this->db->update($query);
        if ($result){
            $msg="<span class='success'> updated successfully!!</span>";
            return $msg;

        }else{
            $msg="<span class='error'> updated failed!!</span>";
            return $msg;
        }
    }
    public function delShiftedProduct($id,$time,$price){
        $id=mysqli_real_escape_string($this->db->link,$id);
        $time=mysqli_real_escape_string($this->db->link,$time);
        $price=mysqli_real_escape_string($this->db->link,$price);

        $query="DELETE FROM tbl_order WHERE cmrId='$id' AND date='$time' AND price='$price'";
        $result=$this->db->delete($query);
        if ($result){
            $msg="<span class='success'>deleted successfully!!</span>";
            return $msg;
        }else {
            $msg = "<span class='error'>deleted failed!!</span>";
            return $msg;
        }
    }

    public function confirmOrder($id,$time,$price){
        $id=mysqli_real_escape_string($this->db->link,$id);
        $time=mysqli_real_escape_string($this->db->link,$time);
        $price=mysqli_real_escape_string($this->db->link,$price);

        $query="Update tbl_order SET status='2' WHERE cmrId='$id' AND date='$time' AND price='$price'";
        $result=$this->db->update($query);
        if ($result){
            $msg="<span class='success'> updated successfully!!</span>";
            return $msg;

        }else{
            $msg="<span class='error'> updated failed!!</span>";
            return $msg;
        }
    }

}