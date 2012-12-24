<?php
/**
 * Template plugin
 * 
 * This plugins allows to use templates. For the persons whose do not like mvc and other structres like that. ;)
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

class Templates extends Plugin
{
	/**
	 * Inits the template plugin. Loads the template class.
	 * */
	public function init()
	{
		require_once FRAMEWORK_BASE."plugins/Templates/Template.class.php";
		require_once FRAMEWORK_BASE."plugins/Templates//Smarty/Smarty.class.php";
	}
	/**
	 * Executes the plugin - but nothing to do.
	 * */
	public function execute()
	{
		
	}
}

?>
