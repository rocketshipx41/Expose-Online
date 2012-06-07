<?php

/* * *************************************************************
 * Date         Author      Purpose
 *
 * $Header: $
 * ************************************************************* */

class Alhanroel extends MY_Controller
{

	function __construct()
	{
	    parent::__construct();
	    $this->load->config('majipoor');
	    $this->load->model('Whatsnew_model', '');
	}
	
	function index()
	{
	    // init
	    $this->page_data['page_name'] = 'Home';
	    $this->page_data['menu_active'] = 'home';
	    $this->page_data['whatsnew_list'] = $this->Whatsnew_model->get_latest(5);

	    // display
	    $this->template
		    ->title($this->page_data['site_name'], $this->page_data['page_name'])
		    ->set_layout('majipoor')
		    ->build('home', $this->page_data);
	}
	
	function whatsnew()
	{
	    // init
	    $this->page_data['page_name'] = 'Site updates';
	    $this->page_data['menu_active'] = 'whatsnew';
	    $this->page_data['whatsnew_list'] = $this->Whatsnew_model->get_latest(5);
	    $this->page_data['main_list'] = $this->Whatsnew_model->get_latest(11);

	    // display
	    $this->template
		    ->title('Majipoor.com', $this->page_data['page_name'])
		    ->set_layout('majipoor')
		    ->build('home', $this->page_data);		
	}
	
	function contact()
	{
	    // display contract form, send message
	}
	
	/**
	 * secret unpublished login page 
	 */
	function login()
	{
	    //
	}

	
}
