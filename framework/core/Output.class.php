<?php
/**
 * Output class
 * 
 * Abstract class for outputs.
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

abstract class Output
{
	// the name
	public $name;
	
	// the ajax outputs (just name/value)
	protected $jsonOutputs;

	/** 
	 * Adds an ajax output to this instance.
	 * An ajax output is a name and a value to be parsed by json.
	 * */
	protected function addJSONOutput($name, $value)
	{
		$this->jsonOutputs[$name] = $value;
	}
	/**
	 * Returns the json formated ajax output.
	 * @return json-string
	 * */
	protected function getJSONOutput()
	{
		return json_encode($this->jsonOutputs);
	}
	
	
	/**
	 * Abstract function that every output has to define.
	 * */
	public abstract function render($mode = "html", $core = null);
	
}
	



?>
