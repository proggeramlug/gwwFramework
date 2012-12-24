<?php
/**
 * Here are a set of common used php functions.
 * 
 * @author Serhiy Medvedyev
 * 
 *  This script is part of the gwwFramework. Developed and produced by Skelpo - hot software.
 *  If you have any questions, recommendations or general requests visit our website
 *  http://www.skelpo.com or write an email to info@skelpo.com
 * 
 *  Copyright (C) 2012  Skelpo
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * */


function xml_qt($s){
	$str = (string)$s;
	$out = '';
	$len = strlen($str);
	$ch = '';
	for($i=0;$i<$len;$i++){
		$ch = $str[$i];
		switch($ch){
			case '&':
				$ch='&amp;';
				break;
			case '"':
				$ch='&quot;';
				break;
			case '<':
				$ch='&lt;';
				break;
			case '>':
				$ch='&gt;';
				break;
		}
		$out.=$ch;
	}
	return $out;
}


function js_qt($s){
	return preg_replace("/(\n|\r)/"," ",preg_replace("/(\\\\|'|\")/", "\\\\$1", $s));
}



/*
 * Random string generator.
 */

function randomkey($length)
{
    $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
    $key  = $pattern[rand(0,35)];
    for($i=1;$i<$length;$i++)
    {
        $key .= $pattern[rand(0,35)];
    }
    return $key;
}



/*
 * Translation functions.
 */

function hex2bin($str){
	$out = '';
	$len = strlen($str);
	for($i=0;$i<$len;$i+=2) $out .= chr(hexdec(substr($str,$i,2)));
	return $out;
}


/* Date/time functions */

// returns human-readable date from unix timestamp

function dateFromTs($ts)
{
	if ( function_exists('ownDateFromTs') )
	{
		return ownDateFromTs($ts);
	}
	return date("F j, Y, g:i a", $ts);
}


