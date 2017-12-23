<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Record extends My_Controller {
	public function __construct(){
		parent::__construct();
	}//end
	public function index()
	{
		$this->my_page_builder('data/record_view','Record');
	}
}
