<?php

/**
 * The FormElement class is for all elements inside a form, just the descriptions are no subclasses of FormElement.
 * 
 * @author Ralph Küpper
 */
abstract class FormElement {
	/** The type of form element. */
	public $type;
	/** The name of this element. */
	public $name;
	/** The value of this element. */
	public $value;
	/** Do we have a description? */
	public $description;
	/** The different types. */
	public static $TYPE_SELECT = 1;
	public static $TYPE_INPUT_TEXT = 2;
	public static $TYPE_INPUT_PASSWORD = 3;
	public static $TYPE_INPUT_CHECKBOX = 4;
	public static $TYPE_TEXTAREA = 5;
	public static $TYPE_OPTION = 6;
	public static $TYPE_SUBMIT = 7;
	public static $TYPE_HIDDEN = 8;
    public static $TYPE_INPUT_FILE = 9;
	
	public $visible = true;
	
	private $wrongValues = false;
	public $msg;
	
	
	private $complete;
	public $mustHave;
	
	/**
	 * Creates a new FormElemnt.
	 * @param string $name
	 * @param string $value [optional]
	 * @param Description $description [optional]
	 * @return 
	 */
	public function __construct($name, $value = "", $description = false, $msg = "", $mustHave = false) {
		$this->name = $name;
		$this->value = $value;
		$this->complete = false;
		$this->mustHave = $mustHave;
		$this->description = $description;
		$this->msg = $msg;
		$this->visible = true;
		
		if ($this->description)
			$this->description->setFormElement($this);
	}
	
	public function isComplete()
	{
		if ($this->mustHave == true)
		{
			if ($this->value != "")
			{
				return true;
			}
			return false;
		}
		return true;
	}
	/**
	 * The abstract function to render the content.
	 * @return 
	 */
	public abstract function render();
	
	public function setMessage($msg)
	{
		$this->msg = $msg;
	}
	
	public function setValue($v)
	{
		$this->value = $v;
	}
	
	public function setWrong()
	{
		$this->wrongValues = true;
	}
	
	public function isWrong()
	{
		return $this->wrongValues;
	}
}
?>