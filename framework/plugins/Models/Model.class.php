<?php
/**
 * Model class for fast an easy interacting with the database.
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
 
 
abstract class Model {
	public $id;
	protected $tableName;
	
	protected $notToSaveElements = array('tableName', 'id');
	
	public function init($data)
	{
		if (is_array($data))
		{
			foreach($data as $key=>$value)
		
			{
				$this->$key = stripslashes($value);
			}
		}
		
	}
	public function getTableName()
	{
		return $this->tableName;
	}
	protected function save()
	{
		$tableName = $this->tableName;
		$vars = get_class_vars(get_class($this));
		$sql = "UPDATE `".$tableName."` SET ";
		$values = "";
		foreach ($vars as $key=>$value)
		{
			if (!in_array($key,$this->notToSaveElements) && (is_numeric($this->$key) || is_string($this->$key)))
			{
				$sql.= "`".$key."` = '".mysql_escape_string($this->$key)."',";
				
			}
		}
		$sql = substr($sql,0,strlen($sql)-1)." WHERE `id` = '".$this->id."'";
		
		$createSql = new DBQuery($sql);
	}
	protected function load($key, $value)
	{
		$loadQuery = new DBQuery("SELECT * FROM `".$this->tableName."` WHERE `".mysql_escape_string($key)."` = '".mysql_escape_string($value)."'");
		$data = $loadQuery->getNextArray();
		
		$this->init($data);
		
	}
	protected function create()
	{
		$tableName = $this->tableName;
		$vars = get_class_vars(get_class($this));
			
		$sql = "INSERT INTO `".$tableName."` (";
		$values = "";
		foreach ($vars as $key=>$value)
		{
			if (!in_array($key,$this->notToSaveElements) && (is_numeric($this->$key) || is_string($this->$key)))
			{
				$sql.= "`".$key."`,";
				$values .= "'".mysql_escape_string($this->$key)."',";
			}
		}
		$sql = substr($sql,0,strlen($sql)-1).") VALUES(";
		$sql .= substr($values,0,strlen($values)-1).")";
		$createSql = new DBQuery($sql);
		$this->id = $createSql->getInsertId();
	}
}
?>