<?php
/**
 * Little helper class which predefines class based on sql-tables.
 * 
 * @author Ralph Küpper
 * 
 *  This script is part of the gwwFramework. Developed and produced by Skelpo - hot software.
 *  If you have any questions, recommendations or general requests visit our website
 *  http://www.skelpo.com or write an email to info@skelpo.com
 * 
 *  Copyright (C) 2012  Skelpo
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * */
 
 
class ModelCreator 
{
	public function __construct()
	{
		
	}
	
	public function createModel($tableName, $writeTo = "")
	{
		$query = new DBQuery("SHOW COLUMNS FROM `".$tableName." ");
		
		$vars = "";
		
		while ($field = $query->getNextArray())
		{
			$vars.="	public \$".$field['Field'].";\n";
		}
		
		$code = "<?php

class ".ucwords($tableName)." extends Model
{
".$vars."
	
	public function __construct(\$data = \"\")
	{
		\$this->tableName = \"".$tableName."\";
		
		if (is_array(\$data))
		{
			\$this->init(\$data);
			
			if (!is_numeric(\$this->id))
			{
				\$this->create();
			}
		}
		else if (is_numeric(\$data))
		{
			\$this->load(\"id\",\$data);
		}
	}
}";
	
	if ($writeTo!="")
	{
		$f = fopen($writeTo.ucwords($tableName).".class.php","w");
		fwrite($f,$code);
		fclose($f);
	}
	return $code;
	}
}
