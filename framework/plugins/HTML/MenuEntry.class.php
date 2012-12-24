<?php

class MenuEntry
{
	public $target;
	public $title;
	public $onclick;
	
	public $subMenu;
	
	public $extraClasses = "";
	
	public function __construct($title, $target, $subMenu = false, $extraClasses = "", $onclick = "")
	{
		$this->title = $title;
		$this->target = $target;
		$this->subMenu = $subMenu;
		$this->extraClasses = $extraClasses;
		$this->onclick = $onclick;
	}
	
}

?>
