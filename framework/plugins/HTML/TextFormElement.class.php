<?php

/**
 * A text field in a form. 
 * 
 * @author Ralph Küpper
 */
class TextFormElement extends FormElement {
	public $class = "";
	public $additionalAttributes = array();
	public $enabled = true;
	/** The normal static template. You can change it. */
	public static $TEMPLATE = '<input {add}type="text" name="{name}" value="{value}"{additionalAttributes} />{msg}';
	public static $TEMPLATE_NOT_EDITABLE = '<span style="margin-top:3px;line-height:18px;">{value} </span>{msg}';
	/**
	 * Creates a new text element.
	 * @param string $name
	 * @param string $value
	 * @param Description $description [optional]
	 */

	 public function disable()
	 {
	 	$this->enabled = false;
	 }
	 
	public function __construct($name, $value, $description = false, $msg = "", $mustHave = false, $additionalAttributes = false) {
		$this->name = $name;
		$this->value = $value;
		$this->mustHave = $mustHave;
		$this->description = $description;
		$this->type = FormElement::$TYPE_INPUT_TEXT;
		$this->msg = $msg;
		if ($this->description)
			$this->description->setFormElement($this);
		
		if (is_array($additionalAttributes))
		{
			foreach ($additionalAttributes as $name=>$value)
			{
				$this->additionalAttributes[$name] = $value;
			}
		}
	}
	
	public function render() {
		if ($this->enabled) $tpl = str_replace("{name}", $this->name, TextFormElement::$TEMPLATE);
		else $tpl = str_replace("{name}", $this->name, TextFormElement::$TEMPLATE_NOT_EDITABLE);
		$tpl = str_replace("{add}", ($this->class!=""?"class=\"".$this->class."\" ":""), $tpl);
		$tpl = str_replace("{value}", (htmlentities(utf8_decode($this->value))), $tpl);
		$msg = "";
		if ($this->msg != "")
		{
			$msg = "<div class=\"msg\">".$this->msg."</div>";
		}
		
		$additionalAttributes = "";
		
		foreach ($this->additionalAttributes as $name=>$value)
		{
			$additionalAttributes .= " ".$name."=\"".$value."\"";
		}
		$tpl = str_replace("{additionalAttributes}", $additionalAttributes, $tpl);
		$tpl = str_replace("{msg}", $msg,$tpl);
		return $tpl;
	}
}
?>