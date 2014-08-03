<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Name:  Article Model
 * 
 * Author: Jon Davis
 * 
*/

class Article_model extends CI_Model
{
    public $trace = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
	$this->trace .= '>> construct article model<br/>';
    }
   
    function most_recent($category = '', $max = 5, $offset = 0, $include_carousel = TRUE)
    {
	$this->trace .= 'most_recent<br/>';
        $result = array();
        $this->db->select('a.id, a.slug, a.title, intro, a.category_id, '
                    . 'a.image_file, a.body, a.updated_on, a.published_on')
                ->from('articles a')
		->join('categories c', 'c.id = a.category_id', 'left')
                ->order_by('published_on', 'desc')
                ->order_by('updated_on', 'desc')
                ->where('status', 'live')
                ->where('a.published_on <= CURDATE()');
        if ($category != '') {
            $this->db->where('c.slug', $category);
        }
        if (($max != 0) || ($offset != 0)) {
            $this->db->limit($max, $offset);
        }
        if ( ! $include_carousel ) {
            $this->db->where('front_page', '0');
        }
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $result = $query->result_array();
        foreach ($result as &$item) {
            if ( ($item['category_id'] == 1) && ( ! $item['image_file']) ) {
                $this->trace .= 'no image assigned to review<br/>';
                $item['image_file'] = $this->get_main_image($item['id'], $item['category_id']);
                if ( ! $item['intro'] ) {
                    $item['intro'] = smart_trim($item['body'], 200);
                }
                unset($item['body']);
            }
            elseif ( $item['category_id'] == 7 ) {
                $item['intro'] = $item['body'];
            }
            elseif ( $item['category_id'] == 8 ) {
                //$item['intro'] = $item['body'];
            }
            $item['credits'] = $this->get_credits($item['id']);
        }
        return $result;
    }
    
    function get_artist_article_list($id = 0)
    {
	$this->trace .= 'get_article_list<br/>';
        $result = array();
        if ($id > 0) {
            $this->db->select('a.title, a.slug, a.category_id, c.item_name category, '
                        . 'a.published_on, a.image_file, a.id')
                    ->from('article_artist aa')
                    ->join('articles a', 'a.id = aa.article_id')
                    ->join('categories c', 'c.id = a.category_id')
                    ->where('aa.artist_id', $id)
                    ->where('status', 'live')
                    ->where('a.published_on <= CURDATE()')
                    ->order_by('a.published_on', 'desc');
            $query = $this->db->get();
            $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
            $result = $query->result_array();
            foreach ($result as &$item) {
                if ( ($item['category_id'] == 1) && ( ! $item['image_file']) ) {
                    $this->trace .= 'no image assigned to review<br/>';
                    $item['image_file'] = $this->get_main_image($item['id'], $item['category_id']);
                }
                elseif ( $item['category_id'] == 7 ) {
                    $item['intro'] = $item['body'];
                }
                elseif ( $item['category_id'] == 8 ) {
                    //$item['intro'] = $item['body'];
                }
                $item['credits'] = $this->get_credits($item['id']);
            }
        }
        return $result;
    }
    
    function get_count($category = '')
    {
        $this->trace .= 'get_count()<br/>';
        $this->db->select('count(*) acount')
                ->from('articles a')
		->join('categories c', 'c.id = a.category_id', 'left')
                ->where('status', 'live')
                ->where('a.published_on <= CURDATE()');
        if ($category != '') {
            $this->db->where('c.slug', $category);
        }
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $query_result = $query->row();
        $result = $query_result->acount;
        return $result;
    }
    
    function get_future_dated()
    {
 	$this->trace .= 'get_future_dated<br/>';
        $result = array();
        $this->db->select('a.id, a.slug, a.title, intro, a.category_id, '
                    . 'a.image_file, a.body, a.updated_on, a.published_on')
                ->from('articles a')
		->join('categories c', 'c.id = a.category_id', 'left')
                ->order_by('published_on', 'asc')
                ->where('status', 'live')
                ->where('a.published_on > CURDATE()');
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $result = $query->result_array();
        foreach ($result as &$item) {
            if ( ($item['category_id'] == 1) && ( ! $item['image_file']) ) {
                $this->trace .= 'no image assigned to review<br/>';
                $item['image_file'] = $this->get_main_image($item['id'], $item['category_id']);
                if ( ! $item['intro'] ) {
                    $item['intro'] = smart_trim($item['body'], 200);
                }
            }
            $item['credits'] = $this->get_credits($item['id']);
            unset($item['body']);
        }
        return $result;
    }
    
    function get_array_items($id_list = array())
    {
	$this->trace .= 'get_array_items<br/>';
        $result = array();
        $this->db->select('a.id, a.slug, a.title, intro, a.category_id, '
                    . 'a.image_file, a.body, a.updated_on, a.published_on')
                ->from('articles a')
		->join('categories c', 'c.id = a.category_id', 'left')
                ->where('status', 'live')
                ->where('a.published_on <= CURDATE()')
                ->where_in('a.id', $id_list);
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $query_result = $query->result_array();
        return $query_result;
    }
    
    function get_random_index($category, $last_issue = 0)
    {
	$this->trace .= 'get_random_index(' . $category . ')<br/>';
        $result = array();
        $this->db->select('a.id')
                ->from('articles a')
                ->where('status', 'live')
                ->where('a.published_on <= CURDATE()');
        if ( $category ) {
            $this->db->where('c.slug', $category)
                    ->join('categories c', 'c.id = a.category_id', 'left');
        }
        if ( $last_issue ) {
            $this->db->where('a.issue_no <=', $last_issue);
            $this->db->where('a.issue_no >', 0);
        }
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $query_result = $query->result_array();
        
        return $query_result;
    }
    
    function get_random($category, $max = 1, $date = 0)
    {
	$this->trace .= 'get_random<br/>';
        $result = array();
        $this->db->select('a.id, a.slug, a.title, intro, a.category_id, '
                    . 'a.image_file, a.body, a.updated_on, a.published_on')
                ->from('articles a')
		->join('categories c', 'c.id = a.category_id', 'left')
                ->limit($max * 5)
                ->where('status', 'live')
                ->where('a.published_on <= CURDATE()')
                ->where('a.id >= (SELECT FLOOR( MAX(id) * RAND()) FROM `articles` )');
        if ( $category ) {
            $this->db->where('c.slug', $category);
        }
        if ( $date ) {
            $this->db->where('a.issue_no <=', $date);
        }
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $query_result = $query->result_array();
        $random_items = array_rand($query_result, $max);
        if ( ENVIRONMENT == 'development' ) {
            $this->trace .= 'random items: ' . print_r($random_items, TRUE) . '<br/>';
        }
        if ( $max == 1 ) {
            $result[] = $query_result[$random_items];
        }
        else {
            foreach ( $random_items as $item ) {
                $result[] = $query_result[$item];
            }
        }
        //echo print_r($result); exit;
        return $result;
    }
    
    function get_issue_articles($issue_no)
    {
	$this->trace .= 'get_issue_articles<br/>';
        $result = array();
        $this->db->select('a.id, a.slug, a.title, intro, a.category_id, '
                    . 'a.image_file, a.body, a.updated_on, a.published_on')
                ->from('articles a')
		->join('categories c', 'c.id = a.category_id', 'left')
                ->order_by('updated_on', 'desc')
                ->where('status', 'live')
                ->where('a.published_on <= CURDATE()')
                ->where('issue_no', $issue_no);
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $result = $query->result_array();
        foreach ($result as &$item) {
            if ( ($item['category_id'] == 1) && ( ! $item['image_file']) ) {
                $this->trace .= 'no image assigned to review<br/>';
                $item['image_file'] = $this->get_main_image($item['id'], $item['category_id']);
                if ( ! $item['intro'] ) {
                    $item['intro'] = smart_trim($item['body'], 200);
                }
            }
            $item['credits'] = $this->get_credits($item['id']);
            unset($item['body']);
        }
        return $result;
    }
    
    function draft_list($user_id = 0)
    {
	$this->trace .= 'draft_list<br/>';
        $result = array();
        $this->db->select('a.id, a.slug, a.title, intro, a.category_id, '
                    . 'a.image_file, a.body, a.updated_on, a.updated_on published_on')
                ->from('articles a')
		->join('categories c', 'c.id = a.category_id', 'left')
                ->order_by('updated_on', 'asc')
                ->where('status', 'draft');
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $result = $query->result_array();
        foreach ($result as &$item) {
            if ( ($item['category_id'] == 1) && ( ! $item['image_file']) ) {
                $this->trace .= 'no image assigned to review<br/>';
                $item['image_file'] = $this->get_main_image($item['id'], $item['category_id']);
                if ( ! $item['intro'] ) {
                    $item['intro'] = smart_trim($item['body'], 200);
                }
            }
            $item['credits'] = $this->get_credits($item['id']);
            unset($item['body']);
        }
        return $result;
    }
    
    function my_draft_list($user_id = 0)
    {
	$this->trace .= 'draft_list<br/>';
        $result = array();
        $this->db->select('a.id, a.slug, a.title, intro, a.category_id, '
                    . 'a.image_file, a.body, a.updated_on, , a.updated_on published_on')
                ->from('article_user_role ar')
                -join('articles a', 'a.id = ar.article_id', 'left')
                ->order_by('a.updated_on', 'asc')
                ->where('ar.user_id', $user_id)
                ->where('ar.role_id', '1')
                ->where('a.status', 'draft');
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $result = $query->result_array();
        foreach ($result as &$item) {
            if ( ($item['category_id'] == 1) && ( ! $item['image_file']) ) {
                $this->trace .= 'no image assigned to review<br/>';
                $item['image_file'] = $this->get_main_image($item['id'], $item['category_id']);
                if ( ! $item['intro'] ) {
                    $item['intro'] = smart_trim($item['body'], 200);
                }
            }
            $item['credits'] = $this->get_credits($item['id']);
            unset($item['body']);
        }
        return $result;
    }
    
    function submission_list()
    {
	$this->trace .= 'submission_list<br/>';
        $result = array();
        $this->db->select('a.id, a.slug, a.title, intro, a.category_id, '
                    . 'a.image_file, a.body, a.updated_on, a.updated_on published_on')
                ->from('articles a')
		->join('categories c', 'c.id = a.category_id', 'left')
                ->order_by('updated_on', 'asc')
                ->where('status', 'submitted');
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $result = $query->result_array();
        foreach ($result as &$item) {
            if ( ($item['category_id'] == 1) && ( ! $item['image_file']) ) {
                $this->trace .= 'no image assigned to review<br/>';
                $item['image_file'] = $this->get_main_image($item['id'], $item['category_id']);
                if ( ! $item['intro'] ) {
                    $item['intro'] = smart_trim($item['body'], 200);
                }
            }
            $item['credits'] = $this->get_credits($item['id']);
            unset($item['body']);
        }
        return $result;
    }
    
    function get_front_page()
    {
	$this->trace .= 'get_front_page<br/>';
        $this->db->select('a.id, a.title, a.intro, a.slug, a.image_file')
                ->from('articles a')
                ->where('a.front_page', '1')
                ->where('status', 'live')
                ->where('a.published_on <= CURDATE()');
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $result = $query->result_array();
        // process?
        return $result;
    }
    
    function get_full($slug = '', $id = 0)
    {
	$this->trace .= 'get_full<br/>';
        $this->db->select('a.id, a.title article_title, a.intro, a.body, a.status, '
		    . 'a.category_id, a.slug, c.item_name, c.title category_name, '
                    . 'a.issue_no, c.slug category_slug, a.image_file, a.published_on, '
                    . 'a.front_page')
                ->from('articles a')
		->join('categories c', 'c.id = a.category_id', 'left');
        if ( $slug != '' ) {
            $this->db->where('a.slug', $slug);
        }
        else {
            $this->db->where('a.id', $id);
        }
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
	//echo $this->query_trace; exit;
        return $query->row_array();
    }
    
    function get_dummy()
    {
	$this->trace .= 'get_dummy<br/>';
	return array('id'=> 0, 'article_title' => '', 'intro'=> '', 'body' => '',
		'category_id' => 0, 'item_name' => '', 'category_name' => '',
		'slug' => '', 'issue_no' => 0, 'status' => 'draft', 'front_page' => 0,
                'published_on'  => '', 'image_file' => ''
	    );
    }
    
    function get_credits($id)
    {
	$this->trace .= 'get_credits<br/>';
	$result = array('1' => array(), '2' => array());
	$this->db->select('aur.user_id, aur.role_id, u.username, up.display_name')
		->from('article_user_role aur')
		->join('users u', 'u.id = aur.user_id', 'left')
		->join('user_profiles up', 'up.user_id = aur.user_id', 'left')
		->where('aur.article_id', $id);
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
	foreach ($query->result() as $row) {
	    $result[$row->role_id][$row->user_id] = $row->display_name;
	}
        return $result;
    }
    
    function get_meta($id)
    {
	$this->trace .= 'get_meta<br/>';
	$result = array(
	    'has_author' => FALSE,
	    'has_photographer' => FALSE,
	    'has_illustrator' => FALSE
	);
	$this->db->select('aur.role_id')
		->from('article_user_role aur')
		->where('aur.article_id', $id);
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
	foreach ($query->result() as $row) {
	    if ($row->role_id == 1) {
		$result['has_author'] = TRUE;
	    }
	    elseif ($row->role_id == 2) {
		$result['has_photographer'] = TRUE;
	    }
	    elseif ($row->role_id == 3) {
		$result['has_illustrator'] = TRUE;
	    }
	}
	return $result;
    }
    
    function get_artists($id)
    {
	$this->trace .= 'get_artists<br/>';
        $result = array();
	$this->db->select('aa.artist_id, a.display, a.slug')
		->from('article_artist aa')
		->join('artists a', 'a.id = aa.artist_id', 'left')
		->where('aa.article_id', $id);
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
	foreach ($query->result() as $row) {
	    if ($row->display) {
		$result[$row->artist_id] = array(
                    'display' => $row->display,
                    'slug' => $row->slug
                );
	    }
	}
        return $result;
    }
    
    function get_topics($id)
    {
	$this->trace .= 'get_topics<br/>';
	$this->db->select('at.topic_id, t.title, t.slug topic_slug')
                ->distinct()
		->from('article_topic at')
		->join('topics t', 't.id = at.topic_id', 'left')
		->where('at.article_id', $id);
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        return $query->result_array();
    }
    
    function get_topic_list()
    {
	$this->trace .= 'get_topic_list<br/>';
	$result = array();
	$this->db->select('id, slug, title')
		->from('topics')
		->order_by('title');
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
	foreach ($query->result() as $row) {
	    if ($row->title) {
		$result[$row->id] = array(
                    'title' => $row->title,
                    'slug' => $row->slug
                );
	    }
	}
	return $result;
    }
    
    function get_category_list()
    {
	$this->trace .= 'get_category_list<br/>';
	$result = array();
	$this->db->select('id, title')
		->from('categories')
		->order_by('title');
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
	foreach ($query->result() as $row) {
	    if ($row->title) {
		$result[$row->id] = $row->title;
	    }
	}
	return $result;
    }
    
    function get_link_list($article_id)
    {
	$this->trace .= 'get_link_list<br/>';
	$result = array();
	$this->db->select('article_link_id, link')
		->from('article_links')
		->where('article_id', $article_id);
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
	foreach ($query->result() as $row) {
	    if ($row->link) {
		$result[$row->article_link_id] = $row->link;
	    }
	}
	return $result;
    }
    
    function get_main_image($article_id, $category_id)
    {
	$this->trace .= 'get_main_image<br/>';
        $result = '';
        if ($category_id == 1) { // review
            $this->db->select('r.image_file')
                    ->from('article_release ar')
                    ->join('releases r', 'r.id = ar.release_id', 'left')
                    ->where('ar.article_id', $article_id)
                    ->limit(1);
            $query = $this->db->get();
            $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
            $query_result = $query->result_array();
            if (count($query_result)) {
                $result = 'releases/' . $query_result[0]['image_file'];
            }
        }
        return $result;
    }
    
    function get_releases($article_id)
    {
	$this->trace .= 'get_releases<br/>';
        $result = array();
	$this->db->select('ar.release_id, r.display_title, r.display_artist, '
                    .'r.media, r.media_count, r.year_released, r.image_file, '
                    . 'r.catalog_no, r.year_recorded, r.label_id, l.display label_name')
		->from('article_release ar')
		->join('releases r', 'r.id = ar.release_id', 'left')
                ->join('labels l', 'l.id = r.label_id', 'left')
		->where('ar.article_id', $article_id);
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $query_result = $query->result_array();
        if ( count($query_result)) {
            $result = $query_result;
        }
        return $result;
    }
    
    function update($user_input, $reset_slug = FALSE)
    {
	$this->trace .= 'update<br/>';
        $result = array('status' => 'ok');
	$this->db->trans_start();
        $article_id = 0;
	// basic info
	$data = array(
	    'title' => $user_input['title'],
	    'category_id' => $user_input['category_id'],
	    'intro' => $user_input['intro'],
	    'body' => $user_input['body'],
            'status' => $user_input['status'],
            'issue_no' => $user_input['issue_no'],
	    'user_id' => $user_input['user_id'],
            'front_page' => $user_input['front_page'],
            'updated_on' => date('Y-m-d H:i:s')
	);
        if ( $user_input['published_on'] ) {
            $data['published_on'] = $user_input['published_on'];
        }
        if ( ( array_key_exists('image_file', $user_input) ) && ( $user_input['image_file'] ) ) {
            $data['image_file'] = $user_input['image_file'];
        }
	if ($user_input['article_id'] == 0) {
            $this->trace .= 'new article, insert' . "<br/>\n";
            $slug_src = $user_input['title'];
            if (count($user_input['author'])) {
                foreach ($user_input['author'] as $user => $item){
                    $slug_src .= '-' . $user;
                }
            }
            $data['slug'] = create_unique_slug($slug_src, 'articles');
            $result['slug'] = $data['slug'];
	    $this->db->insert('articles', $data);
            $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
            $article_id = $this->db->insert_id();
            $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
            $this->trace .= 'new id is: ' . $article_id . "<br/>\n";
            $result['id'] = $article_id;
	}
	else {
            if ( $reset_slug ) {
                $slug_src = $user_input['title'];
                if (count($user_input['author'])) {
                    foreach ($user_input['author'] as $user => $item){
                        $slug_src .= '-' . $user;
                    }
                }
                $data['slug'] = create_unique_slug($slug_src, 'articles');
                $result['slug'] = $data['slug'];
            }
            else {
                $result['slug'] = $user_input['slug'];
            }
            $article_id = $user_input['article_id'];
            $result['id'] = $article_id;
	    $this->db->where('id', $user_input['article_id']);
            $this->db->update('articles', $data);
            $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
//            echo $this->trace; exit;
	}
        // credits
        if (count($user_input['author'])) {
            foreach ($user_input['author'] as $user => $item){
                if ($item['action'] == 'insert') {
                    $data = array(
                        'article_id' => $article_id,
                        'user_id' => $user,
                        'role_id' => $item['role']
                    );
                    $this->db->insert('article_user_role', $data);
                    $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
                    $this->trace .= 'add new author ' . "<br/>\n";
                }
                elseif ($item['action'] == 'delete') {
                    $this->db->where('article_id', $article_id)
                            ->where('user_id', $user)
                            ->where('role_id', $item['role']);
                    $this->db->delete('article_user_role');
                    $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
                    $this->trace .= 'delete author ' . "<br/>\n";
                }
            }
        }
        else {
            $this->trace .= 'no changes in author list ' . "<br/>\n";
        }
        if (count($user_input['photographer'])) {
            foreach ($user_input['photographer'] as $user => $item){
                if ($item['action'] == 'insert') {
                    $data = array(
                        'article_id' => $article_id,
                        'user_id' => $user,
                        'role_id' => $item['role']
                    );
                    $this->db->insert('article_user_role', $data);
                    $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
                    $this->trace .= 'add new photographer ' . "<br/>\n";
                }
                elseif ($item['action'] == 'delete') {
                    $this->db->where('article_id', $article_id)
                            ->where('user_id', $user)
                            ->where('role_id', $item['role']);
                    $this->db->delete('article_user_role');
                    $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
                    $this->trace .= 'delete photographer ' . "<br/>\n";
                }
            }
        }
        else {
            $this->trace .= 'no changes in photographer list ' . "<br/>\n";
        }
        // artists
        if (count($user_input['artist'])) {
            foreach ($user_input['artist'] as $id => $action){
                if ($action == 'insert') {
                    $data = array(
                        'article_id' => $article_id,
                        'artist_id' => $id
                    );
                    $this->db->insert('article_artist', $data);
                    $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
                    $this->trace .= 'add new artist ' . "<br/>\n";
                }
                elseif ($action == 'delete') {
                    $this->db->where('article_id', $article_id)
                            ->where('artist_id', $id);
                    $this->db->delete('article_artist');
                    $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
                    $this->trace .= 'delete artist ' . "<br/>\n";
                }
            }
        }
        else {
            $this->trace .= 'no changes in artist list ' . "<br/>\n";
        }
        // topics
        if (count($user_input['topic'])) {
            foreach ($user_input['topic'] as $id => $action){
                if ($action == 'insert') {
                    $data = array(
                        'article_id' => $article_id,
                        'topic_id' => $id
                    );
                    $this->db->insert('article_topic', $data);
                    $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
                    $this->trace .= 'add new topic ' . "<br/>\n";
                }
                elseif ($action == 'delete') {
                    $this->db->where('article_id', $article_id)
                            ->where('topic_id', $id);
                    $this->db->delete('article_topic');
                    $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
                    $this->trace .= 'delete topic ' . "<br/>\n";
                }
            }
        }
        else {
            $this->trace .= 'no changes in topics list ' . "<br/>\n";
        }
        // links
        if (count($user_input['links'])) {
            $this->db->where('article_id', $article_id);
            $this->db->delete('article_links');
            $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
            $this->trace .= 'delete links ' . "<br/>\n";
            foreach ($user_input['links'] as $url){
                $data = array(
                    'article_id' => $article_id,
                    'link' => $url
                );
                $this->db->insert('article_links', $data);
                $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
                $this->trace .= 'add new link ' . "<br/>\n";
            }
        }
        else {
            $this->trace .= 'no changes in links list ' . "<br/>\n";
        }
        // releases
        if ( $user_input['release_id'] ) {
            // need to make array?
            $data = array(
                'article_id' => $article_id,
                'release_id' => $user_input['release_id']
            );
            $this->db->insert('article_release', $data);
        }
        else {
            $this->trace .= 'no release id ' . "<br/>\n";
        }
	$this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            // generate an error... or use the log_message() function to log your error
            $result['status'] = 'error';
        } 
        return $result;
    }
    
    public function get_topic_articles($topic_slug, $max = 5, $offset = 0)
    {
	$this->trace .= 'get_topic_articles<br/>';
        $result = array();
        $this->db->select('a.id, a.slug, a.title, a.intro, a.category_id, '
                    . 'a.image_file, a.body, a.updated_on, a.published_on, '
                    . 't.title topic_title')
                ->from('article_topic at')
                ->join('articles a', 'a.id = at.article_id', 'left')
                ->join('topics t', 't.id = at.topic_id', 'left')
                ->where('a.status', 'live')
                ->where('t.slug', $topic_slug)
                ->where('a.published_on <= CURDATE()')
                ->order_by('updated_on', 'desc');
        if (($max != 0) || ($offset != 0)) {
            $this->db->limit($max, $offset);
        }
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $result = $query->result_array();
        foreach ($result as &$item) {
            if ( ($item['category_id'] == 1) && ( ! $item['image_file']) ) {
                $this->trace .= 'no image assigned to review<br/>';
                $item['image_file'] = $this->get_main_image($item['id'], $item['category_id']);
                if ( ! $item['intro'] ) {
                    $item['intro'] = smart_trim($item['body'], 200);
                }
            }
            $item['credits'] = $this->get_credits($item['id']);
            unset($item['body']);
        }
        return $result;
    }
    
    function get_release_year_articles($year)
    {
	$this->trace .= 'get_release_year_articles<br/>';
        $result = array();
        $this->db->select('ar.article_id, ar.release_id, a.slug, a.title, a.intro, a.category_id, '
                    . 'a.image_file, a.body, a.updated_on, a.published_on')
                ->from('article_release ar')
                ->join('articles a', 'a.id = ar.article_id', 'left')
                ->join('releases r', 'r.id = ar.release_id', 'left')
                ->where('a.status', 'live')
                ->where('a.published_on <= CURDATE()')
                ->where("(r.year_recorded = '" . $year . "' or r.year_released = '" .  $year . "')")
                ->order_by('updated_on', 'desc');
/*        if (($max != 0) || ($offset != 0)) {
            $this->db->limit($max, $offset);
        }*/
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $result = $query->result_array();
        foreach ($result as &$item) {
            if ( ($item['category_id'] == 1) && ( ! $item['image_file']) ) {
                $this->trace .= 'no image assigned to review<br/>';
                $item['image_file'] = $this->get_main_image($item['article_id'], $item['category_id']);
                if ( ! $item['intro'] ) {
                    $item['intro'] = smart_trim($item['body'], 200);
                }
            }
            $item['credits'] = $this->get_credits($item['article_id']);
            unset($item['body']);
        }
        return $result;
    }
    
    function get_release_reviews($release_id)
    {
	$this->trace .= 'get_release_reviews<br/>';
        $result = array();
        $this->db->select('ar.article_id')
                ->from('article_release ar')
                ->where('a.status', 'live')
                ->where('a.published_on <= CURDATE()')
                ->where('a.category_id', 1)
                ->where('ar.release_id', $release_id)
                ->order_by('updated_on', 'desc');
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $result = $query->result_array();
        foreach ($result as &$item) {
            
        }
        
    }
    
    function add_release($article_id, $release_list)
    {
        $this->trace .= 'add_release<br/>';
        if ( $article_id && count($release_list) ) {
            $this->db->trans_start();
            foreach ($release_list as $item) {
                if ( $item > 0 ) { // positive - insert
                    $data = array(
                        'article_id' => $article_id,
                        'release_id' => $item
                    );
                    $this->db->insert('article_release', $data);
                }
                else { // negative - delete
                    $this->db->where('article_id', $article_id)
                            ->where('release_id', substr($item, 1));
                    $this->db->delete('article_release');
                }
            }
            $this->db->trans_complete();
        }
    }
    
    function search($search_value)
    {
	$this->trace .= 'search<br/>';
        $result = array();
        $this->db->select('a.id, a.slug, a.title, intro, a.category_id, '
                    . 'a.image_file, a.body, a.updated_on, a.published_on')
                ->from('articles a')
		->join('categories c', 'c.id = a.category_id', 'left')
                ->order_by('updated_on', 'desc')
                ->where('status', 'live')
                ->where('a.published_on <= CURDATE()')
                ->like('a.title', $search_value);
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $result = $query->result_array();
        foreach ($result as &$item) {
            if ( ($item['category_id'] == 1) && ( ! $item['image_file']) ) {
                $this->trace .= 'no image assigned to review<br/>';
                $item['image_file'] = $this->get_main_image($item['id'], $item['category_id']);
                if ( ! $item['intro'] ) {
                    $item['intro'] = smart_trim($item['body'], 200);
                }
            }
            $item['credits'] = $this->get_credits($item['id']);
            unset($item['body']);
        }
        return $result;
    }
    
}

/* End of file article_model.php */
/* Location: application/models/article_model.php */