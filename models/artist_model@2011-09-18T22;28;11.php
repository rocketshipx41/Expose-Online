<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Name:  Artist Model
 * 
 * Author: Jon Davis
 * 
*/

class Artist_model extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
   
    function get_list($max_count = 0, $offset = 0)
    {
        $this->db->select('id, display, country_id, slug')
                ->from('artists')
                ->order_by('name');
        if (($max_count > 0) && ($offset > 0)) {
            $this->db->limit($max_count, $offset);
        }
        elseif ($max_count > 0) {
            $this->db->limit($max_count);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function get_info($slug = '')
    {
        $result = array();
        if ($slug != '') {
            $this->db->select('display, country_id, years_active, url, info, '
                    . 'user_id, id')
                    ->from('artists')
                    ->where('slug', $slug);
            $query = $this->db->get();
            $result = $query->row_array();
        }
        return $result;
    }
    
    function get_article_list($id = 0)
    {
        $result = array();
        if ($id > 0) {
            $this->db->select('a.title, a.slug')
                    ->from('article_artist aa')
                    ->join('articles a', 'a.id = aa.article_id')
                    ->where('aa.artist_id', $id);
            $query = $this->db->get();
            $result = $query->result_array();
        }
        return $result;
    }
    
    function fix_slugs()
    {
	$result = '';
	$artist_list = array();
        $this->db->select('id, name, country_id, slug')
                ->from('artists');
        $query = $this->db->get();
        $artist_list = $query->result_array();
	foreach ($artist_list as $item) {
	    if ($item['country_id'] == '???') {
		$slug = create_unique_slug($item['name'], 'artists');
	    }
	    else {
		$slug = create_unique_slug($item['name'] . '-' . $item['country_id'],
			'artists');
	    }
	    $result .= 'update artists set slug = ' . $this->db->escape($slug)
		    . ' where id = ' . $this->db->escape($item['id']) . ";\n";
	}
	return $result;
    }
}

/* End of file artist_model.php */
/* Location: application/models/artist_model.php */