<?php

class HeaderFooter extends Plugin
{
	public $header;
	public $footer;
	public $title;
	
	public function setTitle($title)
	{
		$this->title = $title;
		Logger::log("Set the page title to '".$title."'");
	}
	
	public function init()
	{
		$this->header = new Template("header");
		$this->header->setCaching(false);
		$this->footer = new Template("footer");
		$this->footer->setCaching(false);
	}
	public function execute()
	{
		
		$this->core->addOutput($this->header);
		
	}
	public function afterRunning()
	{
		$this->header->setVar("title", $this->title);
		$this->core->addOutput($this->footer);
	}
}

?>
