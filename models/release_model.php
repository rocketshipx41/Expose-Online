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
                    . 'a.display, a.slug')
                ->from('release_artist ra')
                ->join('artists a', 'a.id = ra.artist_id', 'left')
                ->where('ra.release_id', $release_id)
                ->order_by('a.name');
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        if ( $query->num_rows() ) {
            foreach ($query->result() as $row) {
		$result[$row->artist_id] = array(
                    'display' => $row->display,
                    'slug' => $row->slug
                );
            }
        }
        return $result;
    }
    
    function get_article_list($id = 0)
    {
	$this->trace .= 'get_article_list<br/>';
        $result = array();
        if ($id > 0) {
            $this->db->select('a.title, a.slug, a.category_id, c.item_name category, ar.article_id')
                    ->from('article_release ar')
                    ->join('articles a', 'a.id = ar.article_id')
                    ->join('categories c', 'c.id = a.category_id')
                    ->where('ar.release_id', $id)
                    ->where('a.status', 'live')
                    ->where('a.published_on <= CURDATE()');
            $query = $this->db->get();
            $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
            $result = $query->result_array();
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
        else {
            $result['release_id'] = $release_id;
        }
        return $result;
    }
    
    public function get_list()
    {
	$this->trace .= 'get_list()<br/>';
        $this->db->select('r.id, r.artist, r.title, r.display_artist, '
                . 'r.display_title')
                ->from('releases r')
                ->order_by('artist, title');
        $result = array();
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        if ( $query->num_rows() ) {
            foreach ($query->result() as $row) {
                $result[$row->id] = $row->display_artist . ' - '
                    . $row->display_title;
            }
        }
        return $result;
    }
    
    function fix_slugs()
    {
	$this->trace .= 'fix_slugs<br/>';
	$result = '';
	$artist_list = array();
        $this->db->select('id, title, artist, year_released')
                ->from('releases');
        $query = $this->db->get();
        $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
        $artist_list = $query->result_array();
	foreach ($artist_list as $item) {
            $slug = create_unique_slug($item['artist'] . '-' . $item['title']
                    . '-' . $item['year_released'],
			'artists');
	    $result .= 'update releases set slug = ' . $this->db->escape($slug)
		    . ' where id = ' . $this->db->escape($item['id']) . ";\n";
	}
	return $result;
    }
    
    public function get_unassigned($start = '', $max_count = 40)
    {
	$this->trace .= 'get_unassigned<br/>';
        $this->db->select('r.id, r.display_artist, r.display_title')
                ->from('releases r')
                ->join('release_artist ra', 'ra.release_id = r.id', 'left')
                ->where('ra.artist_id is null')
                ->order_by('r.artist, r.title')
                ->limit($max_count);
        if ( $start ) {
            $this->db->where('r.artist >', $start);
        }
        $result = array();
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        if ( $query->num_rows() ) {
            foreach ($query->result() as $row) {
                $result[$row->id] = $row->display_artist . ' - '
                    . $row->display_title;
            }
        }
	return $result;
    }
    
    public function bulk_assign_artists($change_list)
    {
	$this->trace .= 'bulk_assign_artists<br/>';
        $result = 0;
        foreach ($change_list as $item) {
            $this->db->insert('release_artist', $item);
        }
        return $result;
    }
    
    public function get_list_by_label($label_id)
    {
        $this->trace .= 'get_list_by_label<br/>';
        $this->db->select('r.display_title, r.display_artist, r.media, r.year_recorded, '
                    . 'r.year_released, r.id release_id, r.image_file, r.label_id, '
                    . 'l.display label_name, r.catalog_no, r.media_count')
                ->from('releases r')
                ->join('labels l', 'l.id = r.label_id', 'left')
                ->where('label_id', $label_id)
                ->order_by('year_released');
        $result = array();
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $result = $query->result_array();
        return $result;
    }
    
    function search($search_value, $max_count = 0, $starter = '')
    {
	$this->trace .= 'search<br/>';
        $result = array();
        $this->db->select('r.display_title, r.display_artist, r.media, r.year_recorded, '
                    . 'r.year_released, r.id release_id, r.image_file, r.label_id, '
                    . 'l.display label_name, r.catalog_no, r.media_count')
                ->from('releases r')
                ->join('labels l', 'l.id = r.label_id', 'left')
                ->like('r.title', $search_value)
                ->order_by('r.artist, r.title, year_released');
        $query = $this->db->get();
	$this->trace .= 'sql: ' . $this->db->last_query() . "<br/>\n";
        $result = $query->result_array();
        return $result;
    }
    
}

/* End of file release_model.php */
/* Location: application/models/release_model.php */