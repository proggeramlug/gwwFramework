<?php

/**
 * A text field in a form. 
 * 
 * @author Ralph Küpper
 */
class TownFormElement extends FormElement {
	/** The normal static template. You can change it. */
	public static $TEMPLATE = '<input type="hidden" name="{name}" id="{name}_id_val" value="{locid}" /><input class="town" id="{name}_id" type="text" name="{name}_text" value="{value}" />{msg}';
	public $locid;
	/**
	 * Creates a new text element.
	 * @param string $name
	 * @param string $value
	 * @param Description $description [optional]
	 */
	public function __construct($name, $value, $locid = 0, $description = false, $msg = "") {
		$this->name = $name;
		$this->value = $value;
		$this->description = $description;
		$this->type = FormElement::$TYPE_INPUT_TEXT;
		$this->msg = $msg;
		$this->locid = $locid;
		if ($this->description)
			$this->description->setFormElement($this);
	}
	
	public function render() {
		$tpl = str_replace("{name}", $this->name, TownFormElement::$TEMPLATE);
		$tpl = str_replace("{value}", $this->value, $tpl);
		$tpl = str_replace("{locid}", $this->locid, $tpl);
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