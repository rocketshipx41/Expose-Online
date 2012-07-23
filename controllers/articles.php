<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Articles extends MY_Controller {

    function __construct()
    {
	parent::__construct();
	$this->page_data['trace'] .= '>> construct article controller<br/>';
	
	$this->page_data['page_name'] = 'Articles';
	
	$this->load->model('Article_model');
    }
	
    public function index($category_slug = '', $offset = 0)
    {
	if ($category_slug == '') {
	    redirect('');
	}
	elseif ($category_slug == 'faqs') { // for faqs, list all
	    $this->page_data['page_name'] = lang('faqs_page_name');
	    $this->page_data['main_list'] = $this->Article_model->most_recent($category_slug, 
                    0, $offset);
	}
	else { // for others, only most recent
	    $this->page_data['page_name'] = lang($category_slug . '_page_name');
	    $this->page_data['main_list'] = $this->Article_model->most_recent($category_slug, 
                    5, $offset);
	}
        $this->page_data['category_slug'] = $category_slug;
        $this->page_data['topic_slug'] = '';
        $this->page_data['offset'] = $offset;
        $this->page_data['trace'] .= $this->Article_model->trace;
        $this->page_data['trace'] .= print_r($this->page_data['main_list'], TRUE) . '<br/>';
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'])
                ->build('articles/index_center', $this->page_data);
    }
    
    public function display($article_slug = '')
    {
        // authorize
	if ($article_slug == '') {
	    redirect('articles/index');
	}
        
        // init
        
        // process
	$article_info = $this->Article_model->get_full($article_slug);
	$this->page_data['credit_list'] = $this->Article_model->get_credits($article_info['id']);
	$this->page_data['topic_list'] = $this->Article_model->get_topics($article_info['id']);
        if (( count($this->page_data['topic_list'])) && ($article_info['category_id'] == 1)) {
            $remove_intro = TRUE;
            $this->page_data['trace'] .= 'review with topics<br/>';
            foreach ($this->page_data['topic_list'] as $item) {
                if ($item['topic_id'] == 5) {
                    $remove_intro = FALSE;
                }
            }
            if ( $remove_intro ) {
                $this->page_data['trace'] .= 'not a festival review, intro not needed<br/>';
                $article_info['intro'] = '';
            }
        }
        $this->page_data['meta'] = $this->Article_model->get_meta($article_info['id']);
	$this->page_data['artist_list'] = $this->Article_model->get_artists($article_info['id']);
	$this->page_data['release_list'] = $this->Article_model->get_releases($article_info['id']);
        $this->page_data['link_list'] = $this->Article_model->get_link_list($article_info['id']);
        $this->page_data['image_file'] = '';
	$this->page_data['page_name'] = $article_info['category_name'];
	$this->page_data['article_info'] = $article_info;
        
        // display
	$this->page_data['trace'] .= $this->Article_model->trace;
	$this->page_data['trace'] .= 'credit list: ' 
		. print_r($this->page_data['credit_list'], TRUE) . '<br/>';
	$this->page_data['trace'] .= 'topic list: ' 
		. print_r($this->page_data['topic_list'], TRUE) . '<br/>';
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'],
			$article_info['article_title'])
                ->build('articles/display_center', $this->page_data);
    }
    
    public function add()
    {
        // authorize
	if ( ! $this->page_data['can_contribute']) {
	    redirect('articles/index');
	}
        
        // init
        $this->load->model('Artist_model');
	
        // process
	$article_info = $this->Article_model->get_dummy();
	$this->page_data['page_name'] = $this->lang->line('article_new');
	$this->page_data['article_info'] = $article_info;
	$this->page_data['action'] = 'insert';
	$this->page_data['credit_list'] = array(
	    '1' => array($this->page_data['user_id'] => $this->page_data['user_name'])
	);
	$this->page_data['topic_list'] = array();
	$this->page_data['staff_list'] = $this->User_model->get_user_list(array(1, 3, 4));
	$this->page_data['category_list'] = $this->Article_model->get_category_list();
        // get lists for dropdowns
	$this->page_data['staff_list'] = $this->User_model->get_user_list(array(1, 3, 4));
	$this->page_data['category_list'] = $this->Article_model->get_category_list();
	$artist_list = $this->Artist_model->get_list(0, 0);
        $artist_select_list = array();
        foreach ($artist_list as $key => $item) {
            $artist_select_list[$key] = $item['display'];
        }
	$this->page_data['artist_select_list'] = $artist_select_list;
	$topic_list = $this->Article_model->get_topic_list();
        $topic_select_list = array();
        foreach ($topic_list as $key => $item) {
            $topic_select_list[$key] = $item['title'];
        }
	$this->page_data['topic_select_list'] = $topic_select_list;
        $this->page_data['artist_list'] = array();

        // display
	$this->page_data['trace'] .= $this->User_model->trace;
	$this->page_data['trace'] .= $this->Article_model->trace;
	$this->page_data['trace'] .= $this->Artist_model->trace;
	$this->page_data['trace'] .= 'credit list: ' 
		. print_r($this->page_data['credit_list'], TRUE);
	$this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'])
                ->set_partial('edit_form', 'articles/edit_form')
		->append_metadata('<script>$(document).ready(function(){changeCategory();});</script>')
                ->build('articles/add_center', $this->page_data);
    }
    
    public function edit($article_slug = '')
    {
        // authorize
        if ( $this->input->post('slug') ) {
            $article_slug = $this->input->post('slug');
        }
        if ( $this->input->post('action') ) {
            // it's an insert
        }
        elseif ( $article_slug == '' ) {
            redirect('welcome');
        }
        
        // init
        $this->load->model('Artist_model');
        
        // deal with incoming post
        if ( $this->input->post('article-submit') ) {
            $this->page_data['trace'] .= 'process incoming post<br/>';
            $article_id = $this->input->post('article-id');
            $update_params = array(
                'article_id' => $article_id,
                'user_id' => $this->input->post('user-id'),
                'slug' => $this->input->post('slug')
             );
            $ok = TRUE;
            if ( $this->input->post('title') ) {
                $update_params['title'] = $this->input->post('title');
            }
            else {
                $ok = FALSE;
            }
            if ( $this->input->post('category') ) {
                $update_params['category_id'] = $this->input->post('category');
            }
            else {
                $ok = FALSE;
            }
            if ( $this->input->post('body') ) {
                $update_params['body'] = $this->input->post('body');
            }
            else {
                $ok = FALSE;
            }
            if ( $this->input->post('intro') ) {
                $update_params['intro'] = $this->input->post('intro');
            }
            else {
                $update_params['intro'] = '';
            }
            if ( $this->input->post('make-live') ) {
                $update_params['status'] = 'live';
            }
            else {
                $update_params['status'] = 'draft';
            }
            if ($this->input->post('author')) {
                $this->page_data['trace'] .= 'process author list<br/>';
                $credits = array();
                $temp = $this->input->post('original-author');
                if ( ( $temp ) && (count($temp))) {
                    foreach ($temp as $item) {
                        $credits[$item] = array('action' => 'delete');
                    }
                }
                foreach ($this->input->post('author') as $item){
                    if (array_key_exists($item, $credits)){
                        $this->page_data['trace'] .= $item . ': item already in list<br/>';
                        unset($credits[$item]);
                    }
                    else {
                        $this->page_data['trace'] .= $item . ': added to list<br/>';
                        $credits[$item] = array('action' => 'insert');
                    }
                }
                $update_params['author'] = $credits;
            }
            else {
                $ok = FALSE;
            }
            if ($this->input->post('topic')) {
                $this->page_data['trace'] .= 'process topic list<br/>';
                $topics = array();
                $temp = $this->input->post('original-topics');
                if ( ( $temp ) && (count($temp))) {
                    foreach ($temp as $item) {
                        $topics[$item] = 'delete';
                    }
                }
                foreach ($this->input->post('topic') as $item){
                    if (array_key_exists($item, $topics)){
                        $this->page_data['trace'] .= $item . ': item already in list<br/>';
                        unset($topics[$item]);
                    }
                    else {
                        $this->page_data['trace'] .= $item . ': added to list<br/>';
                        $topics[$item] = 'insert';
                    }
                }
                $update_params['topic'] = $topics;
            }
            else {
                $update_params['topic'] = array();
            }
            if ($this->input->post('artist')) {
                $this->page_data['trace'] .= 'process artist list<br/>';
                $artists = array();
                $temp = $this->input->post('original-artists');
                if ( ( $temp ) && (count($temp))) {
                    foreach ($temp as $item) {
                        $artists[$item] = 'delete';
                    }
                }
                foreach ($this->input->post('artist') as $item){
                    if (array_key_exists($item, $artists)){
                        $this->page_data['trace'] .= $item . ': item already in list<br/>';
                        unset($artists[$item]);
                    }
                    else {
                        $this->page_data['trace'] .= $item . ': added to list<br/>';
                        $artists[$item] = 'insert';
                    }
                }
                $update_params['artist'] = $artists;
            }
            else {
                $update_params['artist'] = array();
            }
            if ( $ok ) {
                $update_result = $this->Article_model->update($update_params);
                if ( $update_result['status'] == 'ok' ) {
                    $article_slug = $update_result['slug'];
                }
            }
        }
        
        // process
        // get article info
	$article_info = $this->Article_model->get_full($article_slug);
	$this->page_data['credit_list'] = $this->Article_model->get_credits($article_info['id']);
	$topic_list = $this->Article_model->get_topics($article_info['id']);
        if (( count($topic_list)) && ($article_info['category_id'] == 1)) {
            $remove_intro = TRUE;
            $this->page_data['trace'] .= 'review with topics<br/>';
            foreach ($topic_list as $item) {
                if ($item['topic_id'] == 5) {
                    $remove_intro = FALSE;
                }
            }
            if ( $remove_intro ) {
                $this->page_data['trace'] .= 'not a festival review, intro not needed<br/>';
                $article_info['intro'] = '';
            }
        }
        $this->page_data['topic_list'] = array();
        foreach ($topic_list as $item) {
            $this->page_data['topic_list'][$item['topic_id']] = $item['title'];
        }
	//$artist_list = $this->Article_model->get_artists($article_info['id']);
	$this->page_data['artist_list'] = $this->Article_model->get_artists($article_info['id']);
	$this->page_data['release_list'] = $this->Article_model->get_releases($article_info['id']);
        $this->page_data['meta'] = $this->Article_model->get_meta($article_info['id']);
        
        // get lists for dropdowns
	$this->page_data['staff_list'] = $this->User_model->get_user_list(array(1, 3, 4));
	$this->page_data['category_list'] = $this->Article_model->get_category_list();
	$artist_list = $this->Artist_model->get_list(0, 0);
        $artist_select_list = array();
        foreach ($artist_list as $key => $item) {
            $artist_select_list[$key] = $item['display'] . ' (' 
                    . $item['country_id'] . ')';
        }
	$this->page_data['artist_select_list'] = $artist_select_list;
	$topic_list = $this->Article_model->get_topic_list();
        $topic_select_list = array();
        foreach ($topic_list as $key => $item) {
            $topic_select_list[$key] = $item['title'];
        }
	$this->page_data['topic_select_list'] = $topic_select_list;
	$this->page_data['article_info'] = $article_info;
	$this->page_data['action'] = 'update';
        
        // display
        $this->page_data['trace'] .= 'topic list: ' . print_r($this->page_data['topic_list'],
                TRUE) . '<br/>';
        $this->page_data['trace'] .= 'artist list: ' . print_r($this->page_data['artist_list'],
                TRUE) . '<br/>';
        $this->page_data['trace'] .= $this->Article_model->trace;
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'],
			$article_info['article_title'])
		->append_metadata('<script>$(document).ready(function(){changeCategory();});</script>')
                ->build('articles/edit_form', $this->page_data);
        
    }

    public function old_edit()
    {
	$user_input = array();
        $credits = array();
        $artists = array();
        $topics = array();
	if ($this->input->post('user-id')) {
	    $user_input['submitter'] = $this->input->post('user-id');
	}
	if ($this->input->post('article-id')) {
	    $user_input['article_id'] = $this->input->post('article-id');
	}
	else {
	    $user_input['article_id'] = 0;
	}
	if ($this->input->post('category')) {
	    $user_input['category'] = $this->input->post('category');
	}
	if ($this->input->post('title')) {
	    $user_input['title'] = $this->input->post('title');
	}
	if ($this->input->post('intro')) {
	    $user_input['intro'] = $this->input->post('intro');
	}
        else {
            $user_input['intro'] = smart_trim($this->input->post('body'), 200);
        }
	if ($this->input->post('author')) {
            $this->page_data['trace'] .= 'process author list<br/>';
            $temp = $this->input->post('original-author');
            if (count($temp)) {
                foreach ($temp as $item) {
                    $credits[$item] = array('action' => 'delete');
                }
            }
            foreach ($this->input->post('author') as $item){
                if (array_key_exists($item, $credits)){
                    $this->page_data['trace'] .= $item . ': item already in list<br/>';
                    unset($credits[$item]);
                }
                else {
                    $this->page_data['trace'] .= $item . ': added to list<br/>';
                    $credits[$item] = array('action' => 'insert');
                }
            }
	    $user_input['author'] = $credits;
	}
	if ($this->input->post('artist')) {
            $this->page_data['trace'] .= 'process artist list<br/>';
            $temp = $this->input->post('original-artists');
            if (count($temp)) {
                foreach ($temp as $item) {
                    $artists[$item] = 'delete';
                }
            }
            foreach ($this->input->post('artist') as $item){
                if (array_key_exists($item, $artists)){
                    $this->page_data['trace'] .= $item . ': item already in list<br/>';
                    unset($artists[$item]);
                }
                else {
                    $this->page_data['trace'] .= $item . ': added to list<br/>';
                    $artists[$item] = 'insert';
                }
            }
	    $user_input['artist'] = $artists;
	}
	if ($this->input->post('topic')) {
            $this->page_data['trace'] .= 'process topic list<br/>';
            $temp = $this->input->post('original-topics');
            if (count($temp)) {
                foreach ($temp as $item) {
                    $topics[$item] = 'delete';
                }
            }
            foreach ($this->input->post('topic') as $item){
                if (array_key_exists($item, $topics)){
                    $this->page_data['trace'] .= $item . ': item already in list<br/>';
                    unset($topics[$item]);
                }
                else {
                    $this->page_data['trace'] .= $item . ': added to list<br/>';
                    $topics[$item] = 'insert';
                }
            }
	    $user_input['topic'] = $topics;
	}
	if ($this->input->post('body')) {
	    $user_input['body'] = $this->input->post('body');
	}
	if (count($user_input) == 0) {
	    redirect('articles/index');	    
	}
	$user_input['user_id'] = $this->page_data['user_id'];
	// validate
	$this->Article_model->update($user_input);
        $this->page_data['trace'] .= $this->Article_model->trace;
	echo $this->page_data['trace'] . '<br/>' . anchor('articles/display/'. $this->input->post('slug')); exit;
	redirect('articles/display/'. $this->input->post('slug'));
    }
    
    public function topic($topic_slug = '', $offset = 0)
    {
        $this->page_data['page_name'] = lang($topic_slug . '_page_name');
        $this->page_data['main_list'] = $this->Article_model->get_topic_articles($topic_slug, 
                5, $offset);
        
        $this->page_data['topic_slug'] = $topic_slug;
        $this->page_data['category_slug'] = '';
        $this->page_data['offset'] = $offset;
        $this->page_data['trace'] .= $this->Article_model->trace;
        $this->page_data['trace'] .= print_r($this->page_data['main_list'], TRUE) . '<br/>';
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'])
                ->build('articles/index_center', $this->page_data);
    }
    
    public function drafts()
    {
        // authorize
        
        // init
        $this->page_data['offset'] = 0;
        $this->page_data['category_slug'] = '';
        $this->page_data['topic_slug'] = '';
        
        // process
        $this->page_data['main_list'] = $this->Article_model->draft_list();
       
        // display
        $this->page_data['trace'] .= $this->Article_model->trace;
        $this->page_data['trace'] .= print_r($this->page_data['main_list'], TRUE) . '<br/>';
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'], 'Index')
                ->build('articles/index_center', $this->page_data);
    }
    
}
