<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class MY_Controller extends CI_Controller
{
    
    public $page_data = array();
    
    function __construct()
    {
        parent::__construct();
	$this->page_data['trace'] = '>> construct my controller<br/>';
	
	// global housekeeping
	$this->page_data['site_name'] = $this->config->item('site_name');
	$this->page_data['site_slogan'] = $this->config->item('site_slogan');
	$this->page_data['copyright'] = $this->config->item('copyright');
	$this->page_data['license'] = $this->config->item('license');
	$this->page_data['system_status_message'] = '';
	$this->page_data['page_alerts'] = array();
        $this->page_data['menu_active'] = 'home';
	$this->page_data['page_name'] = '';
        $this->template
                ->set_layout('base')
		->set_partial('menu', 'home/menu');
	
	// incoming flash message?
	$this->page_data['load_message'] = $this->session->flashdata('message');
	$this->page_data['hits'] = $this->Masterdata_model->get_hit_count();
	// user status
	if ($this->tank_auth->is_logged_in()) { // logged in
	    $this->page_data['is_logged_in'] = TRUE;
	    $this->page_data['user_name'] = $this->tank_auth->get_username();
	    $this->page_data['user_id'] = $this->tank_auth->get_user_id();
	    $temp = $this->User_model->get_user_group($this->page_data['user_id']);
	    $this->page_data['user_group_id'] = $temp[0]['group_id'];
	    $this->page_data['user_group_name'] = $temp[0]['name'];
            // contributors: admin, editors, staff
	    $this->page_data['can_contribute'] = ($temp[0]['group_id'] == 1)
		    || ($temp[0]['group_id'] == 3) || ($temp[0]['group_id'] == 4);
            // editors: admin, editors
	    $this->page_data['can_edit'] = ($temp[0]['group_id'] == 1)
		    || ($temp[0]['group_id'] == 3);
	}
	else {
	    $this->page_data['is_logged_in'] = FALSE;
	    $this->page_data['user_name'] = '';
	    $this->page_data['user_id'] = 0;
	    $this->page_data['user_group_id'] = 0;
	    $this->page_data['user_group_name']= '';
	    $this->page_data['can_contribute'] = FALSE;
	    $this->page_data['can_edit'] = FALSE;
	}
        $this->page_data['news_list'] = $this->Article_model->most_recent('news', 
                    5, 0);
        $this->page_data['event_list'] = $this->Article_model->most_recent('events', 
                    5, 0, FALSE);
        $this->page_data['recommendation_list'] = $this->Article_model->get_random('recommendations', 
                    1);
        $this->page_data['show_ads'] = TRUE; // set to false in controller if not wanted
        $this->page_data['left_column_ad'] = FALSE; // set to true is column ad on left
        $this->page_data['scale_video'] = 's';
        $this->template->set_partial('left_column', 'left_column');
        $this->template->set_partial('right_column', 'right_column');
        $this->page_data['hits'] = $this->Masterdata_model->update_hit_count($this->page_data['hits']);
    }
    
	/**
	 * add an alert to be displayed at the top of the page
	 * type can be:
	 * - error (red)
	 * - success (green)
	 * - info (blue)
	 * - danger (??)
	 * 
	 * @param type $alert_type
	 * @param type $message 
	 */
	function add_alert($alert_type, $message)
	{
		$alert_text = '';
		if ( is_array($message)) {
            //$alert_text = print_r($message, TRUE);
			$alert_text = implode('<br/>', $message);
		}
		else {
			$alert_text = $message;
		}
		$this->page_data['page_alerts'][] = array(
			'message' => $alert_text,
			'type' => $alert_type
		);
	}
	
	function set_flashdata_alert($alert_type, $message)
	{
        $full_message = $message;
        if ( $this->status_code ) {
            $full_message .= ' (' . $this->status_code . ')';
        }
		$this->session->set_flashdata(array(
			'page_alert_message' => $full_message,
			'page_alert_type' => $alert_type			
		));
		
	}
    
}

