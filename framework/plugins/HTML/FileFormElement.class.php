<?php

/**
 * A text field in a form. 
 * 
 * @author Ralph Küpper &
 */
class FileFormElement extends FormElement {
	/** The normal static template. You can change it. */
	public static $TEMPLATE = '<input type="file" name="{name}" value="{value}" />{msg}';
	/**
	 * Creates a new file element.
	 * @param string $name
	 * @param string $value
	 * @param Description $description [optional]
	 */
	public function __construct($name, $value, $description = false, $msg = "", $mustHave = false) {
		$this->name = $name;
		$this->value = $value;
		$this->mustHave = $mustHave;
		$this->description = $description;
		$this->type = FormElement::$TYPE_INPUT_FILE;
		$this->msg = $msg;
		if ($this->description)
			$this->description->setFormElement($this);
	}
	
	public function render() {
		$tpl = str_replace("{name}", $this->name, FileFormElement::$TEMPLATE);
		$tpl = str_replace("{value}", (htmlentities(utf8_decode($this->value))), $tpl);
		$msg = "";
		if ($this->msg != "")
		{
			$msg = "<div class=\"msg\">".$this->msg."</div>";
		}
		
		$tpl = str_replace("{msg}", $msg,$tpl);
		return $tpl;
	}
}
?>