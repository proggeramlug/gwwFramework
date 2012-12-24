<?php

class Lang
{
	public $strings;
	public $name;
	public $missingKeys;
	
	public static $MAINLANG = null;
	public static $DEFAULTLANG = null;

	public static $dict = null;
	
	public function __construct($name)
	{
		$path = Config::getConfig("language_dir");
		if ($path != "")
		{
			$this->name = $name;
			$lang = array();
			if (file_exists($path."/".$name.".lang.php"))
			{
				require_once($path."/".$name.".lang.php");
			}
			else {
				Logger::log("Language file not found ... trying to load from: ".$path."/".$name.".lang.php","error");
			}
			$this->strings = $lang;
			
			Logger::log("Loading language from ".$path."/".$name.".lang.php");
		}
		else {
			$this->strings = array();
			Logger::log("No language dir given.","error");
		}
		
		$this->missingKeys = array();
	}

	private static function createDict()
	{
		self::$dict = & self::$MAINLANG->strings;
	}
	
	public static function getMissingKeys()
	{
		return Lang::$MAINLANG->missingKeys;
	}
	public static function getLanguageName()
	{
		return Lang::$MAINLANG->name;
	}
	public static function changeLanguage($newLangName)
	{
		
		Lang::$MAINLANG = new Lang($newLangName);
	}
	
	public static function getString($key)
	{
		$args = array();
		
		$pos = strpos($key, ",");

		if ( $pos > 0 )
		{
			$args_ = substr($key, $pos+1);
			$key = substr($key,0,$pos);
			$args = explode(",",$args_);
		}

		if ( func_num_args() > 1 ) {
		    	$args = func_get_args();
		    	$args = array_slice($args, 1);
		}

		if (Lang::$MAINLANG == null)
		{
			Lang::$MAINLANG = new Lang(Config::getConfig("default_language"));
		}
		if (Lang::$DEFAULTLANG == null)
		{
			Lang::$DEFAULTLANG = new Lang(Config::getConfig("default_language"));
		}

		if ( self::$dict == null ) self::createDict();

		return Lang::$MAINLANG->getLangString($key, $args);
	}
	
	public function getLangString($key, $args = array())
	{
		$key = strtolower($key);
		$ret = "";
		$gen = '';
		
		$startWithN = false;

		if ( count($args) == 1 && ( $args[0] == 'm' || $args[0] == 'f' ) ) $gen = '.' . $args[0];

		if ( count($args) > 0 )
		{
			if ( substr($args[0], 0, 1) == "n" )
			{
				$i = intval(substr($args[0],1));
				if ( $i > 0 ) {
					$startWithN = true;
					$args[0] = $i;
				}
			}
		}
		
		if ( (count($args) == 1 && is_numeric($args[0])) || $startWithN ) {
			$n = ( $args[0] > 11 ) ? 11 : $args[0];

			for ( $i = $n ; $i >= 0 ; $i-- ) {
				if ( isset($this->strings[$key . '.num' . $i]) ) {
					$key.= '.num' . $i;
					break;
				}
			}
		}
		

		
		if ( array_key_exists($key.$gen, $this->strings) )
		{
			$ret = $this->strings[$key.$gen];
		}
		else if ( array_key_exists($key, $this->strings) )
		{
			$ret = $this->strings[$key];
		}
		else {
			Logger::log("Language key not found '".$key."'","warning");
			$ret =  "<i>$key</i>";
			if (Lang::$DEFAULTLANG->name != $this->name) $ret = "".Lang::$DEFAULTLANG->getLangString($key,$args)."";
			$this->missingKeys[] = $key;
		}
		
		$ret = str_replace("{BASE}",Config::getConfig("base"),$ret);
		$replace1 = array();
  		$replace2 = array();
  		for($index=count($args)-1;$index>=0;$index--) {
    		$replace1[] = "/\\$(\\{".$index."\\}|$index(?=\\b|\\D))/";
    		$replace2[] = $args[$index];
  		}
  		$ret =  preg_replace($replace1,$replace2,$ret);
  
		return $ret;
	}
}


?>
