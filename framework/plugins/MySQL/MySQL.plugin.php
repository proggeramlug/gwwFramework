<?php
/**
 * Mysql plugin
 * 
 * This plugin offers the possibility to use a mysql database. The plugin is structed this way:
 * There is a mysql connection.
 * And in a connections are queries.
 * 
 * If you want to use more than one connection you just create another and thats it. Easy.
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

class MySQL extends Plugin
{
	public function init() 
	{
		$pluginDir = FRAMEWORK_BASE."plugins/";
		if (Config::getConfig("plugin_dir") != "") $pluginDir = Config::getConfig("plugin_dir");
		
		include($pluginDir . "MySQL/MySQLConnection.class.php");
		include($pluginDir . "MySQL/DBQuery.class.php");
	}
	
	
	public function execute()
	{
		
	}
	
}

?>
