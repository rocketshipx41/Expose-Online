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
   
}

/* End of file masterdata_model.php */
/* Location: application/models/masterdata_model.php */