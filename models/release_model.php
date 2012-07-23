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
    
    public function get_release_artists($release_id = 0)
    {
	$this->trace .= 'get_release_artists(' . $release_id . ')<br/>';
        $result = array();
        $this->db->select('ra.release_id, ra.artist_id, ra.is_guest, '
                    . 'a.display')
                ->from('release_artist ra')
                ->join('artists a', 'a.id = ra.artist_id', 'left')
                ->where('ra.release_id', $release_id)
                ->order_by('a.name');
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        if ( $query->num_rows() ) {
            foreach ($query->result() as $row) {
                $result[$row->artist_id] = $row->display;
            }
        }
        return $result;
    }
    
    public function update($update_params)
    {
	$this->trace .= 'update<br/>';
        $result = array('status' => 'ok');
        $release_id = 0;
        $related_artists = $update_params['related_artists'];
        unset($update_params['related_artists']);
	$this->db->trans_start();
        if ( $update_params['id'] > 0 ) {
            $this->db->where('id', $update_params['id']);
            $this->db->update('releases', $update_params);
            $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
            $release_id = $update_params['id'];
        }
        else {
            unset($update_params['id']);
            $this->db->insert('releases', $update_params);
            $release_id = $this->db->insert_id();
            $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
            $this->trace .= 'new id is: ' . $release_id . "<br/>\n";
        }
        // artists
        if (count($related_artists)) {
            foreach ($related_artists as $id => $action){
                if ($action == 'insert') {
                    $data = array(
                        'release_id' => $release_id,
                        'artist_id' => $id
                    );
                    $this->db->insert('release_artist', $data);
                    $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
                    $this->trace .= 'add new artist ' . "<br/>\n";
                }
                elseif ($action == 'delete') {
                    $this->db->where('release_id', $release_id)
                            ->where('artist_id', $id);
                    $this->db->delete('release_artist');
                    $this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
                    $this->trace .= 'delete artist ' . "<br/>\n";
                }
            }
        }
        else {
            $this->trace .= 'no changes in artist list ' . "<br/>\n";
        }
	$this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            // generate an error... or use the log_message() function to log your error
            $result['status'] = 'error';
        } 
        return $result;
    }
    
}

/* End of file release_model.php */
/* Location: application/models/release_model.php */