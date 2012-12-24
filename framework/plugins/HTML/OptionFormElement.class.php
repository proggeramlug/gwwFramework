<?php


class OptionFormElement extends FormElement {
	public $title;
	public $value;
	
	private $selected;
	
	public static $TEMPLATE = '<option value="{value}"{selected}>{title}</option>';
	
	public function __construct($title, $value) {
		$this->title = $title;
		$this->value = $value;
		$this->type = FormElement::$TYPE_OPTION;
		$this->selected = false;
	}
	
	public function select()
	{
		$this->selected = true;
	}
	
	public function render() {
		$tpl = OptionFormElement::$TEMPLATE;
		
		$tpl = str_replace("{value}", $this->value, $tpl);
		$tpl = str_replace("{title}", $this->title, $tpl);
		
		$select = "";
		
		if ($this->selected)
		{
			$select = " selected=\"selected\"";
		}
		
		
		$tpl = str_replace("{selected}", $select, $tpl);
		
		return $tpl;
	}
}
?>