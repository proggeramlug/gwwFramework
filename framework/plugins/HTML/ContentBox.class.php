<?php

/**
 * A content box.
 * 
 * @author Ralph Küpper
 */
class ContentBox extends Output
{
	/** The content. */
	protected $content;
	/** The content partly. */
	protected $contents;
	/** The title. */
	protected $title;
	
	/**
	 * Creates a new ContentBox.
	 * @param multi $data [optional]
	 * @return 
	 */
	public function __construct($data = null)
	{
		if (is_object($data))
		{
			$this->content = $data;
		}
		else if (is_string($data))
		{
			$this->title = $data;
		}
		$this->contents = array();
	}
	/**
	 * Adds a content to this box.
	 * @param object $output
	 * @return 
	 */
	public function addContent($output)
	{
		$this->contents[] = $output;
	}
	
	public function setContent($content)
	{
		$this->content = $content;
	}
	
	public function setTitle($title)
	{
		$this->title = $title;
	}
	
	public function render($mode = "html", $core = null)
	{
		$template = new Template("HTML/ContentBox");
		$c = '';
		if (isset($data) && is_object($data))
		{
			if (get_parent_class($data) == "Output")
			{
				$c = $this->content->render($mode,$core);
			}
			else {
				if (method_exists($this->content, "render"))
				{
					$c = $this->content->render($mode,$core);
				}
			}
		}
		else if (is_string($this->content))
		{
			$c = $this->content;
		}
		
		foreach ($this->contents as $content)
		{
			$c .= $content->render($mode, $core);
		}
		
		$titleString = "";
		if ($this->title != "")
		{
			$headline = new Headline($this->title,"h1");
			$titleString = $headline->render($mode,$core);
		}
		
		$template->setVar("content", $c);
		$template->setVar("title", $titleString);
		
		return $template->render($mode, $core);
	}
}

?>
