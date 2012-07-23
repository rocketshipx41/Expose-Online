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
            $update_params['related_artists'] = array();
            if ($this->input->post('related-artists')) {
                $this->page_data['trace'] .= 'process artist list<br/>';
                $artists = array();
                $temp = $this->input->post('original-artists');
                if ( ( $temp ) && (count($temp))) {
                    foreach ($temp as $item) {
                        $artists[$item] = 'delete';
                    }
                }
                foreach ($this->input->post('related-artists') as $item){
                    if (array_key_exists($item, $artists)){
                        $this->page_data['trace'] .= $item . ': item already in list<br/>';
                        unset($artists[$item]);
                    }
                    else {
                        $this->page_data['trace'] .= $item . ': added to list<br/>';
                        $artists[$item] = 'insert';
                    }
                }
                $update_params['related_artists'] = $artists;
            }
            $update_result = $this->Release_model->update($update_params);
        }
        
        // get info
        $release_info = $this->Release_model->get_release_info($release_id);
        $this->page_data['trace'].= 'release info: ' . print_r($release_info, TRUE)
                . '<br/>';
        $release_artist_list = $this->Release_model->get_release_artists($release_id);
        
        // lists for dropdowns
        $label_list = $this->Label_model->get_list(TRUE);
        $release_type_list = $this->Masterdata_model->get_release_type_list(TRUE);
	$artist_list = $this->Artist_model->get_list(0, 0);
        $artist_select_list = array();
        foreach ($artist_list as $key => $item) {
            $artist_select_list[$key] = $item['display'];
        }
	$this->page_data['artist_select_list'] = $artist_select_list;
        
        // display
        $this->page_data['release_info'] = $release_info;
        $this->page_data['label_list'] = $label_list;
        $this->page_data['release_type_list'] = $release_type_list;
        $this->page_data['release_artist_list'] = $release_artist_list;
        $this->page_data['artist_select_list'] = $artist_select_list;
        $this->page_data['action'] = $action;
        $this->page_data['trace'] .= $this->Release_model->trace;
        $this->page_data['trace'] .= $this->Label_model->trace;
        $this->page_data['trace'] .= $this->Masterdata_model->trace;
        // echo $this->page_data['trace']; exit;
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'])
                ->build('releases/edit_form', $this->page_data);
    }
    
    function add($artist_id = 0)
    {
        // init
        $action = 'update';
        $this->load->model('Label_model');
        $this->load->model('Masterdata_model');
        
        // get info
        if ($artist_id != 0 ) {
            $artist_info = $this->Artist_model->get_base_info($artist_id);
        }
        $release_info = $this->Release_model->get_release_info(0);
        $this->page_data['trace'].= 'release info: ' . print_r($release_info, TRUE)
                . '<br/>';
        $release_info['artist'] = $artist_info['name'];
        $release_info['display_artist']= $artist_info['display'];
        $release_artist_list = array($artist_id => $artist_id);
        
        // lists for dropdowns
        $label_list = $this->Label_model->get_list(TRUE);
        $release_type_list = $this->Masterdata_model->get_release_type_list(TRUE);
	$artist_list = $this->Artist_model->get_list(0, 0);
        $artist_select_list = array();
        foreach ($artist_list as $key => $item) {
            $artist_select_list[$key] = $item['display'] . ' (' 
                    . $item['country_id'] . ')';
        }
	$this->page_data['artist_select_list'] = $artist_select_list;
        
        // display
        $this->page_data['release_info'] = $release_info;
        $this->page_data['label_list'] = $label_list;
        $this->page_data['release_type_list'] = $release_type_list;
        $this->page_data['release_artist_list'] = $release_artist_list;
        $this->page_data['artist_select_list'] = $artist_select_list;
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

