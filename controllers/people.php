<?php

/* * *************************************************************
 * Date         Author      Purpose
 *
 * $Header: $
 * ************************************************************* */

class People extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Whatsnew_model', '');
		$this->load->model('Works_model', '');
	}
	
	function index($type = 'all', $style = 'comb')
	{
		// init
		$this->page_data['page_name'] = 'Works';
		$this->page_data['whatsnew_list'] = $this->Whatsnew_model->get_latest(5);
		
		// display
		$this->template
				->title('Majipoor.com', $this->page_data['page_name'])
				->set_layout('majipoor')
				->build('item_list', $this->page_data);
	}
	
	function biography($id = 1)
	{
		// init
		$this->page_data['page_name'] = 'Robert Silverg biography';
		$this->page_data['menu_active'] = 'bio';
		$this->page_data['whatsnew_list'] = $this->Whatsnew_model->get_latest(5);
		
		// display
		$this->template
				->title('Majipoor.com', $this->page_data['page_name'])
				->set_layout('majipoor')
				->build('biography', $this->page_data);		
	}

	function display($slug = '')
	{
		// get info
		
		// display
	}
	
	function add()
	{
		// add a new person
	}
	
	function edit()
	{
		//
	}
	
}
