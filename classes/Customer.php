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
class Customer
{
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db=new Database();
        $this->fm=new Format();
    }

    public function customerRegistration($data){
        $name=$this->fm->validation($data['name']);
        $address=$this->fm->validation($data['address']);
        $city=$this->fm->validation($data['city']);
        $country=$this->fm->validation($data['country']);
        $zip=$this->fm->validation($data['zip']);
        $phone=$this->fm->validation($data['phone']);
        $email=$this->fm->validation($data['email']);
        $password=$this->fm->validation($data['password']);

        $name=mysqli_real_escape_string($this->db->link,$name);
        $address=mysqli_real_escape_string($this->db->link,$address);
        $city=mysqli_real_escape_string($this->db->link,$city);
        $country=mysqli_real_escape_string($this->db->link,$country);
        $zip=mysqli_real_escape_string($this->db->link,$zip);
        $phone=mysqli_real_escape_string($this->db->link,$phone);
        $email=mysqli_real_escape_string($this->db->link,$email);
        $password=mysqli_real_escape_string($this->db->link,md5($password));

        if ($name=="" || $address=="" || $city=="" || $country=="" || $zip=="" || $phone=="" || $email=="" || $password=="" )
        {
            return $msg= "<span style='color: red; font-size: 18px;'>Field must not be empty...</span>";
        }
        $mailQuery="Select * from tbl_customer where email='$email' LIMIT 1";
        $mailChk=$this->db->select($mailQuery);
        if ($mailChk != false){
            return $msg= "<span style='color: red; font-size: 18px;'>Email already exists!!!</span>";
        }else{
            $query="INSERT INTO tbl_customer(name,address,city,country,zip,phone,email,password) VALUES ('$name','$address','$city','$country','$zip','$phone','$email','$password')";
            $result=$this->db->insert($query);
            if ($result){
                $msg="<span style='color: green; font-size: 18px; '>Customer registration successfully!!</span>";
                return $msg;
            }else{
                $msg="<span style='color: red; font-size: 18px;'>Customer registration failed!!!</span>";
                return $msg;
            }
        }

    }

    public function customerLogin($data){
        $email=mysqli_real_escape_string($this->db->link,$data['email']);
        $password=mysqli_real_escape_string($this->db->link,md5($data['password']));
        if (empty($email) || empty($password)){
            $msg="<span style='color: red; font-size: 18px;'>Field must not be empty!!!</span>";
            return $msg;
        }
        $query="Select * from tbl_customer WHERE email='$email' AND password='$password'";
        $result=$this->db->select($query);
        if ($result != false){
            $value=$result->fetch_assoc();
            Session::set("cuslogin",true);
            Session::set("cusId",$value['id']);
            Session::set("cusName",$value['name']);
            header("Location:cart.php");
        }else{
            $msg="<span style='color: red; font-size: 18px;'>Email and Password not matched!!!</span>";
            return $msg;
        }
    }
    public function customerData($cmrId){
        $query="Select * from tbl_customer WHERE id='$cmrId'";
        $result=$this->db->select($query);
        return $result;
    }

    public function customerUpdate($data,$cmrId){
        $name=$this->fm->validation($data['name']);
        $address=$this->fm->validation($data['address']);
        $city=$this->fm->validation($data['city']);
        $country=$this->fm->validation($data['country']);
        $zip=$this->fm->validation($data['zip']);
        $phone=$this->fm->validation($data['phone']);
        $email=$this->fm->validation($data['email']);

        $name=mysqli_real_escape_string($this->db->link,$name);
        $address=mysqli_real_escape_string($this->db->link,$address);
        $city=mysqli_real_escape_string($this->db->link,$city);
        $country=mysqli_real_escape_string($this->db->link,$country);
        $zip=mysqli_real_escape_string($this->db->link,$zip);
        $phone=mysqli_real_escape_string($this->db->link,$phone);
        $email=mysqli_real_escape_string($this->db->link,$email);

        if ($name=="" || $address=="" || $city=="" || $country=="" || $zip=="" || $phone=="" || $email==""  )
        {
            return $msg= "<span style='color: red; font-size: 18px;'>Field must not be empty...</span>";
        } else{
            $query = "UPDATE tbl_customer 
                            SET
                             name='$name',
                             address='$address',
                             city='$city',
                             country='$country',
                             zip='$zip',
                             phone='$phone',
                             email='$email'
                             WHERE id='$cmrId'";
            $updated_row = $this->db->update($query);
            if ($updated_row) {
                return $msg= "<span style='color: green; font-size: 18px;'>Customer Details Updated Successfully. </span>";
            } else {
                return $msg= "<span style='color: red; font-size: 18px;'>Customer Details Not Updated !</span>";
            }
        }
    }

}