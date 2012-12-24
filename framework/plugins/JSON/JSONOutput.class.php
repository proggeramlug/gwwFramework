<?php

class JSONOutput extends Output
{
	private $obj;
	
	public function __construct($o)
	{
		$this->obj = $o;
	}
		
	public function render($mode = "json", $core = null)
	{
		$mode = "json";
		if ($mode == "json")
		{
			$output = $this->obj->getJSON();
			ob_end_clean();
			die($output);
		}
	}
	
	public function init()
	{
		
	}
}
