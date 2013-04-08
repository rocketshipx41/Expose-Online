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
            $this->page_data['trace'] .= 'id is ' . $user_record[0]['id'];
            $this->User_model->update_user_profile($user_record[0]['id'],
                    array(
                        'sort_name' => $this->input->post('sortname'),
                        'display_name' => $this->input->post('fullname'),
                        'initials' => $this->input->post('initials')
                    )
            );
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
        //$data[] = array('id' => 43, 'initials' => 'mt', 'display_name' => 'Mike Taylor', 'sort_name' => 'Taylor, Mike');
        $this->db->update_batch('user_profiles', $data, 'id'); 
    }
    
    function qixnyb()
    {
        if ( ENVIRONMENT != 'development' ) {
            $this->load->dbforge();
            $this->dbforge->add_column('user_profiles', 
                    array('initials varchar(5) NULL'));
        }
        $initials = array();
        $initials[] = array('id' => 41, 'initials' => 'am');
        $initials[] = array('id' => 38, 'initials' => 'as');
        $initials[] = array('id' => 23, 'initials' => 'cm');
        $initials[] = array('id' => 40, 'initials' => 'cm2');
        $initials[] = array('id' => 14, 'initials' => 'da');
        $initials[] = array('id' => 18, 'initials' => 'db');
        $initials[] = array('id' => 30, 'initials' => 'db2');
        $initials[] = array('id' => 8, 'initials' => 'dc');
        $initials[] = array('id' => 12, 'initials' => 'dc2');
        $initials[] = array('id' => 33, 'initials' => 'dd');
        $initials[] = array('id' => 25, 'initials' => 'df');
        $initials[] = array('id' => 37, 'initials' => 'dm');
        $initials[] = array('id' => 11, 'initials' => 'ds');
        $initials[] = array('id' => 39, 'initials' => 'gl');
        $initials[] = array('id' => 6, 'initials' => 'hs');
        $initials[] = array('id' => 27, 'initials' => 'jb');
        $initials[] = array('id' => 31, 'initials' => 'jc');
        $initials[] = array('id' => 2, 'initials' => 'jld');
        $initials[] = array('id' => 4, 'initials' => 'jm');
        $initials[] = array('id' => 15, 'initials' => 'js');
        $initials[] = array('id' => 36, 'initials' => 'kl');
        $initials[] = array('id' => 28, 'initials' => 'mb');
        $initials[] = array('id' => 9, 'initials' => 'md');
        $initials[] = array('id' => 7, 'initials' => 'me');
        $initials[] = array('id' => 10, 'initials' => 'mg');
        $initials[] = array('id' => 22, 'initials' => 'mk');
        $initials[] = array('id' => 21, 'initials' => 'mm');
        $initials[] = array('id' => 17, 'initials' => 'mo');
        $initials[] = array('id' => 29, 'initials' => 'pd');
        $initials[] = array('id' => 13, 'initials' => 'ph');
        $initials[] = array('id' => 5, 'initials' => 'pt');
        $initials[] = array('id' => 3, 'initials' => 'ptlk');
        $initials[] = array('id' => 34, 'initials' => 'pz');
        $initials[] = array('id' => 19, 'initials' => 'rn');
        $initials[] = array('id' => 32, 'initials' => 'rs');
        $initials[] = array('id' => 20, 'initials' => 'rw');
        $initials[] = array('id' => 26, 'initials' => 'sp');
        $initials[] = array('id' => 16, 'initials' => 'sr');
        $initials[] = array('id' => 35, 'initials' => 'ss');
        $initials[] = array('id' => 24, 'initials' => 'wp');

        $this->db->update_batch('user_profiles', $initials, 'id'); 
	$this->session->set_flashdata('message', 'Column added.');
	redirect('util');
    }

}

/* End of file util.php */
/* Location: ./application/controllers/util.php */