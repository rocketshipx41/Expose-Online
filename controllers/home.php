<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Home extends MY_Controller {

    function __construct()
    {
	parent::__construct();
	
	$this->page_data['page_name'] = 'Welcome to Majipoor.com';
    }
	
    function index()
    {
	
    }
    
}
