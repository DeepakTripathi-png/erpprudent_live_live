<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model 

{

    public function user_details()

    {

        $query= $this->db->query("SELECT tu.*,tr.role_name,td.designation_name FROM tbl_user as tu left join tbl_role as tr on tu.role_id = tr.role_id left join tbl_designation as td on tu.designation_id = td.designation_id where tu.display = 'Y' Order by tu.user_id ASC ");

        if($query->num_rows()>0)

        {

            foreach ($query->result() as $row)

            {

                $tbl_data[]=$row;

            }

            return $tbl_data;

        }

        else

        {

            return false;

        }

    }



    public function edit_user_details($id)

    {

        $query= $this->db->query("SELECT tu.*,tr.role_name,td.designation_name FROM tbl_user as tu left join tbl_role as tr on tu.role_id = tr.role_id left join tbl_designation as td on tu.designation_id = td.designation_id where tu.display = 'Y' AND tu.user_id= $id ",array($id));

        if($query->num_rows()==1) 

        {

            return $query->row(); 

        } 

        else 

        {

            return false; 

        } 

    }

}?>