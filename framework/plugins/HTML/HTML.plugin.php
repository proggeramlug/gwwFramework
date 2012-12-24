<?php

class HTML extends Plugin
{
	
	public function init()
	{
		include(FRAMEWORK_BASE."plugins/HTML/Headline.class.php");
		include(FRAMEWORK_BASE."plugins/HTML/ContentBox.class.php");
		include(FRAMEWORK_BASE."plugins/HTML/MenuEntry.class.php");
		include(FRAMEWORK_BASE."plugins/HTML/Menu.class.php");
		include(FRAMEWORK_BASE."plugins/HTML/Form.class.php");
		include(FRAMEWORK_BASE."plugins/HTML/FormElement.class.php");
		include(FRAMEWORK_BASE."plugins/HTML/Description.class.php");
		include(FRAMEWORK_BASE."plugins/HTML/OptionFormElement.class.php");
		include(FRAMEWORK_BASE."plugins/HTML/PasswordFormElement.class.php");
		include(FRAMEWORK_BASE."plugins/HTML/SelectFormElement.class.php");
		include(FRAMEWORK_BASE."plugins/HTML/TextFormElement.class.php");
		include(FRAMEWORK_BASE."plugins/HTML/SubmitFormElement.class.php");
		include(FRAMEWORK_BASE."plugins/HTML/BirthdayFormElement.class.php");
		include(FRAMEWORK_BASE."plugins/HTML/CheckboxFormElement.class.php");
		include(FRAMEWORK_BASE."plugins/HTML/TextareaFormElement.class.php");
		include(FRAMEWORK_BASE."plugins/HTML/TownFormElement.class.php");
		include(FRAMEWORK_BASE."plugins/HTML/HiddenFormElement.class.php");
		include(FRAMEWORK_BASE."plugins/HTML/DayFormElement.class.php");
		include(FRAMEWORK_BASE."plugins/HTML/FileFormElement.class.php");
		
	}
	
	public function execute()
	{
		
	}
}
?>
