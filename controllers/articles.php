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
	
    public function index($category_slug = '')
    {
	if ($category_slug == '') {
	    redirect('');
	}
	elseif ($category_slug == 'faqs') { // for faqs, list all
	    $this->page_data['page_name'] = lang('faqs_page_name');
	    $this->page_data['main_list'] = $this->Article_model->most_recent($category_slug, 0);
	}
	else { // for others, only most recent
	    $this->page_data['page_name'] = lang($category_slug . '_page_name');
	    $this->page_data['main_list'] = $this->Article_model->most_recent($category_slug);
	}
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'])
                ->build('articles/index_center', $this->page_data);
    }
    
    public function display($article_slug = '')
    {
	if ($article_slug == '') {
	    redirect('articles/index');
	}
	$article_info = $this->Article_model->get_full($article_slug);
	$this->page_data['article_info'] = $article_info;
	$this->page_data['credit_list'] = $this->Article_model->get_credits($article_info['id']);
	$this->page_data['topic_list'] = $this->Article_model->get_topics($article_info['id']);
	$this->page_data['page_name'] = $article_info['category_name'];
	$this->page_data['staff_list'] = $this->User_model->get_user_list(array(1, 3, 4));
	$this->page_data['category_list'] = $this->Article_model->get_category_list();
	
	$this->page_data['trace'] .= $this->Article_model->trace;
	$this->page_data['trace'] .= 'credit list: ' 
		. print_r($this->page_data['credit_list'], TRUE);
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'],
			$article_info['article_title'])
                ->set_partial('edit_form', 'articles/edit_form')
		->append_metadata('<script>$(document).ready(function(){changeCategory();});</script>')
                ->build('articles/display_center', $this->page_data);
    }
    
    public function add()
    {
	if ( ! $this->page_data['can_contribute']) {
	    redirect('articles/index');
	}
	$article_info = $this->Article_model->get_dummy();
	
	$this->page_data['page_name'] = $this->lang->line('article_new');
	$this->page_data['article_info'] = $article_info;
	$this->page_data['credit_list'] = array(
	    '1' => array($this->page_data['user_id'] => $this->page_data['user_name'])
	);
	$this->page_data['topic_list'] = array();
	$this->page_data['staff_list'] = $this->User_model->get_user_list(array(1, 3, 4));
	$this->page_data['category_list'] = $this->Article_model->get_category_list();

	$this->page_data['trace'] .= $this->Article_model->trace;
	$this->page_data['trace'] .= 'credit list: ' 
		. print_r($this->page_data['credit_list'], TRUE);
	$this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'])
                ->set_partial('edit_form', 'articles/edit_form')
		->append_metadata('<script>$(document).ready(function(){changeCategory();});</script>')
                ->build('articles/add_center', $this->page_data);
    }

    public function edit()
    {
	$user_input = array();
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
	if ($this->input->post('author')) {
	    $user_input['author'] = $this->input->post('author');
	}
	if ($this->input->post('body')) {
	    $user_input['body'] = $this->input->post('body');
	}
	if (count($user_input) == 0) {
	    redirect('articles/index');	    
	}
	$user_input['user_id'] = $this->page_data['user_id'];
	//echo print_r($user_input); exit;
	// validate
	$this->Article_model->update($user_input);
	redirect('articles/display/'. $this->input->post('slug'));
    }
    
}
