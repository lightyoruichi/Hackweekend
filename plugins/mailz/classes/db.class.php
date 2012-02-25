<?php
/*  db.class.php
 Copyright 2008,2009 Erik Bogaerts
 Support site: http://www.zingiri.com

 This file is part of APhPS.

 APhPS is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 APhPS is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with APhPS; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
?>
<?php
if (!class_exists('db')) {
	class db {
		var $numrows;
		var $sql="";
		var $row;

		function select($query) {
			global $dbtablesprefix;
			$action="";
			$query=str_replace("##",$dbtablesprefix,$query);
			$this->sql = mysql_query($query) or die($this->error($query));
			$this->numrows=mysql_num_rows($this->sql);
			if ($this->numrows == 0) return false; else return $this->numrows;

		}

		function next() {
			if ($this->row=mysql_fetch_assoc($this->sql)) {
				return $this->row;
			} else { return false; }
		}

		function exists($table) {
			global $dbtablesprefix;
			$query="SELECT * FROM `".$dbtablesprefix.$table."`";
			if (mysql_query($query)) return true;
			else return false;
		}
		
		function fieldExists($table,$field) {
			global $dbtablesprefix;
			$query = "SHOW COLUMNS FROM `".$dbtablesprefix.$table."` ";
			if ($result=mysql_query($query)) {
				while ($row = mysql_fetch_row($result)) {
					if ($row[0]==$field || $row[0]==strtoupper($field) || $row[0]==strtolower($field)) return true;
				}
			}
			return false;
		}
			
		function allFields($table) {
			global $dbtablesprefix;
			$fields=array();
			$query = "SHOW COLUMNS FROM `".$dbtablesprefix.$table."` ";
			if ($result=mysql_query($query)) {
				while ($row = mysql_fetch_row($result)) {
					$fields[]=strtolower($row[0]);
				}
			}
			return $fields;
		}
		
		function update($query) {
			global $dbtablesprefix;
			$query=str_replace("##",$dbtablesprefix,$query);
			$sql = mysql_query($query) or die($this->error($query));
			return $sql;
		}

		function error($query) {
			$msg="Database Error:".$query."/".mysql_error();
			echo $msg;
			if (function_exists("zing_ws_error_handler")) zing_ws_error_handler(0,$msg);
			elseif (function_exists("zing_apps_error_handler")) zing_apps_error_handler(0,$msg);
			die();
		}

		function get($field) {
			if (!empty($this->row[$field])) return $this->row[$field];
			$field=strtolower($field);
			if (!empty($this->row[$field])) return $this->row[$field];
			$field=strtoupper($field);
			if (!empty($this->row[$field])) return $this->row[$field];
			return false;
		}

		function readRecord($table,$keys,$action="")
		{

			Global $dbtablesprefix;

			$query="SELECT * FROM `".$dbtablesprefix.$table."` ";
			$first=TRUE;
			foreach ($keys as $field => $val)
			{

				if ($first)	{ $query.="WHERE "; } else { $query.=" AND "; }
				$first=FALSE;
				$query.="`".$field."`=".qs($val);

			}

			//	echo $query."<br />";
			$sql = mysql_query($query) or die($this->error($query));
			$numrows=mysql_num_rows($sql);

			if ($numrows == 0) return false;

			$row=mysql_fetch_assoc($sql);
			return $row;
		}


		function updateRecord($table,$keys,$row,$action="")
		{

			Global $dbtablesprefix;

			$query="UPDATE `".$dbtablesprefix.$table."` ";
			$first=TRUE;
			foreach ($row as $field => $val)
			{
				$iskey=FALSE;
				foreach ($keys as $keyfield => $keyval)
				{
					if ($field == $keyfield) { $iskey=TRUE; }
				}
				if (!$iskey)
				{
					if ($first)	{ $query.="SET "; } else { $query.=","; }
					$first=FALSE;
					$query.="`".$field."`=".qs($val);
				}
			}
			$first=TRUE;
			foreach ($keys as $keyfield => $keyval)
			{
				if ($first){ $query.=" WHERE "; } else { $query.=" AND "; }
				$first=FALSE;
				$query.= "`".$keyfield."`=".qs($keyval);
			}


			//zing_ws_error_handler(0,$query);
				
			$sql_update = mysql_query($query) or die($this->error($query));
		}

		function insertRecord($table,$keys="",$row,$action="")
		{
			global $dbtablesprefix;

			$query="INSERT INTO `".$dbtablesprefix.$table."` ";
			$first=TRUE;
			foreach ($row as $field => $val)
			{
				$iskey=FALSE;
				if (!empty($keys))
				{
					foreach ($keys as $keyfield => $keyval)
					{
						if ($field == $keyfield) { $iskey=TRUE; }
					}
				}
				if (!$iskey)
				{
					if ($first)	{ $query.="("; } else { $query.=","; }
					$first=FALSE;
					$query.="`".$field."`";
				}
			}
			$query.=") VALUES ";
			$first=TRUE;
			foreach ($row as $field => $val)
			{
				$iskey=FALSE;
				if (!empty($keys))
				{
					foreach ($keys as $keyfield => $keyval)
					{
						if ($field == $keyfield) { $iskey=TRUE; }
					}
				}
				if (!$iskey)
				{
					if ($first)	{ $query.="("; } else { $query.=","; }
					$first=FALSE;
					$query.=qs($val);
				}
			}
			$query.=")";
				//echo $query."<br />";
			$sql_insert = mysql_query($query) or die($this->error($query));
			$id = mysql_insert_id();

			return $id;
		}

		function deleteRecord($table,$keys,$action="")
		{
			Global $dbtablesprefix;

			$query="DELETE FROM `".$dbtablesprefix.$table."` ";
			$first=TRUE;
			foreach ($keys as $field => $val)
			{
				if ($first)	{ $query.="WHERE "; } else { $query.=" AND "; }
				$first=FALSE;
				$query.="`".$field."`=".qs($val);
			}

			//	echo $query."<br />";
			$sql = mysql_query($query) or die($this->dbError(1,$query,"",$action));
		}

		function txbegin()
		{
			Global $txglobal;

			$txglobal=TRUE;
			$query="START TRANSACTION";
			$sql=mysql_query($query) or die($this->error($query));
		}

		function txcommit()
		{
			Global $txglobal;

			if ($txglobal)
			{
				$query="COMMIT";
				$sql=mysql_query($query) or die($this->error($query));
			}
			$txglobal=FALSE;
		}

		function txrollback()
		{
			Global $txglobal;

			if ($txglobal)
			{
				$query="ROLLBACK";
				$sql=mysql_query($query) or die($this->error($query));
			}
			$txglobal=FALSE;
		}

		function dbError($severity, $query, $page, $action)
		{
			Global $gfx_dir;
			Global $txt;
			Global $dbError;
			Global $channel;
			Global $error;
			Global $errormsg;

			$dbError=1;
			$sql=mysql_error();

			$this->txrollback();

			echo "ERROR:".$severity."-".$query."-".$sql;

		}
	}
}
?>