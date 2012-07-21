<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * releases controller
 */

class Releases extends MY_Controller {

    function __construct()
    {
	parent::__construct();
	$this->page_data['trace'] .= '>> construct releases controller<br/>';
	
	$this->page_data['page_name'] = 'Releases';
	
	$this->load->model('Release_model');
	$this->load->model('Artist_model');
    }
    
    function index()
    {
        
    }
    
    function edit($release_id = 0)
    {
        // init
        $action = 'update';
        $this->load->model('Label_model');
        $this->load->model('Masterdata_model');
        
        // incoming post
        if ( $this->input->post('release-submit') ) {
            $update_params = array(
                'id' => $this->input->post('release-id'),
                'label_id' => $this->input->post('label-id'),
                'release_type_id' => $this->input->post('release-type'),
                'catalog_no' => $this->input->post('catalog-no'),
                'title' => $this->input->post('title'),
                'artist' => $this->input->post('artist'),
                'display_title' => $this->input->post('display-title'),
                'display_artist' => $this->input->post('display-artist'),
                'year_recorded' => $this->input->post('year-recorded'),
                'year_released' => $this->input->post('year-released'),
                'image_file' => $this->input->post('image-file'),
                'media' => $this->input->post('media'),
                'various_artists' => 0
            );
            if ( $this->input->post('various-artists') == 'va' ) {
                $update_params['various_artists'] = 1;
            }
            if ( ! $this->input->post('year-recorded') ) {
                $update_params['year_recorded'] = $this->input->post('year-released');
            }
            $update_result = $this->Release_model->update($update_params);
        }
        
        // get info
        $release_info = $this->Release_model->get_release_info($release_id);
        $this->page_data['trace'].= 'release info: ' . print_r($release_info, TRUE)
                . '<br/>';
        
        // lists for dropdowns
        $label_list = $this->Label_model->get_list(TRUE);
        $release_type_list = $this->Masterdata_model->get_release_type_list(TRUE);
        
        // display
        $this->page_data['release_info'] = $release_info;
        $this->page_data['label_list'] = $label_list;
        $this->page_data['release_type_list'] = $release_type_list;
        $this->page_data['action'] = $action;
        $this->page_data['trace'] .= $this->Release_model->trace;
        $this->page_data['trace'] .= $this->Label_model->trace;
        $this->page_data['trace'] .= $this->Masterdata_model->trace;
        // echo $this->page_data['trace']; exit;
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'])
                ->build('releases/edit_form', $this->page_data);
    }
    
    function util()
    {
        $this->load->model('Label_model');
        // $result = $this->Label_model->update_slugs();
    }
    
}

