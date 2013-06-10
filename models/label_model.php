<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Name:  Label Model
 * 
 * Author: Jon Davis
 * 
*/

class Label_model extends CI_Model
{
   
    public $trace = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
	$this->trace = '>> construct label model<br/>';
    }
   
    function get_list($add_select = FALSE)
    {
	$this->trace .= 'get_list()<br/>';
        $result = array();
        if ( $add_select ) {
            $result[0] = lang('dropdown_select');
        }
        $this->db->select('l.id, l.name, l.display, l.country_id, '
                    . '(select count(id) from releases r where r.label_id = l.id) as release_count')
                ->from('labels l')
                ->order_by('name');
        $query = $this->db->get();
        $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
	foreach ($query->result_array() as $row) {
            $result[$row['id']] = $row;
	}
        return $result;
    }
    
    function get_select_list($add_select = FALSE)
    {
	$this->trace .= 'get_list()<br/>';
        $result = array();
        if ( $add_select ) {
            $result[0] = lang('dropdown_select');
        }
        $this->db->select('l.id, l.name, l.display, l.country_id, '
                    . '(select count(id) from releases r where r.label_id = l.id) as release_count')
                ->from('labels l')
                ->order_by('name');
        $query = $this->db->get();
        $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
	foreach ($query->result_array() as $row) {
            $result[$row['id']] = $row['display'];
	}
        return $result;
    }
    
    function update_slugs()
    {
	$this->trace .= 'update_slugs()<br/>';
        $result = array();
        $this->db->select('l.id, l.name, l.country_id')
                ->from('labels l');
        $query = $this->db->get();
        $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
	foreach ($query->result() as $row) {
	    if ($row->name) {
                $new_slug = create_unique_slug($row->name . '-' 
                        . $row->country_id, 'labels');
                $this->db->where('id', $row->id);
                $this->db->update('labels', array('slug' => $new_slug));
                $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
		$result[$row->id] = $new_slug;
	    }
	}
        return $result;
    }
    
    function update($id = 0, $data = array())
    {
        $this->trace .= '>> update label<br/>';
        $result = array('status' => 'ok', 'id' => $id);
        if ( $id ) {
            $this->db->where('id', $id);
            $this->db->update('labels', $data);
        }
        else {
            $this->db->insert('labels', $data);
            $result['id'] = $this->db->insert_id();
        }
        $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
        return $result;
    }
    
    function get_full($id)
    {
        $this->trace .= 'get_full<br/>';
        $result = array(
            'id' => $id,
            'name' => '',
            'display' => '',
            'country_id' => '',
            'url' => '',
            'address' => '',
            'phone' => '',
            'email' => '',
            'info' => ''
        );
        $this->db->select('l.id, l.name, l.display, l.country_id, l.url, l.address, '
                    . 'l.phone, l.email, l.info')
                ->from('labels l')
                ->where('l.id', $id);
        $query = $this->db->get();
        $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
        $query_result = $query->row_array();
        if ( count($query_result) ) {
            $result = $query_result;
        }
        return $result;
    }
    
    function search($search_value, $max_count = 0, $starter = '')
    {
	$this->trace .= 'search<br/>';
        $result = array();
        $this->db->select('l.id, l.name, l.display, l.country_id, '
                    . '(select count(id) from releases r where r.label_id = l.id) as release_count')
                ->from('labels l')
                ->like('name', $search_value)
                ->order_by('name');
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
	foreach ($query->result_array() as $row) {
            $result[$row['id']] = $row;
	}
        return $result;
    }
    
}

/* End of file label_model.php */
/* Location: application/models/label_model.php */