<?php

class Menu extends Output
{
	public $name;
	public $entrys;
	public $id;
	
	public static $ENTRY_TEMPLATE = "<li{last}><a {onclick}href=\"{target}\">{title}</a>{add}</li>\n";
	public static $MENU_TEMPLATE = "<ul {id}class=\"{name}\">{menu}</ul>\n";
	
	public function __construct($name)
	{
		$this->name = $name;
		$this->entrys = array();
	}
	
	public function addEntry($entry)
	{
		$this->entrys[] = $entry;
	}
	
	public function render($mode = "html", $core = null)
	{
		$menu = "";
		$num = count($this->entrys);
		$count = 0;
		foreach ($this->entrys as $entry)
		{
			$classes = "";
			$last = "";
			if (($num-1) == $count) $classes .= "last ";
			if ($entry->extraClasses != "") $classes .= $entry->extraClasses;
			if ($classes != "") $last = " class=\"".$classes."\"";
			$add = "";
			if ($entry->subMenu)
			{
				$add = $entry->subMenu->render($mode, $core);
			}
			
			$entryString = str_replace("{target}", $entry->target, Menu::$ENTRY_TEMPLATE);
			$entryString = str_replace("{title}", $entry->title, $entryString);
			$entryString = str_replace("{last}", $last, $entryString);
			$entryString = str_replace("{add}", $add, $entryString);
			$entryString = str_replace("{onclick}", $entry->onclick!=""?("onclick=\"".$entry->onclick."\" "):"", $entryString);
			$menu .= $entryString;
			
			
			
			$count++;
		}
		
		
		$output = str_replace("{id}", $this->id!=""?("id=\"".$this->id."\" "):"", str_replace("{name}", $this->name, str_replace("{menu}", $menu, Menu::$MENU_TEMPLATE)));
		
		return $output;
	}
}

?>
