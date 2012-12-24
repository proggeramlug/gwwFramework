<?php

/**
 * A select field in a form. Options are in the class 'Option'. 
 * 
 * @author Ralph Küpper
 */
class SelectFormElement extends FormElement {
	/** The options. */
	public $options;
	/** The index of the current option. */
	public $selectedOption;
	public $actions;
	/** The static template. You can change it. */
	public static $TEMPLATE = '<select {actions}name="{name}">{options}</select>{msg}';
	/**
	 * Creates a new select field.
	 * @param string $name
	 * @param string $value
	 * @param Description $description [optional]
	 */
	public function __construct($name, $value, $description = null, $msg = "", $actions = "", $options = "") {
		$this->name = $name;
		$this->value = $value;
		$this->description = $description;
		$this->actions = $actions;
		$this->msg = $msg;
		
		if ($this->description)
			$this->description->setFormElement($this);
			
		if (is_array($options))
		{
			$this->options = $options;
		}
			
		$this->type = FormElement::$TYPE_SELECT;
	}
	public function selectOption($value)
	{
		$this->selectedOption = $value;
	}
	/**
	 * Adds an option to the field.
	 * @param OptionFormElement $o
	 */
	public function addOption(OptionFormElement $o) {
		$this->options[] = $o;
	}
	/**
	 * Renders the element with all its options.
	 */
	public function render() {
		$tpl = SelectFormElement::$TEMPLATE;
		
		$tpl = str_replace("{name}",$this->name, $tpl);
		
		$optionsCode = "";
		
		foreach ( $this->options as $option ) {
			if ($this->selectedOption == $option->value) $option->select();
			$optionsCode .= $option->render();
		}
		
		$tpl = str_replace("{options}", $optionsCode, $tpl);
		$tpl = str_replace("{actions}", $this->actions, $tpl);
		
		
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