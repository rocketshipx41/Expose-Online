<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Util extends MY_Controller 
{

    function __construct()
    {
	parent::__construct();
	
	$this->page_data['page_name'] = 'Utilities';
	
	if ($this->page_data['user_group_id'] != 1) {
	    redirect('');
	}
    }
    
    function index()
    {
	$this->load->helper('form');
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'])
                ->set_layout('base')
                ->build('util/util_home', $this->page_data);	
    }
	
    function newuser()
    {
	$this->tank_auth->create_user($this->input->post('login'), 
		$this->input->post('email'), 
		$this->input->post('login'), FALSE);
	$this->session->set_flashdata('message', 'New user ' 
		. $this->input->post('login') . ' added.');
	redirect('util');
    }

}

/* End of file util.php */
/* Location: ./application/controllers/util.php */