<?php
/**
 * DBQuery class
 * 
 * This class is for one single query. We separate the querys because somethings it's neccessary 
 * to use more than one queries at one moment and then other concepts may produce some errors.
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

class DBQuery
{
	private $connection;
	private $queryString;
	private $affectedRows;
	private $result;
	
	public static $QUERIES;
	
	public function __construct($query, $connection = null, $sendATM = true)
	{
		if ($connection == null)
		{
			$this->connection = MySQLConnection::getMainConnection();
		}
		else {
			$this->connection = $connection;
		}
		$this->connection->queries++;
		
		
		$this->queryString = $query;
		
		if ($sendATM)
		{
			$this->send();
		}
	}
	
	public function send()
	{
		$this->result = mysql_query($this->queryString, $this->connection->getConnection());
		$this->affectedRows = mysql_affected_rows($this->connection->getConnection());
		
		if (mysql_error($this->connection->getConnection())!="")
		{
			Logger::log("Error during the query: ".mysql_error($this->connection->getConnection())."<br />".$this->queryString,"error");
			return false;
		}
		
		if (!DBQuery::$QUERIES)
		{
			DBQuery::$QUERIES = 0;
		}
		DBQuery::$QUERIES++;
		
		return true;
	}
	
	public function getResult($a,$b)
	{
		return mysql_result($this->result,$a,$b);
	}
	
	public function getInsertId()
	{
		return mysql_insert_id($this->connection->getConnection());
	}
	
	public function getNextArray($assoc = false)
	{
		if (!$assoc) return mysql_fetch_array($this->result);
		else return mysql_fetch_assoc($this->result);
	}
	
	public function getAllQueries($assoc = false)
	{
		$ret = array();
		while ($res = $this->getNextArray($assoc))
		{
			$ret[] = $res;
		}
		return $ret;
		
	}
	
	public function getAffectedRows()
	{
		return $this->affectedRows;
	}
}


?>
