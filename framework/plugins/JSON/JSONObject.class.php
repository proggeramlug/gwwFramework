<?php

class JSONObject
{
	public $elements;
	
	public function __construct($mixed = null)
	{
		if (is_array($mixed))
		{
			$this->elements = $mixed;
		}
		else if (is_string($mixed))
		{
			$this->elements = json_decode($mixed);
		}
		else {
			$this->elements = array();
		}
	}
	
	public function getJSON()
	{
		
		return json_encode($this->elements);
	}
	
	
	
	public function addElement($key, $value)
	{
		$this->elements[$key] = $value;
		
	}
}

?>
