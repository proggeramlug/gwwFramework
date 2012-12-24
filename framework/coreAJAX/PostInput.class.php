<?php
/**
 * Input class
 * 
 * This class represents every input a webapp can have. Posts, Gets and Cookies.
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


class PostInput extends Input
{
	public function isEmail()
	{
		$expression = "/^[_a-zA-Z0-9-](\.{0,1}[_a-zA-Z0-9-])*@([a-zA-Z0-9-]{2,}\.){0,}[a-zA-Z0-9-]{3,}(\.[a-zA-Z]{2,4}){1,2}$/";
		
		return preg_match($expression, $this->value);
	}
	
	public function toSQL()
	{
		return mysql_escape_string($this->value);
	}
	
	public function getValue()
	{
		return $this->value;
	}
	
}

?>
