<?php
/**
 * MySQLConnection class
 * 
 * A mysql connection is a connection and a pot of querys to this connection.
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

class MySQLConnection 
{
	private $host;
	private $db;
	private $user;
	private $password;
	
	private $connection;
	public $queries;
	
	public static $MAIN_CONNECTION = false;
	
	public function __construct($host, $user, $password, $db)
	{
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->db = $db;
		
		Logger::log("Creating mysql connection on $host");
		
		$this->connect();
	}
	
	public function connect()
	{
		$this->connection = @mysql_pconnect($this->host, $this->user, $this->password);
		if (!$this->connection)
		{
			Logger::log("Error while connection. Check it please.","error");
			return false;
		}
		if (!mysql_select_db($this->db, $this->connection))
		{
			Logger::log("Error while selecting db: ".mysql_error($this->connection),"error");
			return false;
		}
		mysql_query("SET NAMES 'utf8'", $this->connection);
		
		if (mysql_error($this->connection)!="")
		{
			Logger::log("Error while connection: ".mysql_error($this->connection),"error");
			return false;
		}
		return true;
	}
	
	public function __destruct()
	{
		if ($this->connection)
		{
			mysql_close($this->connection);
		}
	}
	
	public function getConnection()
	{
		return $this->connection;
	}
	
	public function disconnect()
	{
		mysql_close($this->connection);
	}
	
	public static function getMainConnection()
	{
		if (MySQLConnection::$MAIN_CONNECTION == false)
		{
			MySQLConnection::$MAIN_CONNECTION = new MySQLConnection(Config::getConfig("mysql_host"), Config::getConfig("mysql_user"), Config::getConfig("mysql_password"), Config::getConfig("mysql_db"));
		}
		return MySQLConnection::$MAIN_CONNECTION;
	}
}
