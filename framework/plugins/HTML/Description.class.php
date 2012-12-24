<?php

/**
 * A description for a form element (text, select, ..).
 * 
 * @author Ralph Küpper
 */
class Description {
	// the depending form element
	public $formElement;
	// the content 
	public $content;
	// the title of this description 
	public $title; // over effect
	public $addClasses;
	
	// the static template - can be changed
	public static $TEMPLATE = '<div class="description{addClasses}">{text}</div>';
	
	/**
	 * Creates a new description with content and title.
	 * @param string $content
	 * @param string $title [optional]
	 */
	public function __construct($content, $title = "", $addClasses = "") 
	{
		$this->content = $content;
		$this->title = $title;
		$this->addClasses = $addClasses;
	}
	/**
	 * Sets the specific form element.
	 * @param FormElement $fE
	 */
	public function setFormElement($fE) 
	{
		$this->formElement = $fE;
	}
	/**
	 * Renders the code.
	 * @return string $code
	 */
	public function render()
	{
		$code = str_replace("{text}", $this->content, Description::$TEMPLATE);
		$code = str_replace("{addClasses}", " ".$this->addClasses, $code);
		
		return $code;
	}
}
?>