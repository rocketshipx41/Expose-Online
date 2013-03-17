<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Artists extends MY_Controller {

    function __construct()
    {
	parent::__construct();
	$this->page_data['trace'] .= '>> construct artists controller<br/>';
	
	$this->page_data['page_name'] = 'Artists';
        $this->page_data['menu_active'] = 'artists';
	
	$this->load->model('Artist_model');
    }
    
    public function index($starter = '')
    {
        // authorize
        
        // init
        if ( $starter == '#' ) {
            // correct for incoming number/punctuation start
            $starter = '';
        }
        $this->page_data['nav_chars'] = '#abcdefghijklmnopqrstuvwxyz';
        
        // process
        if ( FALSE ) {
            $this->page_data['artist_list'] = 
                    $this->Artist_model->get_list($this->config->item('artist_index_items_per_page'),
                            $starter);
        }
        else {
            $this->page_data['artist_list'] = 
                    $this->Artist_model->article_artist_list($this->config->item('artist_index_items_per_page'),
                            $starter);
        }
        $this->page_data['backlink'] = $this->Artist_model->get_backlink($starter,
                $this->config->item('artist_index_items_per_page'));
        $this->page_data['starter'] = $starter;
        
        // display
        $this->page_data['trace'] .= $this->Artist_model->trace;
        $this->page_data['trace'] .= print_r($this->page_data['artist_list'], TRUE) . '<br/>';
        $this->page_data['show_columns'] = 3;
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'], 'Index')
                ->build('artists/index_center', $this->page_data);
    }
	
    public function display($artist_slug = '')
    {
        // authorize
        if ($artist_slug == '') {
            redirect('artists/index');
        }
        
        // init
        
        // process
        $artist_info = $this->Artist_model->get_info($artist_slug);
        $this->page_data['article_list'] = $this->Artist_model->get_article_list($artist_info['id']);
        $this->page_data['release_list'] = $this->Artist_model->get_release_list($artist_info['id']);
        $this->page_data['artist_info'] = $artist_info;
        
        // display
        $this->page_data['trace'] .= $this->Artist_model->trace;
        $this->page_data['trace'] .= print_r($this->page_data['artist_info'], TRUE) . '<br/>';
        $this->page_data['show_columns'] = 3;
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'],
                        $artist_info['display'])
                ->build('artists/display_center', $this->page_data);
    }
	
    public function edit($artist_slug = '')
    {
        // authorize
        if ( $this->input->post('slug') ) {
            $artist_slug = $this->input->post('slug');
        }
        //check for id?
        
        // init
	$this->load->model('Masterdata_model');
        $action = 'update';
        
        // handle incoming post
        if ( $this->input->post('artist-submit') ) {
            $ok = TRUE;
            $update_params = array(
                'slug' => $artist_slug
            );
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
                $ok = FALSE;
            }
            if ( $artist_slug == '' ) {
                $artist_slug = create_unique_slug($update_params['name'] . '-'
                        . $update_params['country_id'], 'artists');
            }
            if ($this->input->post('artist-url') ) {
              $update_params['url'] = $this->input->post('artist-url');
            }
            else {
              $update_params['url'] = '';
                //$ok = FALSE;
            }
            if ($this->input->post('country') ) {
              $update_params['country_id'] = $this->input->post('country');
            }
            else {
                $ok = FALSE;
            }
            if ($this->input->post('artist-image') ) {
              $update_params['image_file'] = $this->input->post('artist-image');
            }
            else {
                $ok = FALSE;
            }
            if ($this->input->post('info') ) {
              $update_params['info'] = $this->input->post('info');
            }
            else {
                $ok = FALSE;
            }
            if ($this->input->post('artist-id') ) {
              $artist_id = $this->input->post('artist-id');
            }
            if ( $ok ) {
                $update_result = $this->Artist_model->update_info($artist_id, $update_params);
                if ( $update_result['status'] == 'ok' ) {
                    redirect('artists/display/' . $artist_slug);
                }
            }
        }
        
        // process
        $artist_info = $this->Artist_model->get_info($artist_slug);
        $this->page_data['country_list'] = $this->Masterdata_model->get_country_list(TRUE);
        $this->page_data['artist_info'] = $artist_info;
        $this->page_data['action'] = $action;
        
        // display
        $this->page_data['trace'] .= $this->Artist_model->trace;
        $this->page_data['trace'] .= print_r($this->page_data['artist_info'], TRUE) . '<br/>';
        $this->page_data['show_columns'] = 2;
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'],
                        $artist_info['display'])
                ->build('artists/edit_form', $this->page_data);
    }
    
    public function assign($artist_id)
    {
        // init
        
        // deal with post
        
        // process
        $artist_info = $this->Artist_model->get_info($artist_slug);
        $this->page_data['artist_info'] = $artist_info;
        
        // get lists for dropdowns
        
        // display
    }
    
    public function search()
    {
        // authorize
        if ( $this->input->post('search-value') ) {
            $search_value = $this->input->post('search-value');
        }
        else {
            redirect('artists/index');
        }
        
        // init
        $starter = '';
        $this->page_data['nav_chars'] = '#abcdefghijklmnopqrstuvwxyz';
        $this->page_data['last_slug'] = '';
        
        // process
        $this->page_data['artist_list'] = 
                $this->Artist_model->search($search_value, 
                        $this->config->item('artist_index_items_per_page'),
                        $starter);
        $this->page_data['backlink'] = $this->Artist_model->get_backlink($starter,
                $this->config->item('artist_index_items_per_page'));
        $this->page_data['starter'] = $starter;
        
        // display
        $this->page_data['trace'] .= $this->Artist_model->trace;
        $this->page_data['trace'] .= print_r($this->page_data['artist_list'], TRUE) . '<br/>';
        $this->page_data['show_columns'] = 3;
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'], 'Index')
                ->build('artists/index_center', $this->page_data);
    }
    
    public function add()
    {
        // authorize
	if ( ! $this->page_data['can_contribute']) {
	    redirect('articles/index');
	}
        
        // init
	$this->load->model('Masterdata_model');
        
        // process
        $this->page_data['country_list'] = $this->Masterdata_model->get_country_list(TRUE);
        $this->page_data['artist_info'] = $this->Artist_model->get_info('');
        $this->page_data['action'] = 'insert';
        
        // display
        $this->page_data['show_columns'] = 2;
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'],
                        lang('artist_new'))
                ->build('artists/edit_form', $this->page_data);
    }
    
    public function util($task = 'img')
    {
        // authorize
	if ( ! $this->page_data['can_contribute']) {
	    redirect('articles/index');
	}
        
        // init
        echo 'perform task "' . $task. '"<br/>';
        $artist_list = $this->Artist_model->get_list();
        foreach ($artist_list as $id => $item) {
            if ($task == 'img' ) {
                if ( $item['image_file'] != 'artists/noimage.jpg' ) {
                    $file_name = 'assets/img/' . $item['image_file'];
                    if ( file_exists($file_name)) {
                        echo $file_name . ' assigned, exists<br/>';
                    }
                    else {
                        echo $file_name . ' assigned, not found<br/>';
                    }
                }
                else {
                    $file_name = 'assets/img/artists/' . $item['slug'] . '.jpg';
                    if ( file_exists($file_name)) {
                        echo $file_name . ' exists ***<br/>';
                        $this->Artist_model->update_info($id, 
                                array('image_file' => $file_name));
                    }
                    else {
                        echo $file_name . ' not found<br/>';
                    }
                }
            }
            elseif ( $task == 'ctry') {
                if ( $item['country_id'] == '???' ) {
                    echo $item['slug']. '<br/>';
                }
            }
        }

        // process
        
        // display
        echo $this->Artist_model->trace;
    }
    
}
