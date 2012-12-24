<?php

/**
 * A text field in a form. 
 * 
 * @author Ralph Küpper
 */
class HiddenFormElement extends FormElement {
	/** The normal static template. You can change it. */
	public static $TEMPLATE = '<input type="hidden" name="{name}" value="{value}" />';
	/**
	 * Creates a new text element.
	 * @param string $name
	 * @param string $value
	 * @param Description $description [optional]
	 */
	public function __construct($name, $value) {
		$this->name = $name;
		$this->value = $value;
		$this->type = FormElement::$TYPE_HIDDEN;
		
	}
	
	public function render() {
		$tpl = str_replace("{name}", $this->name, HiddenFormElement::$TEMPLATE);
		$tpl = str_replace("{value}", (htmlentities(utf8_decode($this->value))), $tpl);
	
		return $tpl;
	}
}
?>