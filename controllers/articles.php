<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * 2013-05-05 add photog update
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
                    10, $offset);
	}
        if ($category_slug == 'news') {
            // don't put news in the left column on the news page
            $this->page_data['news_list'] = array();
        }
        elseif ( $category_slug == 'recommendations' ) {
            // don't put media on media page
            $this->page_data['recommendation_list'] = array();
            $this->page_data['scale_video'] = 'm';
        }
        $this->page_data['item_count'] = $this->Article_model->get_count($category_slug);
        $this->page_data['category_slug'] = $category_slug;
        $this->page_data['menu_active'] = $category_slug;
        $this->page_data['topic_slug'] = '';
        $this->page_data['offset'] = $offset;
        $this->page_data['trace'] .= print_r($this->page_data['main_list'], TRUE) . '<br/>';
        $this->page_data['show_columns'] = 3;
        $this->page_data['banner_ad'] = $this->Ad_model->serve('top');
        $this->page_data['side_ad'] = $this->Ad_model->serve('side');
        $this->page_data['trace'] .= $this->Article_model->trace;
        $this->page_data['trace'] .= $this->Ad_model->trace;
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
        $this->page_data['show_columns'] = 3;
        $this->load->model('Release_model');
        
        // process
        $this->page_data['roundtable'] = FALSE;
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
        if ( $article_info['category_id'] == 4 ) {
            $this->page_data['show_columns'] = 2;
            $this->page_data['trace'] .= 'feature article, only 2 column layout<br/>';
        }
        if ( $article_info['category_id'] == 8 ) {
            $this->page_data['show_columns'] = 2;
            $this->page_data['scale_video'] = 'l';
            $this->page_data['trace'] .= 'recommendation, 2 columns, large video<br/>';
        }
        $this->page_data['meta'] = $this->Article_model->get_meta($article_info['id']);
	$this->page_data['artist_list'] = $this->Article_model->get_artists($article_info['id']);
	$release_list = $this->Article_model->get_releases($article_info['id']);
        $related_list = array();
        if ( ( $article_info['category_id'] == 1 ) && count($release_list) ) {
            $this->page_data['trace'] .= 'review of a release(s), look for others<br/>';
            foreach ($release_list as $item) {
                $temp = $this->Release_model->get_article_list($item['release_id']);
                foreach ( $temp as $art ) { // don't include link to self
                    if ( $art['slug'] != $article_slug ) {
                        $related_list[$art['article_id']] = $art;
                        $this->page_data['roundtable'] = TRUE;
                    }
                }
            }
        }
        if ($this->page_data['roundtable']) {
            foreach ($related_list as $id => &$art) {
                $temp = $this->Article_model->get_full($art['slug']);
                $art['body']= $temp['body'];
                $art['credit_list'] = $this->Article_model->get_credits($id);
                $art['published_on'] = $temp['published_on'];
            }
            $related_list[$article_info['id']] = array(
                'body' => $article_info['body'],
                'credit_list' => $this->page_data['credit_list'],
                'published_on' => $article_info['published_on']
            );
            $center_template = 'roundtable_center';
        }
        else {
            $center_template = 'display_center';
        }
	$this->page_data['release_list'] = $release_list;
        $this->page_data['related_list'] = $related_list;
        $this->page_data['link_list'] = $this->Article_model->get_link_list($article_info['id']);
        $this->page_data['image_file'] = '';
	$this->page_data['page_name'] = $article_info['category_name'];
	$this->page_data['article_info'] = $article_info;
        $this->page_data['menu_active'] = $article_info['category_slug'];
        $this->page_data['banner_ad'] = $this->Ad_model->serve('top');
        $this->page_data['side_ad'] = $this->Ad_model->serve('side');
        
        // display
	$this->page_data['trace'] .= $this->Article_model->trace;
        $this->page_data['trace'] .= $this->Ad_model->trace;
	$this->page_data['trace'] .= 'credit list: ' 
		. print_r($this->page_data['credit_list'], TRUE) . '<br/>';
	$this->page_data['trace'] .= 'topic list: ' 
		. print_r($this->page_data['topic_list'], TRUE) . '<br/>';
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'],
			$article_info['article_title'])
                ->build('articles/' . $center_template, $this->page_data);
    }
    
    public function add($category_id = 0, $release_id = 0)
    {
        // authorize
	if ( ! $this->page_data['can_contribute']) {
	    redirect('articles/index');
	}
        
        // init
        $this->load->model('Artist_model');
        $this->load->model('Masterdata_model');
        $this->load->model('Release_model');
        $this->page_data['show_ads'] = FALSE;
	
        // process
	$article_info = $this->Article_model->get_dummy();
	$this->page_data['page_name'] = $this->lang->line('article_new');
	$this->page_data['action'] = 'insert';
	$this->page_data['credit_list'] = array(
	    '1' => array($this->page_data['user_id'] => $this->page_data['user_name']),
            '2' => array()
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
        $artist_list = array();
        $topic_list = array();
        $this->page_data['issue_list'] = $this->Masterdata_model->get_issue_list(TRUE);
        if ( $category_id ) {
            $article_info['category_id'] = $category_id;
        }
        if ( $release_id ) {
            $this->page_data['trace'] .= '-- incoming release id<br/>';
            $release_info = $this->Release_model->get_release_info($release_id);
            $article_info['article_title'] = $release_info['display_artist'] . ' - '
                    . $release_info['display_title'];
            $article_info['category_id'] = 1;
            $artist_list = $this->Release_model->get_release_artists($release_id);
            $topic_list[$release_info['release_type_id']] = $release_info['release_type_id'];
        }
	$this->page_data['article_info'] = $article_info;
        $this->page_data['artist_list'] = $artist_list;
        $this->page_data['topic_list'] = $topic_list;
        $this->page_data['link_list'] = array();
	$this->page_data['release_id'] = $release_id;

        // display
	$this->page_data['trace'] .= $this->User_model->trace;
	$this->page_data['trace'] .= $this->Article_model->trace;
	$this->page_data['trace'] .= $this->Artist_model->trace;
	$this->page_data['trace'] .= $this->Release_model->trace;
	$this->page_data['trace'] .= 'credit list: ' 
		. print_r($this->page_data['credit_list'], TRUE);
        $this->page_data['show_columns'] = 2;
	$this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'])
                ->set_partial('edit_form', 'articles/edit_form')
		->append_metadata('<script>$(document).ready(function(){changeCategory();});</script>')
                ->build('articles/add_center', $this->page_data);
    }
    
    public function edit($article_id = 0)
    {
        // authorize
	if ( ! $this->page_data['can_contribute']) {
	    redirect('articles/index');
	}
        if ( $this->input->post('article-id') ) {
            $article_id = $this->input->post('article-id');
        }
        if ( $this->input->post('action') ) {
            // it's an insert
            $this->page_data['trace'] .= 'incoming post, id is ' . $article_id . '<br/>';
        }
        elseif ( $article_id == 0 ) {
            redirect('welcome');
        }
        
        // init
        $this->load->model('Artist_model');
        $this->load->model('Release_model');
        $this->load->model('Masterdata_model');
        $issue_date_list = $this->Masterdata_model->get_issue_date_list();
        $this->page_data['show_ads'] = FALSE;
        
        // deal with incoming post
        if ( $this->input->post('article-submit') ) {
            $this->page_data['trace'] .= 'process incoming post<br/>';
            $missing = array();
            $update_params = array(
                'article_id' => $article_id,
                'user_id' => $this->input->post('user-id'),
                'release_id' => $this->input->post('release-id'),
                'slug' => $this->input->post('slug'),
                'issue_no' => $this->input->post('issue_no'),
                'published_on' => $this->input->post('published_on')
             );
            if ($update_params['issue_no'])  {
                $update_params['published_on'] = $issue_date_list[$update_params['issue_no']];
            }
            if ($this->input->post('image_file'))  {
                $update_params['image_file'] = $this->input->post('image_file');
            }
            $ok = TRUE;
            if ( $this->input->post('title') ) {
                $update_params['title'] = $this->input->post('title');
            }
            else {
                $ok = FALSE;
                $missing[]= 'title';
            }
            if ( $this->input->post('category') ) {
                $update_params['category_id'] = $this->input->post('category');
            }
            else {
                $ok = FALSE;
                $missing[]= 'category';
            }
            if ( $this->input->post('article-body') ) {
                $update_params['body'] = $this->input->post('article-body');
                $update_params['body'] = stripslashes(html_entity_decode($update_params['body']));
                $update_params['body'] = str_replace('&nbsp;', ' ', $update_params['body']);
            }
            else {
                $ok = FALSE;
                $missing[]= 'body';
            }
            if ( $this->input->post('intro') ) {
                $update_params['intro'] = $this->input->post('intro');
            }
            else {
                $update_params['intro'] = '';
            }
            if ( $this->input->post('make-live') ) {
                $update_params['status'] = 'live';
                if ( ! $update_params['published_on'] ) {
                    $update_params['published_on'] = date('Y-m-d');
                }
            }
            else {
                $update_params['status'] = 'draft';
            }
            if ( $this->input->post('front-page') ) {
                $update_params['front_page'] = '1';
            }
            else {
                $update_params['front_page'] = '0';
            }
            if ($this->input->post('author')) {
                $this->page_data['trace'] .= 'process author list<br/>';
                $credits = array();
                $temp = $this->input->post('original-author');
                if ( ( $temp ) && (count($temp))) {
                    foreach ($temp as $item) {
                        $credits[$item] = array('action' => 'delete', 'role' => 1);
                    }
                }
                foreach ($this->input->post('author') as $item){
                    if (array_key_exists($item, $credits)){
                        $this->page_data['trace'] .= $item . ': item already in list<br/>';
                        unset($credits[$item]);
                    }
                    else {
                        $this->page_data['trace'] .= $item . ': added to list<br/>';
                        $credits[$item] = array('action' => 'insert', 'role' => 1);
                    }
                }
                $update_params['author'] = $credits;
            }
            else {
                $ok = FALSE;
                $missing[]= 'author';
            }
            if ($this->input->post('photographer')) {
                $this->page_data['trace'] .= 'process photographer list<br/>';
                $credits = array();
                $temp = $this->input->post('original-photographer');
                if ( ( $temp ) && (count($temp))) {
                    foreach ($temp as $item) {
                        $credits[$item] = array('action' => 'delete', 'role' => 2);
                    }
                }
                foreach ($this->input->post('photographer') as $item){
                    if (array_key_exists($item, $credits)){
                        $this->page_data['trace'] .= $item . ': item already in list<br/>';
                        unset($credits[$item]);
                    }
                    else {
                        $this->page_data['trace'] .= $item . ': added to list<br/>';
                        $credits[$item] = array('action' => 'insert', 'role' => 2);
                    }
                }
                $update_params['photographer'] = $credits;
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
                $missing[]= 'topic';
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
            if ( $this->input->post('links') ) {
                $update_params['links'] = explode(';', $this->input->post('links'));
            }
            if ( $ok ) {
                $this->page_data['trace'] .= 'ready to update<br/>';
                $update_result = $this->Article_model->update($update_params);
                if ( $update_result['status'] == 'ok' ) {
                    $article_slug = $update_result['slug'];
                    $article_id = $update_result['id'];
                    redirect('/articles/display/' . $article_slug);
                }
            }
            else {
                $this->page_data['trace'] .= 'something missing: ' 
                        . print_r($missing, TRUE) . '<br/>';
            }
        }
        
        // process
        // get article info
	$article_info = $this->Article_model->get_full('', $article_id);
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
	$this->page_data['article_release_list'] = $this->Article_model->get_releases($article_info['id']);
        $this->page_data['meta'] = $this->Article_model->get_meta($article_info['id']);
        $this->page_data['link_list'] = $this->Article_model->get_link_list($article_info['id']);
        
        // get lists for dropdowns
	$this->page_data['staff_list'] = $this->User_model->get_user_list(array(1, 3, 4));
	$this->page_data['category_list'] = $this->Article_model->get_category_list();
        $this->page_data['issue_list'] = $this->Masterdata_model->get_issue_list(TRUE);
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
	$this->page_data['release_id'] = 0;
        
        // display
        $this->page_data['trace'] .= 'topic list: ' . print_r($this->page_data['topic_list'],
                TRUE) . '<br/>';
        $this->page_data['trace'] .= 'artist list: ' . print_r($this->page_data['artist_list'],
                TRUE) . '<br/>';
        $this->page_data['trace'] .= $this->Article_model->trace;
        $this->page_data['show_columns'] = 2;
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'],
			$article_info['article_title'])
                ->build('articles/edit_form', $this->page_data);
    }
    
    public function getreleases($artists = '')
    {
        $result = '';
        if ( $artists != '' ) {
            $this->load->model('Artist_model');
            $artist_list = explode('|', $artists);
            $release_list = array();
            foreach ($artist_list as $item) {
                $temp = $this->Artist_model->get_release_list($item);
                foreach ($temp as $row) {
                    $result[$row['release_id']] = $row['display_artist']
                            . ' - ' . $row['display_title'] . ' ('
                            . $row['year_released'] . ')';
                }
            }
        }
        echo $result;
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
        $this->page_data['main_list'] = $this->Article_model->get_topic_articles($topic_slug, 
                5, $offset);
        
        $this->page_data['banner_ad'] = $this->Ad_model->serve('top');
        $this->page_data['side_ad'] = $this->Ad_model->serve('side');
        $this->page_data['topic_slug'] = $topic_slug;
        $this->page_data['category_slug'] = '';
        $this->page_data['offset'] = $offset;
        $this->page_data['trace'] .= $this->Article_model->trace;
        $this->page_data['trace'] .= print_r($this->page_data['main_list'], TRUE) . '<br/>';
        $this->page_data['show_columns'] = 3;
        $this->page_data['page_name'] = lang('article_topic_list') 
                . $this->page_data['main_list'][0]['topic_title'];
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'])
                ->build('articles/index_center', $this->page_data);
    }
    
    public function issue($issue_no = 0)
    {
        if ( $issue_no == 0 ) {
            redirect('');
        }
        $this->load->model('Masterdata_model');
        $this->page_data['page_name'] = lang('issue_no'). ' ' . $issue_no;
        $this->page_data['main_list'] = $this->Article_model->get_issue_articles($issue_no);
        $this->page_data['issue_info']= $this->Masterdata_model->get_issue_info($issue_no);
        
        $this->page_data['banner_ad'] = $this->Ad_model->serve('top');
        $this->page_data['side_ad'] = $this->Ad_model->serve('side');
        $this->page_data['topic_slug'] = '';
        $this->page_data['category_slug'] = '';
        $this->page_data['offset'] = 0;
        $this->page_data['trace'] .= $this->Masterdata_model->trace;
        $this->page_data['trace'] .= $this->Article_model->trace;
        $this->page_data['trace'] .= $this->Ad_model->trace;
        $this->page_data['trace'] .= print_r($this->page_data['main_list'], TRUE) . '<br/>';
        $this->page_data['show_columns'] = 3;
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'])
                ->build('articles/index_center', $this->page_data);
    }
    
    public function releases($year = 0)
    {
        if ( $year == 0 ) {
            redirect('');
        }
        $this->page_data['main_list'] = $this->Article_model->get_release_year_articles($year);
        $this->page_data['banner_ad'] = $this->Ad_model->serve('top');
        $this->page_data['side_ad'] = $this->Ad_model->serve('side');
        $this->page_data['trace'] .= $this->Article_model->trace;
        $this->page_data['trace'] .= print_r($this->page_data['main_list'], TRUE) . '<br/>';
        $this->page_data['topic_slug'] = '';
        $this->page_data['category_slug'] = '';
        $this->page_data['offset'] = 0;
        $this->page_data['show_columns'] = 3;
        $this->page_data['page_name'] = lang('article_release_year_list'). ' ' . $year;
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'])
                ->build('articles/index_center', $this->page_data);
    }
    
    public function drafts()
    {
        // authorize
	if ( ! $this->page_data['can_contribute']) {
	    redirect('articles/index');
	}
        
        // init
        $this->page_data['offset'] = 0;
        $this->page_data['category_slug'] = '';
        $this->page_data['topic_slug'] = '';
        
        // process
        $this->page_data['main_list'] = $this->Article_model->draft_list();
        $this->page_data['item_count'] = count($this->page_data['main_list']);
       
        // display
        $this->page_data['trace'] .= $this->Article_model->trace;
        $this->page_data['trace'] .= print_r($this->page_data['main_list'], TRUE) . '<br/>';
        $this->page_data['show_columns'] = 3;
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'], 'Index')
                ->build('articles/index_center', $this->page_data);
    }
    
    public function addrelease($article_id)
    {
        // authorize
	if ( ! $this->page_data['can_contribute']) {
	    redirect('articles/index');
	}
        $release_id = $this->input->post('release-id');
        $this->Article_model->add_release($article_id, $release_id);
        redirect('articles/index');
    }
    
    public function search()
    {
        // authorize
        if ( $this->input->post('search-value') ) {
            $search_value = $this->input->post('search-value');
        }
        else {
            redirect('');
        }
        
        // process
        $this->page_data['main_list'] = $this->Article_model->search($search_value);
       
        $this->page_data['banner_ad'] = $this->Ad_model->serve('top');
        $this->page_data['side_ad'] = $this->Ad_model->serve('side');
        $this->page_data['topic_slug'] = '';
        $this->page_data['category_slug'] = '';
        $this->page_data['offset'] = 0;
        $this->page_data['trace'] .= $this->Article_model->trace;
        $this->page_data['trace'] .= print_r($this->page_data['main_list'], TRUE) . '<br/>';
        $this->page_data['show_columns'] = 3;
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'])
                ->build('articles/index_center', $this->page_data);
    }
    
}
