<?
/* 	XHTML Screen Scraper PHP Class version 0.3
	------------------------------------------
	Copyright (c) 2004 Antonio Mota Rodrigues - antoniorodrigues_at_omnisinal.com
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.
	
	Keywords: html scraper, html screen scraper, html to array, convert html tables into arrays
	extract data from web pages, get html page as array, scraping, scrapers, xhtml to array,
	xhtml2array
*/


class scraper {

	
	// ----------------------------------
	function browse($s_url, $s_user_agent) {

		print "scraper: browse: Calling $s_url...\n";
		$o_ch = curl_init();

		curl_setopt ($o_ch, CURLOPT_URL, $s_url);
		curl_setopt ($o_ch, CURLOPT_USERAGENT, $s_user_agent);
		curl_setopt ($o_ch, CURLOPT_HEADER, 0);
		curl_setopt ($o_ch, CURLOPT_RETURNTRANSFER, 1);
		$s_html = curl_exec ($o_ch);
		curl_close ($o_ch);
		unset($o_ch);
		
		// Clean html ---------------------
		for ($ascii = 0; $ascii <= 9; $ascii++) $s_html = str_replace(chr($ascii), "", $s_html);
		for ($ascii = 11; $ascii < 32; $ascii++) $s_html = str_replace(chr($ascii), "", $s_html);
		for ($ascii = 127; $ascii <= 255; $ascii++) $s_html = str_replace(chr($ascii), "", $s_html);

		if (!$s_html) print "scraper: WARNING: no results...\n\n";
		return $s_html;

	} //end function
	
	
	// ------------------------------------------------------------------
	function extract ($s_html, $s_start_pattern, $s_end_pattern, $s_model) {
		
		print "scraper: OK. extracting...\n";

		$a_result = array();

		// Cut first block -----------------------
		$i_pos = strpos($s_html, $s_start_pattern);
		$s_html = substr($s_html, $i_pos);

		// Cut last block ----------------------
		$i_pos = strpos($s_html, $s_end_pattern);
		$s_html = substr($s_html, 0, $i_pos);
		
		$s_model = strtolower($s_model);
		$a_model = explode ("\n", $s_model);
		$i_model = count($a_model);
		if (!$a_model[$i_model - 1]) unset($a_model[$i_model - 1]);
		
		$a_html = explode ("<", $s_html);
		$i_cnt = count($a_html);

		// Extract data within tags -----
		for ($f = 0; $f < $i_cnt; $f++) {
			$tag = "<" . $a_html[$f];
			$closepos = strpos ($tag, ">");
			$value = substr($tag, $closepos + 1, strlen($tag) - $closepos);
			$tag = substr($tag,0,strlen($tag) - strlen($value));
			$a_html[$f] = strtolower($tag);
			$dat[$f] = $value;
		}

		$pat = 0;
		$a_pat = array();
		
		for ($f=0; $f < $i_cnt; $f++) {
		
			if ($a_model[$pat]=="<field>") {
				
				// Get data --------
				$value = $dat[$f-1];
				$value = str_replace ("\t", "", $value);
				$value = str_replace ("\n", "", $value);
				$value = str_replace ("\r", "", $value);
				$value = trim ($value);
				if (!$value) $value = "{e}"; 

				array_push($a_pat,$dat[$f-1]);
				$pat++;
				$f--;
			
			} else {
				
				// check pattern ---------------------
				if (substr($a_model[$pat],0,1) == "<") {
					$result = strpos (" " . $a_html[$f], $a_model[$pat],0);
				} else {
					$result = strpos (" " . strtolower($dat[$f]), $a_model[$pat],0);
				}
	
				if (is_integer($result)) { $pat++; }
			}

			if ($pat == count($a_model)-1) {
				$pat = 0;
				if (count($a_pat)) array_push($a_result, $a_pat);
				$a_pat = array();
			}

		} // end for each tag

		return $a_result;

	} // end function


} // end class

?>