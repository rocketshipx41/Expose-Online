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
        $this->page_data['show_ads'] = FALSE;
    }
    
    function index()
    {
        // authorize
	if ( ! $this->page_data['can_contribute']) {
	    redirect('');
	}
        
        // init
        $this->page_data['page_name'] = 'Ads';
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
    
    function edit($id = 0)
    {
        // authorize
	if ( ! $this->page_data['can_contribute']) {
	    redirect('');
	}
        
        // init
        $this->page_data['page_name'] = 'Ads';
        $this->page_data['ad_list'] = array();
        $this->page_data['action'] = 'update';
        if ( $this->input->post('ad-id') ) {
            $id = $this->input->post('ad-id');
        }
        if ( $id == 0 ) {
            $this->page_data['action'] = 'insert';
        }
        
        // incoming post?
        if ( $this->input->post('ad-submit') ) {
            $user_input = array();
            $ok = TRUE;
            if ( $this->input->post('ad-title') ) {
                $user_input['title'] = $this->input->post('ad-title');
            }
            else {
                $ok = FALSE;
            }
            if ( $this->input->post('ad-alt') ) {
                $user_input['alt'] = $this->input->post('ad-alt');
            }
            else {
                $ok = FALSE;
            }
            if ( $this->input->post('ad-url') ) {
                $user_input['url'] = $this->input->post('ad-url');
            }
            else {
                $ok = FALSE;
            }
            if ( $this->input->post('ad-image') ) {
                $user_input['image_file'] = $this->input->post('ad-image');
            }
            else {
                $ok = FALSE;
            }
            if ( $this->input->post('position') ) {
                $user_input['position'] = $this->input->post('position');
            }
            if ( $this->input->post('status') ) {
                $user_input['status'] = $this->input->post('status');
            }
            if ( $this->input->post('start-date') ) {
                $user_input['start_date'] = $this->input->post('start-date');
            }
            if ( $this->input->post('end-date') ) {
                $user_input['end_date'] = $this->input->post('end-date');
            }
            if ( $this->input->post('ad-email') ) {
                $user_input['contact_email'] = $this->input->post('ad-email');
            }
            else {
                $ok = FALSE;
            }
            if ( $this->input->post('ad-paid') ) {
                $user_input['paid'] = '1';
            }
            else {
                $user_input['paid'] = '0';
            }
            if ( $ok ) {
                $update_result = $this->Ad_model->update($id, $user_input);
            } 
        }
        
        // process
        if ( $id ) {
            $this->page_data['ad_info'] = $this->Ad_model->get_all($id);
        }
        else {
            $this->page_data['ad_info'] = array(
                'id' => 0,
                'title' => '',
                'alt' => '',
                'image_file' => '',
                'position' => 'side',
                'status' => 'draft',
                'url' => '',
                'contact_email' => '',
                'start_date' => 0,
                'end_date' => 0,
                'paid' => 0
            );
        }
        
        // display
        $this->page_data['trace'] .= $this->Ad_model->trace;
        $this->page_data['show_columns'] = 2;
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'],
			lang('menu_ads'))
                ->build('ads/edit_form', $this->page_data);
    }
    
}
