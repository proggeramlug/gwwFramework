<?php

/**
 * A password field in a form. Nearly the same to a text field.
 * 
 * @author Ralph Küpper
 */
class PasswordFormElement extends FormElement {
	/** The static template. You can chane it. */
	public static $TEMPLATE = '<input type="password" name="{name}" value="{value}" />{msg}';
	/**
	 * Creates a new password field.
	 * @param string $name
	 * @param string $value
	 * @param Description $description [optional]
	 * @return 
	 */
	public function __construct($name, $value, $description = null,$msg = "", $mustHave = false) {
		$this->name = $name;
		$this->mustHave = $mustHave;
		$this->value = $value;
		$this->msg = $msg;
		
		$this->description = $description;
		if ($this->description)
			$this->description->setFormElement($this);
			
		$this->type = FormElement::$TYPE_INPUT_PASSWORD;
	}
	/**
	 * Renders the content of this password field.
	 */
	public function render() {
		$tpl = str_replace("{name}", $this->name, PasswordFormElement::$TEMPLATE);
		$tpl = str_replace("{value}", $this->value, $tpl);
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