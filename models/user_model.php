<?php

class user_model extends CI_Model 
{
    // get user by their social media id
    function get_user_by_sm($data, $sm_id)
    {
	$this->db->select("u.*, up." . $sm_id);
	$this->db->from("users AS u");
	$this->db->join("user_profiles AS up", "u.id=up.user_id");
	$this->db->where($data);
	$query = $this->db->get();
	return $query->result();
    }

    // Returns user by its email
    function get_user_by_email($email)
    {
	$query = $this->db->query("SELECT * FROM users u, user_profiles up WHERE u.email='$email' and u.id = up.user_id");
	return $query->result();
    }

    function get_user_by_username($username)
    {
	$query = $this->db->query("SELECT * FROM users u, user_profiles up WHERE u.username='$username' and u.id = up.user_id");
	return $query->result();
    }

    // a generic update method for user profile
    function update_user_profile($user_id, $data)
    {
	$this->db->where('user_id', $user_id);
	$this->db->update('user_profiles', $data); 
    }

    // return the user given the id
    function get_user($user_id)
    {
	$query = $this->db->query("SELECT users.*, user_profiles.* FROM users, user_profiles WHERE " .
							    "users.id='$user_id' AND user_profiles.user_id='$user_id'");
	return $query->result();
    }

    // get user group
    function get_user_group($user_id)
    {
	$this->db->select('ug.group_id, g.name, g.description')
		->from('users_groups ug')
		->join('groups g', 'ug.group_id = g.id', 'left')
		->where('ug.user_id', $user_id);
	$query = $this->db->get();
	return $query->result_array();
    }
    
    //get list of users by group
    function get_user_list($include_groups)
    {
	$result = array();
	$this->db->select('ug.user_id, up.display_name')
		->from('users_groups ug')
		->join('user_profiles up', 'up.user_id = ug.user_id', 'left')
		->order_by('up.sort_name');
	if (is_array($include_groups)){
	    $this->db->where_in('ug.group_id', $include_groups);
	}
	$query = $this->db->get();
	foreach ($query->result() as $row) {
	    if ($row->display_name) {
		$result[$row->user_id] = $row->display_name;
	    }
	}
	return $result;
    }

}

/* End of file user_model.php */
/* Location: application/models/user_model.php */