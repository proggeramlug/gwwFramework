<?php

/**
 * Creates a new form.
 * 
 * e.g.
 * $form = new Form('myForm'); // template is fine
 * $textInput = new TextFormElement('text','value',new Description('here is a description'));
 * $form->addElement($textInput);
 * 
 * 
 * @author Ralph Küpper
 */
class Form extends Output {
	/** All elements in this form. */
	public $elements;
	/** Are the descriptions shown? */
	public $showDescriptions;
	/** The template. */
	public $template;
	
	public $url;
	
	public $jsAction;
	
	public $encType = "";
	
	// for auto management
	private $core; 
	private $autoManagement;
	private $formComplete;
	
	private $showErrors = true;
	
	/**
	 * Creates a new form.
	 * @param string $name
	 * @param string $template [optional]
	 * @return 
	 */
	public function __construct($name, $url, $template = "")
	{
		if ($template == "") $this->template = '<div {v}class="formRow{addClasses}">{description}<div class="input {inputName}">{input}</div></div>';
		else $this->template = $template;
		
		$this->url = $url;
		
		$this->name = $name;
		$this->elements = array();
		// normaly we want to see descriptions (if set)
		$this->showDescriptions = true;
	}
	
	public function startAutoManagement(Core $core)
	{
		$this->core = $core;
		$this->autoManagement = true;
	}
	
	public function hideErrors()
	{
		$this->showErrors = false;
	}
	
	public function isComplete()
	{
		if ($this->autoManagement == true)
		{
			
			$ready = true;
			$this->initValues();
			foreach ($this->elements as $element)
			{
				if ($element->isComplete() == false)
				{
					$ready = false;
					
				}
				
			}
			return $ready;
		}
		return false;
	}
	
	
	
	private function initValues()
	{
		
		if ($this->autoManagement == false)
		{
			return false;
		}
		
		foreach ($this->elements as $element)
		{
			$class = get_class($element);
			$postValue = $this->core->getPost($element->name)->value;
			if ($class == "TextFormElement" || $class == "TextAreaFormElement")
			{
				if ($postValue != "")
				{
					$element->setValue($postValue);
				}
				else {
					if ($this->showErrors && $element->mustHave == true) $element->setWrong();
				}
			}
			else if ($class == "PasswordFormElement")
			{
				if ($postValue != "")
				{
					$element->setValue($postValue);
				}
				else {
					if ($this->showErrors && $element->mustHave == true) $element->setWrong();
				}
			}
			else if ($class == "SelectFormElement")
			{
				if ($postValue > 0)
				{
					$element->setValue($postValue);
					$element->selectOption($postValue);
				}
				else {
					if ($this->showErrors && $element->mustHave == true) $element->setWrong();
				}
			}
			else if ($class == "BirthdayFormElement")
			{
				$day = $this->core->getPost($element->name."_day")->value;
				$month = $this->core->getPost($element->name."_month")->value;
				$year = $this->core->getPost($element->name."_year")->value;
				
				$element->day = $day;
				$element->month = $month;
				$element->year = $year;
				
				$element->value = $element->getTimeStamp();
				
			}
		}
	}
	
	public function getAllValuesAndKeys()
	{
		$vAk = array();
		foreach ($this->elements as $element)
		{
			$this->initValues();
			$vAk[$element->name] = $element->value;
		}
		return $vAk;
	}
	
	public function getElementByName($name)
	{
		foreach ($this->elements as $element)
		{
			if ($element->name == $name)
			{
				return $element;
			}
		}
		return null;
	}
	
	/**
	 * Adds an element to the from.
	 * @param FormElement $e
	 */
	public function addElement($e) {
		$this->elements[] = $e;
	}
	/**
	 * Returns the complete output of this form.
	 * @param string $mode [optional]
	 * @param Core $core [optional]
	 * @return string
	 */
	public function render($mode = "html", $core = null) {
		$output = "<form ".($this->encType!=""?"enctype=\"".$this->encType."\" ":"")."action=\"".$this->url."\" method=\"post\" autocomplete=\"off\" onsubmit=\"".$this->jsAction."\">";
		$second = true;
		
		foreach ($this->elements as $element) {
			$description = "";
			
			if ($this->autoManagement == true)
			{
				$class = get_class($element);
				$postValue = $this->core->getPost($element->name) ? $this->core->getPost($element->name)->value : '';

				if ( $class == "TextFormElement" || $class == "TextAreaFormElement" )
				{
					if ( $postValue != "" )
					{
						$element->setValue($postValue);
						
					}
				}
				else if ($class == "SelectFormElement")
				{
					if ($postValue > 0) $element->selectOption($postValue);
				}
			}
			
			if ($element->description != null) 
			{
				$description = $element->description->render();
			}
			$input = $element->render();
			
			$row = str_replace("{description}", $description, $this->template);
			$row = str_replace("{input}", $input, $row);
			
			$addClasses = "";
			
			
			if ($element->type == FormElement::$TYPE_SUBMIT)
			{
				$addClasses .=" formSubmit";
			}
			if ($second)
			{
				$addClasses .= " second";
			}
			if ($element->isWrong())
			{
				$addClasses .= " wrong";
				
			}

			$row = str_replace("{addClasses}", $addClasses, $row);
			$row = str_replace("{inputName}", $element->name, $row);
			
			$visible = $element->visible;
			
			if (!$visible)
			{
				$v = "style=\"display:none;\" id=\"row".$element->name."\" ";
			}
			else {
				$v = "id=\"row".$element->name."\" ";
			}
			
			$row = str_replace("{v}", $v, $row);
			
			
			if ($element->type != FormElement::$TYPE_HIDDEN) $output .= $row;
			else {
				$output .= $input;
				
			}
			$second = !$second;
		}
		
		$output .= "</form>";
		
		if ($mode == "html")
		{
			return $output;
		}
		else {
			$this->addJSONOutput("content", $output);
			return $this->getJSONOutput();
		}
	}
}
?>