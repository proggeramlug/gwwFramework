<?php
/**
 * Module class
 * 
 * Parentclass for all moudles.
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

abstract class Module
{
	/** The name of the module. */
	public $name;
	/** The core. */
	protected $core;
	
	/**
	 * Creates a new module and calls the abstract init function.
	 * */
	public function __construct($core)
	{
		$this->core = $core;
		$this->init();
	}
	
	/**
	 * Init function to give the module the possibility to init it in its own way.
	 * */
	protected abstract function init();
	
	/**
	 * Runs the module.
	 * */
	public abstract function execute();
}

?>
