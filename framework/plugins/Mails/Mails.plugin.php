<?php
/**
 * Mail Plugin.
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
 
 $emailerv = array();

class Mails extends Plugin
{
	public function init()
	{
		include(FRAMEWORK_BASE."plugins/Mails/SMTP.class.php");
	}
	
	public static function sendEMail($to, $subject, $body, $isHTML = false, $from_show = "", $from = "", $user = "", $password = "") {
	
		if (Config::getConfig("log_mails") == "true")
		{
			$insertQuery = new DBQuery("INSERT INTO `mails` (`email`, `text`, `time`, `title`) VALUES('".mysql_escape_string($to)."', '".mysql_escape_string($body)."', '".time()."', '".mysql_escape_string($subject)."')");
		}
		
		global $emailerv;
		
		if ($user == "") $user = Config::getConfig("smtp_user");
		if ($password == "") $password = Config::getConfig("smtp_password");
		if ($from_show == "") $from_show = Config::getConfig("smtp_sender");
		$from = $from_show;
		
		
		if(is_null($emailerv[smtp])) {
		
			$emailerv[smtp] = new SMTP();
			$smtp->do_debug = 10;
		}
		$smtp = $emailerv[smtp];
		if($emailerv[user]!=$user||$emailerv[pass]!=$password) if($smtp->Connected()) $smtp->Close();
		
		if(!$smtp->Connected()){
			if(!$smtp->Connect(Config::getConfig("smtp_host"))) {
				die("Could not connect to SMTP server");
				return false;
			} else {
				
				if($smtp->Authenticate($user,$password)) {
					$emailerv[user] = $user;
					$emailerv[pass] = $password;
				}else {
					
					return false;
				}
			}
		}
		
		if ($isHTML == false) $body = nl2br($body);
		
		// RDe32fdw354s3423fwwwcvyD

		$data = "Date: ".date("D, j M Y H:i:s O")."\r\n".
		"Subject: $subject\r\n".
		"From: ".$from_show."\r\n".
		"Replay-To: ".$from_show."\r\n".
		"To: ".$to."\r\n".
		"MIME-Version: 1.0\r\n".
		"Content-Type: text/html\r\n".
		"Content-Transfer-Encoding: quoted-printable\r\n".
		"\r\n";
		$data .= EncodeQP(''.($body).'');
		//$data .= EncodeQP($body);
		$smtp->Mail($from);
		if(is_array($to)) foreach($to as $rcpt) $smtp->Recipient($rcpt);
		else $smtp->Recipient($to);
		
		return $smtp->Data($data);
	}
	
	public static function sendPureEMail($to, $subject, $message, $data) {
	
		
		if (Config::getConfig("log_mails") == "true")
		{
			$insertQuery = new DBQuery("INSERT INTO `mails` (`email`, `text`, `time`, `title`) VALUES('".mysql_escape_string($to)."', '".mysql_escape_string($body)."', '".time()."', '".mysql_escape_string($subject)."')");
		}
		
		global $emailerv;
		
		if ($user == "") $user = Config::getConfig("smtp_user");
		if ($password == "") $password = Config::getConfig("smtp_password");
		if ($from_show == "") $from_show = Config::getConfig("smtp_sender");
		$from = $from_show;
		
		
		if(is_null($emailerv[smtp])) {
		
			$emailerv[smtp] = new SMTP();
			$smtp->do_debug = 10;
		}
		$smtp = $emailerv[smtp];
		if($emailerv[user]!=$user||$emailerv[pass]!=$password) if($smtp->Connected()) $smtp->Close();
		
		if(!$smtp->Connected()){
			if(!$smtp->Connect(Config::getConfig("smtp_host"))) {
				die("Could not connect to SMTP server");
				return false;
			} else {
				
				if($smtp->Authenticate($user,$password)) {
					$emailerv[user] = $user;
					$emailerv[pass] = $password;
				}else {
					
					return false;
				}
			}
		}
		
		
		// RDe32fdw354s3423fwwwcvyD

		
		$data .= EncodeQP(''.($message).'');
		//$data .= EncodeQP($body);
		$smtp->Mail($from);
		if(is_array($to)) foreach($to as $rcpt) $smtp->Recipient($rcpt);
		else $smtp->Recipient($to);
		
		return $smtp->Data($data);
	}
	
	public function execute()
	{
		
	}
}
