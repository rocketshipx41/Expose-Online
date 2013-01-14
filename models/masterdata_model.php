<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Name:  Artist Model
 * 
 * Author: Jon Davis
 * 
*/

class Masterdata_model extends CI_Model
{
    public $trace = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
	$this->trace = '>> construct masterdata model<br/>';
    }
    
    public function get_country_list($add_select = FALSE)
    {
	$this->trace .= 'get_country_list<br/>';
        $result = array();
        if ( $add_select ) {
            $result['0'] = lang('dropdown_select');
        }
        $this->db->select('id, name')
                ->from('countries')
                ->order_by('name');
        $query = $this->db->get();
        $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
	foreach ($query->result() as $row) {
            $result[$row->id] = $row->name;
	}
        return $result;
    }
    
    public function get_release_type_list($add_select = FALSE)
    {
	$this->trace .= 'get_country_list<br/>';
        $result = array();
        if ( $add_select ) {
            $result['0'] = lang('dropdown_select');
        }
        $result[1] = 'New release';
        $result[2] = 'Archive';
        $result[3] = 'Reissue';
        $result[10] = 'Not new but worthy';
        return $result;
    }
    
    public function get_issue_list($add_select = FALSE)
    {
	$this->trace .= 'get_issue_list<br/>';
        $result = array();
        if ( $add_select ) {
            $result['0'] = lang('dropdown_select');
        }
        $this->db->select('id, description')
                ->from('issues')
                ->order_by('id');
        $query = $this->db->get();
        $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
	foreach ($query->result() as $row) {
            $result[$row->id] = $row->id. ' ('. $row->description . ')';
	}
        return $result;
    }
   
    public function get_issue_date_list()
    {
	$this->trace .= 'get_issue_date_list<br/>';
        $result = array();
        $this->db->select('id, pub_date')
                ->from('issues')
                ->order_by('id');
        $query = $this->db->get();
        $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
	foreach ($query->result() as $row) {
            $result[$row->id] = $row->pub_date;
	}
        return $result;
    }
   
    public function get_issue_info($id)
    {
	$this->trace .= 'get_issue_list<br/>';
        $result = array();
        $this->db->select('id, description, blurb, pages')
                ->from('issues')
                ->where('id', $id);
        $query = $this->db->get();
        $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
        $result = $query->row_array();
        return $result;
    }
   
}

/* End of file masterdata_model.php */
/* Location: application/models/masterdata_model.php */