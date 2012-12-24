<?php

/**
 * A text field in a form. 
 * 
 * @author Ralph Küpper
 */
class CheckboxFormElement extends FormElement {
	/** The normal static template. You can change it. */
	public static $TEMPLATE = '<input type="checkbox" name="{name}" value="{value}"{checked} /> {msg}';
	
	public $checked;
	/**
	 * Creates a new text element.
	 * @param string $name
	 * @param string $value
	 * @param Description $description [optional]
	 */
	public function __construct($name, $value, $description = null, $msg = "") {
		$this->name = $name;
		$this->value = $value;		
		$this->description = $description;
		$this->type = FormElement::$TYPE_INPUT_TEXT;
		$this->msg = $msg;
		//$this->checked = false;
		$this->setChecked(false);
		if ($this->description)
			$this->description->setFormElement($this);
	}
	
	public function setChecked($c)
	{
		$this->checked = $c;
	}
	
	public function render() {
		$tpl = str_replace("{name}", $this->name, CheckboxFormElement::$TEMPLATE);
		$tpl = str_replace("{value}", $this->value, $tpl);
		
		$c = "";
		
		if ($this->checked) $c = " checked=\"checked\"";
		
		$tpl = str_replace("{checked}", $c, $tpl);
	
		$msg = "";
		if ($this->msg != "")
		{
			$msg = " ".$this->msg."";
		}
		
		$tpl = str_replace("{msg}", $msg,$tpl);
		return $tpl;
	}
}
?>