<?php
/**
 * This class represents a language.
 * 
 * @author Ralph Küpper
 * 
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
 
 class Lang
{
	public $strings;
	public $name;
	public $exists;
	
	public static $MAINLANG = null;
	public static $ENG = null;
	
	public function __construct($name)
	{
		$path = Config::getConfig("language_dir");
		if ($path == "")
		{
			
			$this->name = $name;
			$lang = array();
			$this->exists = true;
			if (!file_exists($path."/".$name.".lang.php"))
			{
				$name = "en"; // the default language
				$this->exists = false;
			}
			include($path."/".$name.".lang.php");
			$this->strings = $lang;
			
			Log::log("Loading language from ".$path."/".$name.".lang.php");
		}
	}
	
	
	
	public static function getString($key)
	{
		if (Lang::$MAINLANG == null)
		{
			$lang = 'en'; // default
			
			if (class_exists("UserSession"))
			{
				$u = UserSession::getSession()->getUser();
				$lang = $u->data['language'];
			}
			if ($lang != 'en') Lang::$ENG = new Lang('en');
			Lang::$MAINLANG = new Lang($lang);
		}
		return Lang::$MAINLANG->getLangString($key);
	}
	
	public function getLangString($key)
	{
		$key = strtolower($key);
		$stringExists = false;
		$showEdit = false;
		$ret = '<i>'.$key.'</i>';
		if (array_key_exists($key, $this->strings))
		{
			$stringExists = true;
		}
		else {
			$showEdit = true;
			if ($this->name != 'en')
			{
				$ret = Lang::$ENG->getLangString($key);
				
			}
		}
		
		if ($stringExists) 
		{
			$ret = $this->strings[$key];
		}
		
		if ($showEdit)
		{
			$ret = '<span class="needTranslation" name="'.$key.'">'.$ret.'</span>';
		}
		
		return $ret;
	}
}

?>
