<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * various miscelaneous functions
 */

/**
 *
 * @param type $string
 * @param type $table
 * @param type $field
 * @param type $key
 * @param type $value
 * @return type 
 */
function create_unique_slug($string, $table, $field = 'slug', $key = NULL, $value = NULL)
{
    $t =& get_instance(); 

    $slug = url_title($string);
    $slug = strtolower($slug);
    $i = 0;
    $params = array ();
    $params[$field] = $slug;

    if ($key)$params["$key !="] = $value;

    while ($t->db->where($params)->get($table)->num_rows()) {
	if (!preg_match ('/-{1}[0-9]+$/', $slug )) {
	    $slug .= '-' . ++$i;
	} 
	else {
	    $slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
	}
	$params [$field] = $slug;
    }
    return $slug;
}
	
function credit_display($credit_list, $role_id)
{
    $result = '';
    if (is_array($credit_list)) {
	foreach ($credit_list[$role_id] as $id => $item) {
	    if ($result != '') {
		$result .= ', ';
	    }
	    if (isset($item)) {
		$result .= '<a href="' . site_url('people/display/' . $id) 
                        . '">' . $item . '</a>';
	    }
	    else {
		$result .= '(??)';
	    }
	}
    }
    return $result;
}

function topic_display($topic_list)
{
    $result = '';
    if (is_array($topic_list)) {
	foreach ($topic_list as $item) {
	    if ($result != '') {
		$result .= ', ';
	    }
	    $result .= anchor('articles/topic/' . $item['topic_slug'], $item['title']);
	}
	
    }
    return $result;
}

function artist_display($artist_list)
{
    $result = '';
    if (is_array($artist_list)) {
	foreach ($artist_list as $item) {
	    if ($result != '') {
		$result .= ', ';
	    }
            // TODO: make it a link
            $result .= anchor('artists/display/' . $item['slug'], $item['display']);
	}
	
    }
    return $result;
}

function release_line($release)
{
    $result = '(';
    if ($release['label_name']) {
        $result .= anchor('labels/display/' . $release['label_id'], $release['label_name']) . ' ';
    }
    $result .= $release['catalog_no'] . ', ';
    if (($release['year_recorded'] > 0) 
            && ($release['year_recorded'] != $release['year_released'])) {
        $result .= $release['year_recorded'] . '/';
    }
    $result .= $release['year_released']. ', ';
    if ($release['media_count'] > 1) {
        $result .= $release['media_count'];
    }
    $result .= $release['media'] . ')';
    return $result;
}

function smart_trim($src, $max_len)
{
    $result = $src;
    if (strlen($result) > $max_len) {
       $result = array_shift(explode('|||', wordwrap($result, $max_len, '|||'))) . '...'; 
   }
   return restore_tags($result);
}

function restore_tags($input) { 
    // Original PHP code by Chirp Internet: www.chirp.com.au 
    // Please acknowledge use of this code by including this header.     
    $opened = array(); 
    // loop through opened and closed tags in order 
    if (preg_match_all("/<(\/?[a-z]+)>?/i", $input, $matches)) { 
        foreach ($matches[1] as $tag) { 
            if (preg_match("/^[a-z]+$/i", $tag, $regs)) { // a tag has been opened 
                if (strtolower($regs[0]) != 'br') $opened[] = $regs[0]; 
            } 
            elseif (preg_match("/^\/([a-z]+)$/i", $tag, $regs)) { 
                // a tag has been closed 
                unset($opened[array_pop(array_keys($opened, $regs[1]))]); 
            } 
        } 
    } // close tags that are still open 
    if ($opened) { 
        $tagstoclose = array_reverse($opened); 
        foreach($tagstoclose as $tag) $input .= "</$tag>"; 
    } 
    return $input; 
}

/**
* Anchor Image Link
*
* Creates an anchor on a image based on the local URL.
* Based on the CodeIgniters original Anchor Link and Image (img()).
*
* Author(s): Isern Palaus <ipalaus@ipalaus.es>
*
* @access    public
* @param    string    the URL
* @param    string    the image URL
* @param    string    the image alt
* @param    mixed    a attributes
* @param    mixed    img attributes
* @return    string
*/    
if ( ! function_exists('anchor_img'))
{
    function anchor_img($uri = '', $img = '', $alt = '', $anchor_attr = '', $image_attr = '')
    {
        $alt = (string) $alt;
        $imgatt = '';
        if ( ! is_array($uri)) {
            $site_url = ( ! preg_match('!^\w+://! i', $uri)) ? site_url($uri) : $uri;
        }
        else {
            $site_url = site_url($uri);
        }
        if ( ! is_array($img)) {
            //$image = ( ! preg_match('!^w+://! i', $img)) ? site_url($img) : $img;
            $image = image_url($img);
        }
        else {
            $image = site_url($img);
        }
        if ($image_attr) {
            foreach ($image_attr as $k=>$v) {
                $imgatt .= " $k=\"$v\" ";
            }
        }
        if ($alt == '') {
            $alt = $site_url;
        }
        if ($anchor_attr != '') {
            $anchor_attr = _parse_attributes($anchor_attr);
        }
        return '<a href="' . $site_url . '"' . $anchor_attr . '><img src="'
                . $image . '" alt="' . $alt . '"' . $imgatt . '/></a>' . "\n";
    }
}
