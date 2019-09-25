<?php
$filpath=realpath(dirname(__FILE__));
include ($filpath.'/../lib/Session.php');
Session::checkLogin();
include_once($filpath.'/../lib/Database.php');
include_once($filpath.'/../helper/Format.php');


?>
<?php

/**
 * Created by PhpStorm.
 * Customer: Akil
 * Date: 12/7/2017
 * Time: 12:06 AM
 */
class Adminlogin
{
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db=new Database();
        $this->fm=new Format();

    }

    public function adminLogin($adminUser,$adminPass){
        $adminUser=$this->fm->validation($adminUser);
        $adminPass=$this->fm->validation($adminPass);

        $adminUser=mysqli_real_escape_string($this->db->link,$adminUser);
        $adminPass=mysqli_real_escape_string($this->db->link,$adminPass);

        if (empty($adminUser) || empty($adminPass)){
            $loginmsg="Field must not be empty";
            return $loginmsg;
        }else{
            // $sql="SELECT * FROM tbl_admin";
            // $res=$this->db->select($sql);
            // while($row=$res->fetch_assoc()){
            //     $pass=$row['adminPass'];
            
            // }
            // $newpass=md5($pass);
            // echo $newpass;
            // die();
           

            $query="SELECT * FROM tbl_admin WHERE adminUser='$adminUser' AND adminPass='$adminPass'";
            $result=$this->db->select($query);
            
            if ($result!=false)
            {
                $value=$result->fetch_assoc();
                Session::set('login',true);
                Session::set('adminId',$value['adminId']);
                Session::set('adminUser',$value['adminUser']);
                Session::set('adminName',$value['adminName']);
                header("Location:dashbord.php");
            }else{
                $loginmsg="Username and password not match!!";
                return $loginmsg;

            }
        }

    }


}