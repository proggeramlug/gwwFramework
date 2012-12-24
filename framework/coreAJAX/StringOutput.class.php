<?php
/**
 * StringOutput class
 * 
 * For a simple string to output.
 * 
 * @author Ralph Küpper
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



class StringOutput extends Output
{
	/**
	 * The content of the string. 
	 * */
	public $content;
	
	/**
	 * Creates the output with the given content.
	 * @param $content - The content of the string.
	 * */
	public function __construct($name, $content)
	{
		$this->name = $name;
		$this->content = $content;
	}
	
	/**
	 * Renders this output. Because it is just a string, there is no difference between html and other format (e.g. json, xml, etc.)
	 * @param $mode - The mode.
	 * @return the rendered content
	 * */
	public function render($mode = "html", $core = null)
	{
		return $this->content;
	}
}

?>
