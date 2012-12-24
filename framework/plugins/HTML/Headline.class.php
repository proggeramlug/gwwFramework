<?php

class Headline extends Output
{
	protected $type;
	protected $title;
	
	public function __construct($title, $type = "h1")
	{
		$this->title = $title;
		$this->type = $type;
	}
	public function render($mode = "html", $core = null)
	{
		if ($mode == "html")
		{
			$output = "";
			
			switch ($this->type)
			{
				case 'h1':
					$output = "<h1>".$this->formatHeadline()."</h1>";
					break;
				case 'h2':
					$output = "<h2>".$this->formatHeadline()."</h2>";
					break;
				case 'h3':
					$output = "<h3>".$this->formatHeadline()."</h3>";
					break;
				case 'h4':
					$output = "<h4>".$this->formatHeadline()."</h4>";
					break;
				case 'text':
					$output = "<strong>".$this->formatHeadline()."</strong>";
					break;
			}
			return $output;
		}
	}
	
	protected function formatHeadline()
	{
		return $this->title;
	}
				
}
