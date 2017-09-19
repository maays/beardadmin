<?php 

class Category_model extends MY_Model {

    function getCategory($id){
    $cat_id = $id;
    $sql = "SELECT * FROM `homepage_categories` where  id='$cat_id' and status = 1";
    $query = $this->db->query($sql);
    if ( $query->num_rows() > 0 )
    {   
     return $query->result_array();
    }
}


    function getCategories(){
    $sql = "SELECT * FROM `homepage_categories` where status = 1  limit 12";
    $query = $this->db->query($sql);
    if ( $query->num_rows() > 0 )
    {   
     return $query->result_array();
    }
}
	
    function getCategoryContest($cat_id) {
    $id = $cat_id;
    $sql = "SELECT * FROM `monthly_contests` where cat_id = $id  and status = 1 ";
    $query = $this->db->query($sql);
    if ( $query->num_rows() > 0 )
    {  

     return $query->result_array();
    }
    }
    
}
    