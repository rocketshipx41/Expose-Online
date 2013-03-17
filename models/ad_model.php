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
    
    function update($user_input)
    {
        $this->trace .= '>> update<br/>';
        $result = array('status' => 'ok');
        $ad_id = 0;
        $user_input['updated'] = date('Y-m-d H:i:s');
        if ( $user_input['id'] == 0 ) {
            $this->trace .= 'no id, insert<br/>';
            $this->db->insert('ads', $user_input);
            $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
            $ad_id = $this->db->insert_id();
            $result['id'] = $ad_id;
        }
        else {
	    $this->db->where('id', $user_input['id']);
            $ad_id = $user_input['id'];
            $result['id'] = $ad_id;
            $this->db->update('ads', $data);
            $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        }
        return $result;
    }
    
    function get_all()
    {
        $this->trace .= '>> get_all<br/>';
        $result = array('status' => 'ok');
        $this->db->select('id, title, start_date, end_date, position')
                ->from('ads')
                ->order_by('start_date', 'desc');
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $result = $query->result_array();
        return $result;
    }
   
}
