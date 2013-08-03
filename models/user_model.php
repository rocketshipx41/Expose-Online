<?php

class User_model extends CI_Model 
{
    public $trace = '';
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
	$this->trace = '>> construct article model<br/>';
    }
   
    // get user by their social media id
    function get_user_by_sm($data, $sm_id)
    {
	$this->trace = 'get_user_by_sm<br/>';
	$this->db->select("u.*, up." . $sm_id);
	$this->db->from("users AS u");
	$this->db->join("user_profiles AS up", "u.id=up.user_id");
	$this->db->where($data);
	$query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
	return $query->result();
    }

    // Returns user by its email
    function get_user_by_email($email)
    {
	$this->trace = 'get_user_by_email<br/>';
	$query = $this->db->query("SELECT * FROM users u, user_profiles up WHERE u.email='$email' and u.id = up.user_id");
	$this->db->select("u.*, up.*");
	$this->db->from("users AS u");
	$this->db->join("user_profiles AS up", "u.id=up.user_id");
	$this->db->where('u.email', $email);
	$query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
	return $query->row();
    }

    function get_user_by_username($username)
    {
	$this->trace = 'get_user_by_username<br/>';
	$query = $this->db->query("SELECT * FROM users u, user_profiles up WHERE u.username='$username' and u.id = up.user_id");
	$this->db->select("u.*, up.*");
	$this->db->from("users AS u");
	$this->db->join("user_profiles AS up", "u.id=up.user_id");
	$this->db->where('u.username', $username);
	$query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
	return $query->row();
    }
    
    function get_user_info($user)
    {
	$this->trace = 'get_user_info<br/>';
        $this->db->select('u.username, u.email, u.activated, u.banned, u.last_ip, '
                    . 'u.last_login, u.id, up.display_name')
                ->from("users AS u")
                ->join("user_profiles AS up", "u.id = up.user_id")
                ->where('u.id', $user);
	$query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
	return $query->row_array();
    }

    // a generic update method for user profile
    function update_user_profile($user_id, $data)
    {
	$this->trace = 'update_user_profile<br/>';
	$this->db->where('user_id', $user_id);
	$this->db->update('user_profiles', $data); 
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
    }

    // a generic update method for user profile
    function update_user_group($user_id, $old_group_id, $new_group_id)
    {
	$this->trace = 'update_user_group<br/>';
        if ( $old_group_id == 0 ) {
            $this->db->insert('users_groups', array(
                'group_id' => $new_group_id,
                'user_id' => $user_id)
            );
        }
        else {
            $this->db->where('user_id', $user_id);
            $this->db->update('users_groups', array('group_id' => $new_group_id)); 
        }
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
    }

    // return the user given the id
    function get_user($user_id)
    {
	$this->trace = 'get_user<br/>';
	$query = $this->db->query("SELECT users.*, user_profiles.* FROM users, user_profiles WHERE " .
							    "users.id='$user_id' AND user_profiles.user_id='$user_id'");
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
	return $query->result();
    }

    // get user group
    function get_user_group($user_id)
    {
	$this->trace = 'get_user_group<br/>';
	$this->db->select('ug.group_id, g.name, g.description')
		->from('users_groups ug')
		->join('groups g', 'ug.group_id = g.id', 'left')
		->where('ug.user_id', $user_id);
	$query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
	return $query->result_array();
    }
    
    //get list of users by group
    function get_user_list($include_groups)
    {
	$this->trace = 'get_user_list<br/>';
	$result = array();
	$this->db->select('ug.user_id, up.display_name')
		->from('users_groups ug')
		->join('user_profiles up', 'up.user_id = ug.user_id', 'left')
		->order_by('up.sort_name');
	if (is_array($include_groups)){
	    $this->db->where_in('ug.group_id', $include_groups);
	}
	$query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
	foreach ($query->result() as $row) {
	    if ($row->display_name) {
		$result[$row->user_id] = $row->display_name;
	    }
	}
	return $result;
    }
    
    function author_article_list($id = 0)
    {
	$this->trace .= 'author_article_list<br/>';
        $result = array();
        if ($id > 0) {
            $this->db->select('a.title, a.slug, a.category_id, c.item_name category')
                    ->from('article_user_role aa')
                    ->join('articles a', 'a.id = aa.article_id')
                    ->join('categories c', 'c.id = a.category_id')
                    ->where('aa.user_id', $id)
                    ->where('status', 'live')
                    ->order_by('published_on', 'desc');
            $query = $this->db->get();
            $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
            $result = $query->result_array();
        }
        return $result;
    }
    
}

/* End of file user_model.php */
/* Location: application/models/user_model.php */