<?php
$filepath=realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helper/Format.php');
?>
<?php

class Category
{
    private $db;
    private $fm;
    public function __construct()
    {
        $this->db=new Database();
        $this->fm=new Format();
    }

    public function catInsert($category){
        $category=$this->fm->validation($category);
        $category=mysqli_real_escape_string($this->db->link,$category);

        if (empty($category)){
            $msg="<span class='error'>Field must not be empty!!</span>";
            return $msg;
        }else{
            $query="INSERT INTO tbl_category(categoryName)VALUES ('$category')";
            $result=$this->db->insert($query);
            if ($result){
                $msg="<span class='success'>Category inserted successfully!!</span>";
                return $msg;

            }else{
                $msg="<span class='error'>Category inserted failed!!</span>";
                return $msg;
            }
        }

    }

    public function catUpdate($category,$id){
        $category=$this->fm->validation($category);
        $category=mysqli_real_escape_string($this->db->link,$category);

        if (empty($category)){
            $msg="<span class='error'>Field must not be empty!!</span>";
            return $msg;
        }else{
            $query="Update tbl_category SET categoryName='$category' WHERE catId='$id'";
            $result=$this->db->update($query);
            if ($result){
                $msg="<span class='success'>Category updated successfully!!</span>";
                return $msg;

            }else{
                $msg="<span class='error'>Category updated failed!!</span>";
                return $msg;
            }
        }

    }
    public function deleteCategory($id){
        $query="DELETE FROM tbl_category WHERE catId='$id'";
        $result=$this->db->delete($query);
        if ($result){
            $msg="<span class='success'>Category deleted successfully!!</span>";
            return $msg;
        }else {
            $msg = "<span class='error'>Category deleted failed!!</span>";
            return $msg;
        }
    }

    public function getAllCat(){
        $query="SELECT * FROM tbl_category order by catId DESC ";
        $result=$this->db->select($query);
        return $result;
    }

    public function getCatById($id){
        $query="SELECT * FROM tbl_category WHERE catId='$id'";
        $result=$this->db->select($query);
        return $result;
    }

    public function getAllBrand(){
        $query="SELECT * FROM tbl_brand order by brandId DESC ";
        $result=$this->db->select($query);
        return $result;
    }




}
