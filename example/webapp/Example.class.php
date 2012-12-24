<?php
/**
 * Simple example how to use the gwwFramework. This very simple code is not running as it is given to use
 * and is only meant to demonstrate ways of how to use the framework. There basically no limits of how you can
 * extend this application. Please take a look into all the code files - they are short on purpose to make it easy
 * to understand the system.
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


class Example extends Core
{	
	public function execute()
	{
		// security check
		$availableModules = array(
			"index"
		);
		
		// standard procedure
		parent::execute();
	}
	
	
	public function init()
	{
		// just a little helper
		define("BASE", Config::getConfig("base"));
		
		// the language setup
		Lang::$MAINLANG = new Lang("de");
		
		// load our own module
		$ownPlugins = array("ExamplePlugin");
		foreach ( $ownPlugins as $plugin )
		{	
			$this->loadPlugin($plugin, WEBAPP_BASE."plugins/");
		}
	}
	
	
	
	public function afterAll()
	{
		// useful variables
		$this->getPlugin("HeaderFooter")->header->setVar("BASE", BASE);
		$this->getPlugin("HeaderFooter")->footer->setVar("BASE", BASE);
	}
	
}


