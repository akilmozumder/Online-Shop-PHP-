<?php
$filepath=realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helper/Format.php');
?>
<?php


/**
 * Created by PhpStorm.
 * Customer: Akil
 * Date: 12/8/2017
 * Time: 12:50 PM
 */
class Brand
{
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db=new Database();
        $this->fm=new Format();
    }

    public function brandInsert($brandName){
        $brandName=$this->fm->validation($brandName);
        $brandName=mysqli_real_escape_string($this->db->link,$brandName);

        if (empty($brandName)){
            $msg="<span class='error'>Field must not be empty!!</span>";
            return $msg;
        }else{
            $query="INSERT INTO tbl_brand(brandName)VALUES ('$brandName')";
            $result=$this->db->insert($query);
            if ($result){
                $msg="<span class='success'>Brand inserted successfully!!</span>";
                return $msg;

            }else{
                $msg="<span class='error'>Brand inserted failed!!</span>";
                return $msg;
            }
        }

    }
    public function brandUpdate($brandName,$id){
        $brandName=$this->fm->validation($brandName);
        $brandName=mysqli_real_escape_string($this->db->link,$brandName);

        if (empty($brandName)){
            $msg="<span class='error'>Field must not be empty!!</span>";
            return $msg;
        }else{
            $query="Update tbl_brand SET brandName='$brandName' WHERE brandId='$id'";
            $result=$this->db->update($query);
            if ($result){
                $msg="<span class='success'>Brand updated successfully!!</span>";
                return $msg;

            }else{
                $msg="<span class='error'>Brand updated failed!!</span>";
                return $msg;
            }
        }

    }
    public function getAllBrand(){
        $query="SELECT * FROM tbl_brand order by brandId DESC ";
        $result=$this->db->select($query);
        return $result;
    }

    public function deleteBrand($id){
        $query="DELETE FROM tbl_brand WHERE brandId='$id'";
        $result=$this->db->delete($query);
        if ($result){
            $msg="<span class='success'>Brand deleted successfully!!</span>";
            return $msg;
        }else {
            $msg = "<span class='error'>Brand deleted failed!!</span>";
            return $msg;
        }
    }


    public function getBrandById($id){
        $query="SELECT * FROM tbl_brand WHERE brandId='$id'";
        $result=$this->db->select($query);
        return $result;
    }

}
?>