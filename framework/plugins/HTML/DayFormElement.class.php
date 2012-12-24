<?php

/**
 * A select field in a form. Options are in the class 'Option'. 
 * 
 * @author Ralph Küpper
 */
class DayFormElement extends FormElement {
	/** The options. */
	public $options;
	/** The index of the current option. */
	public $selectedOption;
	/** The static template. You can change it. */
	public static $TEMPLATE = '<select class="days" name="{name}day">{optionsDays}</select> <select onchange="changeDays(this);" name="{name}month">{optionsMonths}</select> <select name="{name}year">{optionsYears}</select>{msg}';
	
	public $day = 0;
	public $month = 0;
	public $year = 0;
	
	/**
	 * Creates a new select field.
	 * @param string $name
	 * @param string $value
	 * @param Description $description [optional]
	 */
	public function __construct($name, $day = 0, $month = 0, $year = 0, $description = null, $msg = "") {
		$this->name = $name;
		$this->day = $day;
		$this->month = $month;
		$this->year = $year;
		$this->description = $description;
		$this->msg = $msg;
		
		if ($this->description)
			$this->description->setFormElement($this);
			
		$this->type = FormElement::$TYPE_SELECT;
	}
	
	/**
	 * Renders the element with all its options.
	 */
	public function render() {
		$tpl = DayFormElement::$TEMPLATE;
		
		$daysOptions = array(
		new OptionFormElement(Lang::getString("day"),""),
		new OptionFormElement("1.",1),
		new OptionFormElement("2.",2),
		new OptionFormElement("3.",3),
		new OptionFormElement("4.",4),
		new OptionFormElement("5.",5),
		new OptionFormElement("6.",6),
		new OptionFormElement("7.",7),
		new OptionFormElement("8.",8),
		new OptionFormElement("9.",9),
		new OptionFormElement("10.",10),
		new OptionFormElement("11.",11),
		new OptionFormElement("12.",12),
		new OptionFormElement("13.",13),
		new OptionFormElement("14.",14),
		new OptionFormElement("15.",15),
		new OptionFormElement("16.",16),
		new OptionFormElement("17.",17),
		new OptionFormElement("18.",18),
		new OptionFormElement("19.",19),
		new OptionFormElement("20.",20),
		new OptionFormElement("21.",21),
		new OptionFormElement("22.",22),
		new OptionFormElement("23.",23),
		new OptionFormElement("24.",24),
		new OptionFormElement("25.",25),
		new OptionFormElement("26.",26),
		new OptionFormElement("27.",27),
		new OptionFormElement("28.",28),
		new OptionFormElement("29.",29),
		new OptionFormElement("30.",30),
		new OptionFormElement("31.",31));
		
		$monthsOptions = array(
		new OptionFormElement(Lang::getString("month"),""),
		new OptionFormElement(Lang::getString("month.january"),1),
		new OptionFormElement(Lang::getString("month.february"),2),
		new OptionFormElement(Lang::getString("month.march"),3),
		new OptionFormElement(Lang::getString("month.april"),4),
		new OptionFormElement(Lang::getString("month.may"),5),
		new OptionFormElement(Lang::getString("month.june"),6),
		new OptionFormElement(Lang::getString("month.july"),7),
		new OptionFormElement(Lang::getString("month.august"),8),
		new OptionFormElement(Lang::getString("month.september"),9),
		new OptionFormElement(Lang::getString("month.october"),10),
		new OptionFormElement(Lang::getString("month.november"),11),
		new OptionFormElement(Lang::getString("month.december"),12));
		
		$yearsOptions = array();
		$yearsOptions[] = new OptionFormElement(Lang::getString("year"),"");
		
		for ($a = (date("Y")+15); $a > 1950; $a--)
		{
			$yearsOptions[] = new OptionFormElement($a, $a);
		}
		
		$days = "";
		foreach ($daysOptions as $option)
		{
			if ($this->day == $option->value) $option->select();
			$days .= $option->render();
		}
		$months = "";
		foreach ($monthsOptions as $option)
		{
			if ($this->month == $option->value) $option->select();
			$months .= $option->render();
		}
		$years = "";
		foreach ($yearsOptions as $option)
		{
			if ($this->year == $option->value) $option->select();
			$years .= $option->render();
		}
		
		$tpl = str_replace("{optionsDays}",$days, $tpl);
		$tpl = str_replace("{optionsMonths}",$months, $tpl);
		$tpl = str_replace("{optionsYears}",$years, $tpl);
		
		$msg = "";
		if ($this->msg != "")
		{
			$msg = "<div class=\"msg\">".$this->msg."</div>";
		}
		$tpl = str_replace("{msg}", $msg,$tpl);
		$tpl = str_replace("{name}", $this->name,$tpl);
		return $tpl;
		
		
	}
	
}
?>