<?php
/**
 * Log class
 * 
 * Logs every important action.
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


class Logger
{
	private $logs;
	
	/**
	 * Creates the logger. 
	 * */
	public function __construct()
	{
		$this->logs = array();
	}
	
	/**
	 * Logs a simple string.
	 * @param $s - The string to log.
	 * */
	public function logString($s, $type = "normal")
	{
		$s = "<span class=\"".$type."\">$s</span>";
		$this->logs[] = $s;
		
		if ($type == "error") 
		{
			die(Logger::$logger->getLog());
		}
	}
	
	/**
	 * Returns the complete log (separated by <br />)
	 * @return string
	 * */
	public function getLog()
	{
		$output = "";
		foreach ($this->logs as $log)
		{
			$output .= $log."<br />";
		}
		return $output;
	}
	
	
	/**
	 * The static logger to use.
	 * */
	public static $logger;
	
	/**
	 * The static log function for simple usability. 
	 * */
	public static function log($s, $type = "normal")
	{
		if (Logger::$logger == null)
		{
			Logger::$logger = new Logger();
		}
		
		Logger::$logger->logString($s, $type);
	}
}
