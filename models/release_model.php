<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Name:  Release Model
 * 
 * Author: Jon Davis
 * 
*/

class Release_model extends CI_Model
{
    
    public $trace = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
	$this->trace = '>> construct release model<br/>';
    }
   
    function get_release_info($release_id = 0)
    {
	$this->trace .= 'get_release_info(' . $release_id . ')<br/>';
        $result = array(
            'id' => 0,
            'label_id' => 0,
            'label_name' => '',
            'label_display' => '',
            'release_type_id' => 0,
            'catalog_no' => '',
            'title' => '',
            'artist' => '',
            'display_title' => '',
            'display_artist' => '',
            'media' => '',
            'year_recorded' => '',
            'various_artists' => 0,
            'year_released' => '',
            'image_file' => 'noimage.jpg'
        );
        if ( $release_id != 0 ) {
            $this->db->select('r.id, r.label_id, r.release_type_id, catalog_no, '
                        . 'r.title, r.artist, r.display_title, r.display_artist, '
                        . 'r.media, year_recorded, year_released, r.image_file, '
                        . 'l.name label_name, l.display label_display')
                    ->from('releases r')
                    ->join('labels l', 'l.id = r.label_id', 'left')
                    ->where('r.id', $release_id);
            $query = $this->db->get();
            $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
            $result = $query->row_array();
        }
        return $result;
    }
    
    public function update($update_params)
    {
        if ( $update_params['id'] > 0 ) {
            $this->db->where('id', $update_params['id']);
            $this->db->update('releases', $update_params);
        }
        else {
            unset($update_params['id']);
            $this->db->insert('releases', $update_params);
        }
    }
    
}

/* End of file release_model.php */
/* Location: application/models/release_model.php */