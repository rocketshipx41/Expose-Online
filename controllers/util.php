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
        $this->page_data['show_columns'] = '2';
	
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
        $this->page_data['trace'] .= '>> newuser<br/>';
        if ( $this->input->post('submit') ) {
            $this->tank_auth->create_user($this->input->post('login'), 
                    $this->input->post('email'), 
                    $this->input->post('login'), FALSE);
            $user_record = $this->User_model->get_user_by_username($this->input->post('login'));
            $this->page_data['trace'] .= 'result is ' . print_r($user_record, TRUE) . '<br/>';
            //$this->page_data['trace'] .= $this->User_model->trace; echo $this->page_data['trace']; exit;
            $this->User_model->update_user_profile($user_record->id,
                    array(
                        'sort_name' => $this->input->post('sortname'),
                        'display_name' => $this->input->post('fullname')
                    )
            );
            $this->User_model->update_user_group($user_record->id, 0, 4); // staff
            $this->page_data['trace'] .= $this->User_model->trace;
            $this->session->set_flashdata('message', 'New user ' 
                    . $this->input->post('login') . ' added.');
        }
	$this->load->helper('form');
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'])
                ->set_layout('base')
                ->build('util/util_home', $this->page_data);	
    }
    
    function snort()
    {
        $data = array();
        $data[] = array('id' => 44, 'initials' => 'bn', 'display_name' => 'Bob Netherton', 'sort_name' => 'Netherton Bob');
        $data[] = array('id' => 43, 'initials' => 'mt', 'display_name' => 'Mike Taylor', 'sort_name' => 'Taylor, Mike');
        $data[] = array('id' => 43, 'initials' => 'mt', 'display_name' => 'Mike Taylor', 'sort_name' => 'Taylor, Mike');
        $this->db->update_batch('user_profiles', $data, 'id'); 
    }
    
}

/* End of file util.php */
/* Location: ./application/controllers/util.php */