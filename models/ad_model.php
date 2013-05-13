<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ad_model extends CI_Model
{
    public $trace = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
	$this->trace .= '>> construct ad model<br/>';
    }
    
    function update($id, $user_input)
    {
        $this->trace .= '>> update<br/>';
        $result = array('status' => 'ok');
        $ad_id = 0;
        $user_input['updated'] = date('Y-m-d H:i:s');
        if ( $id == 0 ) {
            $this->trace .= 'no id, insert<br/>';
            $this->db->insert('ads', $user_input);
            $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
            $id = $this->db->insert_id();
            $result['id'] = $id;
        }
        else {
	    $this->db->where('id', $id);
            $result['id'] = $id;
            $this->db->update('ads', $user_input);
            $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        }
        return $result;
    }
    
    function get_all($id = 0)
    {
        $this->trace .= '>> get_all<br/>';
        $result = array('status' => 'ok');
        $this->db->select('id, title, start_date, end_date, position, '
                    . 'status, image_file, alt, url, contact_email, '
                    . 'show_count, paid')
                ->from('ads');
        if ( $id ) {
            $this->db->where('id', $id);
        }
        else {
            $this->db->order_by('start_date', 'desc');
        }
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        if ( $id ) {
            $result = $query->row_array();
        }
        else {
            $result = $query->result_array();
        }
        return $result;
    }
    
    function serve($position)
    {
        $this->trace .= '>> serve<br/>';
        $result = array();
        $this->db->select('id, title, start_date, end_date, position, '
                    . 'status, image_file, alt, url, contact_email, '
                    . 'show_count')
                ->from('ads')
                ->where('position', $position)
                ->where('status', 'live')
                ->order_by('show_count', 'asc')
                ->limit(1);
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $result = $query->row_array();
        $this->db->where('id', $result['id']);
        $this->db->update('ads', array('show_count' => $result['show_count'] + 1));
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        return $result;
     }
   
}
