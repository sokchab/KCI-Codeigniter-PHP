<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends My_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('admin/member_model','mem_model');
    }//end
    public function index()
    {
        $this->my_page_builder('admin/member_view','Member');
    }//end index

    public function fetch_member(){
        echo $this->mem_model->model_list_member();
    }//end fetch member

    public function add_member(){
        $this->my_validate();   // Call validate()
        $data=array(
            //table fields      //control name
            'mem_code'  =>  $this->input->post('mem_code'),
            'mem_name'  =>  $this->input->post('mem_name'),
            'mem_gender'  =>  $this->input->post('mem_gender'),
            'mem_phone'  =>  $this->input->post('mem_phone'),
            'mem_dob'  =>  $this->input->post('mem_dob')
        );
        $this->mem_model->model_insert_member($data);
        echo json_encode(array("status" => TRUE ));
    }//end add_member

    private function my_validate(){
        $data=array();
        $data['error_string']=array();
        $data['inputerror']=array();
        $data['status']=TRUE;

        if($this->input->post('mem_code') == ""){
            $data['inputerror'][] = 'mem_code';
            $data['error_string'][] = "Code is required";
            $data['status'] = FALSE;
        }

        if($this->input->post('mem_name') == ""){
            $data['inputerror'][] = 'mem_name';
            $data['error_string'][] = "Name is required";
            $data['status'] = FALSE;
        }

        if($data['status']=== FALSE){
            echo json_encode($data);
            exit();
        }
    }//end validate
}//end class
