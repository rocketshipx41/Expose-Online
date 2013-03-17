<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ads extends MY_Controller {

    function __construct()
    {
	parent::__construct();
	$this->page_data['trace'] .= '>> construct ad controller<br/>';
	
	$this->page_data['page_name'] = 'Ads';
	
	$this->load->model('Ad_model');
    }
    
    function index()
    {
        // init
        $this->page_data['page_name'] = 'Manage ads';
        $this->page_data['ad_list'] = array();
        
        // process
        $this->page_data['ad_list'] = $this->Ad_model->get_all();
        
        // display
        $this->page_data['trace'] .= $this->Ad_model->trace;
        $this->page_data['show_columns'] = 2;
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'],
			lang('menu_ads'))
                ->build('ads/index_list', $this->page_data);
    }
    
}
