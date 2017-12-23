<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*SELECT `mem_id`, `mem_code`, `mem_name`, `mem_gender`, `mem_phone`, `mem_dob` FROM `tb_member` */
class Member_Model extends My_Model{
    function __construct(){
        parent::__construct();
        $this->my_table = 'tb_member';
        $this->my_column_order = array(null,'mem_code','mem_name','mem_gender','mem_phone','mem_dob');
        $this->my_column_search = array('mem_code','mem_name','mem_gender','mem_phone','mem_dob');
        $this->my_order = array('mem_id' => 'asc');
    }//end

    public function model_list_member()
    {
        $list = $this->my_result_builder();
        $data = array();
        foreach ($list as $emp) {
            $row = array();
            $row[] = $emp->mem_code;
            $row[] = $emp->mem_name;
            $row[] = $emp->mem_gender;
            $row[] = $emp->mem_phone;
            $row[] = $emp->mem_dob;

            $row[]='<div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm" onclick="edit_member('.$emp->mem_id.')"><i class="glyphicon glyphicon-pencil" style="color:#2b5a7a"></i></button>
                        <button type="button" class="btn btn-default btn-sm" onclick="delete_member('.$emp->mem_id.')"><i class="glyphicon glyphicon-trash" style="color:red"></i></button>
                    </div>';

            $data[] = $row;
        }
        return $this->my_json_builder($data);
    }//end model_list_emp

    public function model_insert_member($data){
        $this->db->insert($this->my_table, $data);
        return $this->db->insert_id();
    }//end model_insert_member

}//end Class