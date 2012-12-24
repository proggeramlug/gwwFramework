<?php
/**
 * Plugin class
 * 
 * Every plugin is loaded by here. Important is that plugins are just like co-configs. They can manipulate and change things before the webapp begins to work and afterwards.
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

abstract class Plugin
{
	/** The name of the plugin. */
	public $name;
	/** The core. */
	public $core;
	
	/**
	 * Creates the plugin.
	 * */
	public function __construct($core)
	{
		$this->core = $core;
	}
	
	/**
	 * This function is to check the resources, the system etc. (not for the executive process itself)
	 * */
	public abstract function init();
	/**
	 * This function is the main process. It does everything the plugin whats to do.
	 * */
	public abstract function execute();
	/**
	 * This function is called after the module.
	 * */
	public function afterRunning()
	{
	}
	/**
	 * This function is called one step becore the module is started.
	 */
	public function preExecute()
	{
	}
}

?>
