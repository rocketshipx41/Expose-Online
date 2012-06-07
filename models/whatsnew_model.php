<?php

/* * *************************************************************
 * Date         Author      Purpose
 *
 * $Header: $
 * ************************************************************* */

class Whatsnew_model extends CI_Model
{
	public $trace = '';
	private $fake_data = array();

	function __construct() 
	{
		parent::__construct();
		$this->fake_data[0]['date'] = '2012-04-04';
		$this->fake_data[0]['body'] = "Majipoor is back! Or at least the Majipoor pages are. I've restored them from incomplete copies, but it's better than what was there.";
		$this->fake_data[1]['date'] = '2012-04-03';
		$this->fake_data[1]['body'] = 'After getting an email from the artist <a href="artist/display/644">John Harris</a>, updated the cover art credit for <a href="publications/display/324">Collision Course</a>.';
		$this->fake_data[2]['date'] = '2012-04-02';
		$this->fake_data[2]['body'] = 'Note that several Silverberg titles are available from <a href="http://www.ereads.com/ecms/authorname/Robert-Silverberg">e-reads</a> in convenient digital form.';
		$this->fake_data[3]['date'] = '2012-04-01';
		$this->fake_data[3]['body'] = 'Needed to add a dummy update, so this is it.';
		$this->fake_data[4]['date'] = '2012-03-30';
		$this->fake_data[4]['body'] = 'Really should have done something on this day, but apparently did not. Stay posted for more nothing days.';
		$this->fake_data[5]['date'] = '2010-03-11';
		$this->fake_data[5]['body'] = 'I got an email from RS this morning, and learned of a previously unknown (even to him!) Western story called <a href="works/display/1750">Get out of Town</a>.';
		$this->fake_data[6]['date'] = '2010-02-20';
		$this->fake_data[6]['body'] = "For those interested in Silverberg's \"adult\" writings of the 60s, some more information about cover art for Campus Sex Club and The Fires Within. The artist was Robert A Maguire.";
		$this->fake_data[7]['date'] = '2010-02-11';
		$this->fake_data[7]['body'] = "I got an email this morning from Alix Didrich, director of a French screen adaptation of <a href=\"works/display/771\">The Mutant Season</a>. You can find more information here and here. The schedule isn't set yet, but it should be on France 3 TV later this year.";
		$this->fake_data[8]['date'] = '2010-02-03';
		$this->fake_data[8]['body'] = 'Lorem ipsum majipoori rex, fantasticum maximum Valentinii forex mus musca planitium redux calorum annum et cetera.';
		$this->fake_data[9]['date'] = '2010-01-21';
		$this->fake_data[9]['body'] = 'Happy birthday to anyone whose birthday is 21 January. You know who you are.';
		$this->fake_data[10]['date'] = '2009-12-24';
		$this->fake_data[10]['body'] = "Remember, kids, if Santa passes you by, you can buy Silverberg books online with your parents' credit cards.";
	}
	
	function get_latest($max = 10)
	{
		$result = array();
		for ($i = 0; $i < $max; $i++) {
			$result[$i] = $this->fake_data[$i];
		}
		return $result;
	}

}