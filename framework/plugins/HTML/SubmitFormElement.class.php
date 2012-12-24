<?php

/**
 * A text field in a form. 
 * 
 * @author Ralph Küpper
 */
class SubmitFormElement extends FormElement {
	/** The normal static template. You can change it. */
	public static $TEMPLATE = '<input type="submit" name="{name}" value="{value}" />';
	/**
	 * Creates a new text element.
	 * @param string $name
	 * @param string $value
	 */
	public function __construct($name, $value, $description = null) {
		$this->name = $name;
		$this->value = $value;
		$this->description = $description;
		
		$this->type = FormElement::$TYPE_SUBMIT;
		if ($this->description)
			$this->description->setFormElement($this);
	}
	
	public function render() {
		$tpl = str_replace("{name}", $this->name, SubmitFormElement::$TEMPLATE);
		$tpl = str_replace("{value}", $this->value, $tpl);
		return $tpl;
	}
}
?>