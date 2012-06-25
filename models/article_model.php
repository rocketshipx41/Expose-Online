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
	$this->trace = '>> construct article model<br/>';
    }
   
    function most_recent($category = '', $max = 5, $offset = 0)
    {
	$this->trace = 'most_recent<br/>';
        $result = array();
        $this->db->select('a.id, a.slug, a.title, intro, a.category_id, a.image_file')
                ->from('articles a')
		->join('categories c', 'c.id = a.category_id', 'left')
                ->order_by('updated_on', 'desc')
                ->where('status', 'live');
        if ($category != '') {
            $this->db->where('c.slug', $category);
        }
        if (($max != 0) || ($offset != 0)) {
            $this->db->limit($max, $offset);
        }
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $result = $query->result_array();
        foreach ($result as &$item) {
            if ($item['category_id'] == 1) {
                $item['image_file'] = $this->get_main_image($item['id'], $item['category_id']);
            }
        }
        return $result;
    }
    
    function get_front_page()
    {
	$this->trace = 'get_front_page<br/>';
        $this->db->select('a.id, a.title, a.intro, a.slug, a.image_file')
                ->from('articles a')
                ->where('a.front_page', '1')
                ->where('status', 'live');
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $result = $query->result_array();
        // process?
        return $result;
    }
    
    function get_full($slug)
    {
	$this->trace = 'get_full<br/>';
        $this->db->select('a.id, a.title article_title, a.intro, a.body, a.category_id, '
		    . ' a.slug, c.item_name, c.title category_name')
                ->from('articles a')
		->join('categories c', 'c.id = a.category_id', 'left')
                ->where('a.slug', $slug)
                ->where('status', 'live');
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
	//echo $this->query_trace; exit;
        return $query->row_array();
    }
    
    function get_dummy()
    {
	$this->trace = 'get_dummy<br/>';
	return array('id'=> 0, 'article_title' => '', 'intro'=> '', 'body' => '',
		'category_id' => 0, 'item_name' => '', 'category_name' => '',
		'slug' => ''
	    );
    }
    
    function get_credits($id)
    {
	$this->trace = 'get_credits<br/>';
	$result = array();
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
	$this->trace = 'get_meta<br/>';
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
	$this->trace = 'get_artists<br/>';
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
	$this->trace = 'get_topics<br/>';
	$this->db->select('at.topic_id, t.title')
		->from('article_topic at')
		->join('topics t', 't.id = at.topic_id', 'left')
		->where('at.article_id', $id);
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        return $query->result_array();
    }
    
    function get_topic_list()
    {
	$this->trace = 'get_topic_list<br/>';
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
	$this->trace = 'get_category_list<br/>';
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
    
    function get_main_image($article_id, $category_id)
    {
	$this->trace = 'get_main_image<br/>';
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
                $result = $query_result[0]['image_file'];
            }
        }
        return $result;
    }
    
    function get_releases($article_id)
    {
	$this->trace = 'get_releases<br/>';
	$this->db->select('ar.release_id, r.display_title, r.display_artist, '
                    .'r.media, r.media_count, r.year_released, r.image_file, '
                    . 'r.catalog_no, r.year_recorded, r.label_id, l.display label_name')
		->from('article_release ar')
		->join('releases r', 'r.id = ar.release_id', 'left')
                ->join('labels l', 'l.id = r.label_id', 'left')
		->where('ar.article_id', $article_id);
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        return $query->result_array();
    }
    
    function update($user_input)
    {
	$this->trace = 'update<br/>';
	$this->db->trans_start();
        $article_id = 0;
	// basic info
	$data = array(
	    'title' => $user_input['title'],
	    'category_id' => $user_input['category'],
	    'intro' => $user_input['intro'],
	    'body' => $user_input['body'],
	    'user_id' => $user_input['user_id'],
            'updated_on' => date('Y-m-d H:i:s')
	);
	if ($user_input['article_id'] == 0) {
            $this->trace .= 'new article, insert' . "<br/>\n";
            $data['slug'] = create_unique_slug($user_input['title'], 'articles');
	    $this->db->insert('articles', $data);
            $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
            $article_id = $this->db->insert_id();
            $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
            $this->trace .= 'new id is: ' . $article_id . "<br/>\n";
	}
	else {
	    $this->db->where('id', $user_input['article_id']);
            $article_id = $user_input['article_id'];
            $this->db->update('articles', $data);
            $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
	}
        // credits
        if (count($user_input['author'])) {
            foreach ($user_input['author'] as $user => $item){
                if ($item['action'] == 'insert') {
                    $data = array(
                        'article_id' => $article_id,
                        'user_id' => $user,
                        'role_id' => 1
                    );
                    $this->db->insert('article_user_role', $data);
                    $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
                    $this->trace .= 'add new author ' . "<br/>\n";
                }
                elseif ($item['action'] == 'delete') {
                    $this->db->where('article_id', $article_id)
                            ->where('user_id', $user)
                            ->where('role_id', '1');
                    $this->db->delete('article_user_role');
                    $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
                    $this->trace .= 'delete author ' . "<br/>\n";
                }
            }
        }
        else {
            $this->trace .= 'no changes in author list ' . "<br/>\n";
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
	$this->db->trans_complete();
    }
}

/* End of file article_model.php */
/* Location: application/models/article_model.php */