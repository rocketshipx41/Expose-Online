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
   
    function most_recent($category = '', $max = 5)
    {
        $this->db->select('a.id, a.slug, a.title, intro')
                ->from('articles a')
		->join('categories c', 'c.id = a.category_id')
                ->order_by('updated_on', 'desc')
                ->where('status', 'live');
        if ($category != '') {
            $this->db->where('c.slug', $category);
        }
        if ($max != 0) {
            $this->db->limit($max);
        }
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        return $query->result_array();
    }
    
    function get_full($slug)
    {
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
	return array('id'=> 0, 'article_title' => '', 'intro'=> '', 'body' => '',
		'category_id' => 0, 'item_name' => '', 'category_name' => '',
		'slug' => ''
	    );
    }
    
    function get_credits($id)
    {
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
    
    function get_topics($id)
    {
	$this->db->select('at.topic_id, t.title')
		->from('article_topic at')
		->join('topics t', 't.id = at.topic_id', 'left')
		->where('at.article_id', $id);
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        return $query->result_array();
    }
    
    function get_category_list()
    {
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
    
    function update($user_input)
    {
	$this->db->trans_start();
	// basic info
	$data = array(
	    'title' => $user_input['title'],
	    'category_id' => $user_input['category'],
	    'intro' => $user_input['intro'],
	    'body' => $user_input['body'],
	    'user_id' => $user_input['user_id']
	);
	if ($user_input['article_id'] == 0) {
	    $this->db->insert('articles', $data);
	}
	else {
	    $this->db->where('id', $user_input['article_id']);
	    $this->db->update('articles', $data);
	}
	// credits
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
	$this->db->trans_complete();
    }
}

/* End of file article_model.php */
/* Location: application/models/article_model.php */