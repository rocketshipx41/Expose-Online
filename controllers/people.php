<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class People extends MY_Controller {

    function __construct()
    {
	parent::__construct();
	$this->page_data['trace'] .= '>> construct people controller<br/>';
	
	$this->page_data['page_name'] = 'Users';
	
	$this->load->model('User_model');
    }
    
    function display($user = '')
    {
        // init
	if ($user == '') {
	    redirect('');
	}
        
        // process
        $user_info = $this->User_model->get_user_info($user);
        if ( $user_info['id'] != $user ) {
            redirect('');
        }
        // list of all articles by user
        $article_list = $this->User_model->author_article_list($user_info['id']);
        
        // display
        $this->page_data['user_info'] = $user_info;
        $this->page_data['article_list'] = $article_list;
        $this->page_data['show_columns'] = 3;
        $this->page_data['banner_ad'] = $this->Ad_model->serve('top');
        $this->page_data['side_ad'] = $this->Ad_model->serve('side');
        $this->page_data['trace'] .= $this->User_model->trace;
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'],
                        $user_info['display_name'])
                ->build('users/display_center', $this->page_data);
    }
	
} // users controller
