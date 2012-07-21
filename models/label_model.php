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
        $this->db->select('l.id, l.name, l.display, l.country_id')
                ->from('labels l')
                ->order_by('name');
        $query = $this->db->get();
        $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
	foreach ($query->result() as $row) {
	    if ($row->display) {
                $display_line = $row->display;
                if ( $row->country_id ) {
                    $display_line.= ' (' . $row->country_id . ')';
                }
		$result[$row->id] = $display_line;
	    }
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
}

/* End of file label_model.php */
/* Location: application/models/label_model.php */