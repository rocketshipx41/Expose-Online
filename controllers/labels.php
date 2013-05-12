<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Labels extends MY_Controller {

    function __construct()
    {
	parent::__construct();
	$this->page_data['trace'] .= '>> construct label controller<br/>';
	
	$this->page_data['page_name'] = 'Labels';
	
	$this->load->model('Label_model');
    }
    
    function index()
    {
        // init
        $this->page_data['page_name'] = 'Labels';
        $this->page_data['label_list'] = array();
        
        // process
        $this->page_data['label_list'] = $this->Label_model->get_list(FALSE);
        
        // display
        $this->page_data['trace'] .= $this->Label_model->trace;
        $this->page_data['show_columns'] = 3;
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'])
                ->build('labels/index_center', $this->page_data);
    }
    
    function display($id = 0)
    {
        if ( $id == 0 ) {
            redirect('labels/index');
        }
        
        // init
        $this->page_data['page_name'] = 'Labels';
        $this->page_data['label_list'] = array();
        $this->load->model('Release_model');
        
        // process
        $label_info = $this->Label_model->get_full($id);
        $this->page_data['label_info'] = $label_info;
        $this->page_data['release_list'] = $this->Release_model->get_list_by_label($id);
        
        // display
        $this->page_data['trace'] .= $this->Label_model->trace;
        $this->page_data['show_columns'] = 3;
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'],
                        $label_info['display'])
                ->build('labels/display_center', $this->page_data);
    }
    
    function edit($id = 0)
    {
        // authorize
	if ( ! $this->page_data['can_contribute']) {
	    redirect('labels/index');
	}
        
        if ( $this->input->post('label-id') ) {
            $this->page_data['action'] = 'update';
            $id = $this->input->post('label-id');
        }
        elseif ( $id == 0 ) {
            $this->page_data['action'] = 'insert';
        }
        else {
            $this->page_data['action'] = 'update';
        }
        
        // init
        $this->page_data['page_name'] = 'Labels';
        $this->page_data['label_list'] = array();
        $this->load->model('Masterdata_model');
        
        // handle incoming post
        if ( $this->input->post('label-submit') ) {
            $ok = TRUE;
            $update_params = array();
            if ($this->input->post('display-name') ) {
              $update_params['display'] = $this->input->post('display-name');
            }
            else {
                $ok = FALSE;
            }
            if ($this->input->post('sort-name') ) {
              $update_params['name'] = $this->input->post('sort-name');
            }
            else {
                $ok = FALSE;
            }
            if ($this->input->post('country') ) {
                $update_params['country_id'] = $this->input->post('country');
            }
            else {
                $update_params['country_id'] = '';
            }
            if ($this->input->post('label-url') ) {
                $update_params['url'] = $this->input->post('label-url');
            }
            else {
                $update_params['url'] = '';
                //$ok = FALSE;
            }
            if ($this->input->post('label-email') ) {
                $update_params['email'] = $this->input->post('label-email');
            }
            else {
                $update_params['email'] = '';
                //$ok = FALSE;
            }
            if ($this->input->post('label-address') ) {
                $update_params['address'] = $this->input->post('label-address');
            }
            else {
                $update_params['address'] = '';
                //$ok = FALSE;
            }
            if ($this->input->post('label-phone') ) {
                $update_params['phone'] = $this->input->post('label-phone');
            }
            else {
                $update_params['phone'] = '';
                //$ok = FALSE;
            }
            if ($this->input->post('info') ) {
                $update_params['info'] = $this->input->post('info');
            }
            else {
                $update_params['info'] = '';
            }
            if ( $ok ) {
                $update_result = $this->Label_model->update($id, $update_params);
                //echo $this->Label_model->trace; exit;
                if ( $update_result['status'] == 'ok' ) {
                    redirect('labels/display/' . $update_result['id']);
                }
            }
        }
        
        // process
        $label_info = $this->Label_model->get_full($id);
        $this->page_data['label_info'] = $label_info;
        $this->page_data['country_list'] = $this->Masterdata_model->get_country_list(TRUE);
        
        // display
        $this->page_data['trace'] .= $this->Label_model->trace;
        $this->page_data['show_columns'] = 3;
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'],
                        $label_info['display'])
                ->build('labels/edit_form', $this->page_data);
    }
    
}
