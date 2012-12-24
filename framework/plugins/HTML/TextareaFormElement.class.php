<?php

/**
 * A text field in a form. 
 * 
 * @author Ralph Küpper
 */
class TextAreaFormElement extends FormElement {
	public $class;
	public $additionalAttributes = array();
	/** The normal static template. You can change it. */
	public static $TEMPLATE = '<textarea {add}name="{name}"{additionalAttributes}>{value}</textarea>{msg}';
	/**
	 * Creates a new text element.
	 * @param string $name
	 * @param string $value
	 * @param Description $description [optional]
	 */
	public function __construct($name, $value, $description = false, $msg = "", $mustHave = false, $additionalAttributes = false) {
		$this->name = $name;
		$this->value = $value;
		$this->description = $description;
		$this->mustHave = $mustHave;
		$this->type = FormElement::$TYPE_TEXTAREA;
		$this->msg = $msg;

		if ($this->description)
		{
			$this->description->setFormElement($this);
		}

		if (is_array($additionalAttributes))
		{
			foreach ($additionalAttributes as $name=>$value)
			{
				$this->additionalAttributes[$name] = $value;
			}
		}
	}
	
	public function render() {
		$tpl = str_replace("{name}", $this->name, TextareaFormElement::$TEMPLATE);
		$tpl = str_replace("{add}", ($this->class!=""?"class=\"".$this->class."\" ":""), $tpl);
		$tpl = str_replace("{value}", $this->value, $tpl);
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