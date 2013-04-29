<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Name:  Artist Model
 * 
 * Author: Jon Davis
 * 
*/

class Artist_model extends CI_Model
{
    public $trace = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
	$this->trace = '>> construct artist model<br/>';
    }
   
    function get_list($max_count = 0, $starter = '', $add_select = FALSE,
            $reverse_name = FALSE)
    {
	$this->trace .= 'get_list<br/>';
        $result = array();
        if ( $add_select ) {
            $result['0'] = array(
                'display' => 'Select...',
                'country_id' => ''
            );
        }
        $this->db->select('a.id, a.name, a.display, a.country_id, a.slug, '
                    . 'a.image_file, c.name country, '
                    . '(select count(article_id) from article_artist aa where aa.artist_id = a.id) as article_count, '
                    . '(select count(release_id) from release_artist ra where ra.artist_id = a.id) as release_count')
                ->from('artists a')
                ->join('countries c', 'c.id = a.country_id', 'left')
                ->group_by('a.id')
                ->order_by('name');
        if ($max_count > 0) {
            $this->db->limit($max_count);
        }
        if ($starter) {
            $this->db->where('name >=', $starter);
        }
        $query = $this->db->get();
        $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
	foreach ($query->result() as $row) {
	    if ($row->display) {
                if ( $reverse_name ) {
                    $result[$row->id] = array(
                        'display' => $row->name,
                        'country_id' => $row->country_id,
                        'country' => $row->country,
                        'release_count' => $row->release_count,
                        'image_file' => 'artists/' . $row->image_file,
                        'slug' => $row->slug
                    );
                }
                else {
                    $result[$row->id] = array(
                        'display' => $row->display,
                        'country_id' => $row->country_id,
                        'counry' => $row->country,
                        'image_file' => 'artists/' . $row->image_file,
                        'slug' => $row->slug
                    );
                }
                //$result[$row->id]['release_count'] = $this->get_release_count($row->id);
	    }
	}
        return $result;
    }
    
    private function get_release_count($artist_id)
    {
        $this->db->select('count(release_id)')
                ->from('release_artist')
                ->where('artist_id', $artist_id);
    }
    
    public function get_backlink($base = '', $count_back = 0)
    {
	$this->trace .= 'get_backlink(' . $base . ', ' . $count_back . ')<br/>';
        $result = '';
        if ( $count_back == 0 ) {
            $result = $base;
        }
        else {
            $this->db->select('slug')
                    ->from('artists')
                    ->where('name <', $base)
                    ->order_by('name', 'desc')
                    ->limit($count_back);
            $query = $this->db->get();
            $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
            foreach ($query->result() as $row) {
                $result = $row->slug;
            }
            $result = substr($result, 0, -1);
            $this->trace .= 'backlink is ' . $result . '<br/>';
        }
        return $result;
    }
    
    function article_artist_list($max_count = 0, $starter = '')
    {
	$this->trace .= 'article_artist_list<br/>';
        $result = array();
        $this->db->select('a.id, a.name, a.display, c.name country, a.slug, a.image_file, a.country_id, '
                    . '(select count(article_id) from article_artist aa where aa.artist_id = a.id) as article_count, '
                    . '(select count(release_id) from release_artist ra where ra.artist_id = a.id) as release_count')
                ->from('artists a')
                ->group_by('a.id')
                ->having('article_count > 0')
                ->join('countries c', 'c.id = a.country_id', 'left')
                ->order_by('a.name, a.country_id');
        if ($max_count > 0) {
            $this->db->limit($max_count);
        }
        if ($starter) {
            $this->db->where('a.name >=', $starter);
        }
        $query = $this->db->get();
        $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
	foreach ($query->result() as $row) {
	    if ($row->display) {
                $result[$row->id] = array(
                    'display' => $row->display,
                    'country_id' => $row->country_id,
                    'country' => $row->country,
                    'article_count' => $row->article_count,
                    'release_count' => $row->release_count,
                    'image_file' => 'artists/' . $row->image_file,
                    'slug' => $row->slug
                );
	    }
	}
        return $result;
    }
    
    function search($search_value, $max_count = 0, $starter = '')
    {
	$this->trace .= 'search<br/>';
        $result = array();
        $this->db->select('a.id, a.display, a.country_id, '
                    . 'c.name country, a.slug, a.image_file')
                ->from('artists a')
                ->join('countries c', 'c.id = a.country_id', 'left')
                ->like('a.name', $search_value)
                ->order_by('a.name');
        if ($max_count > 0) {
            $this->db->limit($max_count);
        }
        if ($starter) {
            $this->db->where('name >=', $starter);
        }
        $query = $this->db->get();
        $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
        if ( $query->num_rows() ) {
            foreach ($query->result() as $row) {
                if ($row->display) {
                    $result[$row->id] = array(
                        'display' => $row->display,
                        'country_id' => $row->country_id,
                        'country' => $row->country,
                        'image_file' => 'artists/' . $row->image_file,
                        'slug' => $row->slug
                    );
                }
            }
        }
        return $result;
    }
    
    function get_info($slug = '')
    {
	$this->trace .= 'get_info<br/>';
        $result = array(
            'display' => '',
            'country_id' => '',
            'years_active'=> '',
            'url'=> '',
            'info'=> '',
            'user_id'=> '',
            'id'=> '',
            'image_file'=> '',
            'country_name'=> '',
            'slug'=> '',
            'name'=> '',
        );
        if ($slug != '') {
            $this->db->select('a.display, a.country_id, a.years_active, a.url, a.info, '
                    . 'a.user_id, a.id, a.image_file, c.name country_name, a.slug, '
                    . 'a.name')
                    ->from('artists a')
                    ->join('countries c', 'c.id = a.country_id', 'left')
                    ->where('slug', $slug);
            $query = $this->db->get();
            $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
            $result = $query->row_array();
        }
        return $result;
    }
    
    function get_base_info($id = 0)
    {
	$this->trace .= 'get_info<br/>';
        $result = array(
            'id' => $id,
            'name' => '',
            'display' => '',
            'slug' => ''
        );
        if ( $id != 0 ) {
            $this->db->select('id, name, display, slug')
                    ->from('artists')
                    ->where('id', $id);
            $query = $this->db->get();
            $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
            $result = $query->row_array();
        }
        return $result;
    }
    
    function get_article_list($id = 0)
    {
	$this->trace .= 'get_article_list<br/>';
        $result = array();
        if ($id > 0) {
            $this->db->select('a.title, a.slug, a.category_id, c.item_name category')
                    ->from('article_artist aa')
                    ->join('articles a', 'a.id = aa.article_id')
                    ->join('categories c', 'c.id = a.category_id')
                    ->where('aa.artist_id', $id)
                    ->where('status', 'live');
            $query = $this->db->get();
            $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
            $result = $query->result_array();
        }
        return $result;
    }
    
    function get_release_list($id = 0)
    {
	$this->trace .= 'get_release_list<br/>';
        $result = array();
        if ($id > 0) {
            $this->db->select('ra.release_id, r.display_title, r.display_artist, '
                        .'r.media, r.media_count, r.year_released, r.image_file, '
                        . 'r.catalog_no, r.year_recorded, r.label_id, l.display label_name')
                    ->from('release_artist ra')
                    ->join('releases r', 'r.id = ra.release_id')
                    ->join('labels l', 'l.id = r.label_id', 'left')
                    ->where('ra.artist_id', $id)
                    ->order_by('year_released desc, title');
            $query = $this->db->get();
            $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
            $result = $query->result_array();
        }
        return $result;
    }
    
    function fix_slugs()
    {
	$this->trace .= 'fix_slugs<br/>';
	$result = '';
	$artist_list = array();
        $this->db->select('id, name, country_id, slug')
                ->from('artists');
        $query = $this->db->get();
        $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
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
    
    public function update_info($artist_id, $params)
    {
	$this->trace .= 'update_info<br/>';
	$result = array('status' => 'ok');
        if ( $artist_id ) {
            $this->db->where('id', $artist_id);
            $this->db->update('artists', $params);
            $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
        }
        else {
            $this->db->insert('artists', $params);
            $this->trace .= 'sql: ' . $this->db->last_query()  . "<br/>\n";
        }
	return $result;
    }
    
}

/* End of file artist_model.php */
/* Location: application/models/artist_model.php */