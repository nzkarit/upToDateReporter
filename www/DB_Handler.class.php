<?php
/**
* This file is part of Up To Date Reporter.
*
* Up To Date Reporter is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Up To Date Reporter is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Up To Date Reporter.  If not, see <http://www.gnu.org/licenses/>.
*
* (c)Copyright 2014 David Robinson (copyright AT karit DOT geek DOT nz)
*/

require_once('Config.class.php');

class DB_Handler {

	/**
	* Some DB variables
	*/
    var $config = null;
    var $dbconfig = null;
    var $db = null;
    
    /**
	* The construtor whihc sets up the DB connection
	*/
	function DB_Queries() {
        
    }
    
  	/**
	* Make the DB connection
	*/
	function connectDB(){
	    $this->config = new Config();
        $this->dbconfig = $this->config->getDBConnectionVariables();
        $this->db = new mysqli($this->dbconfig['host'], $this->dbconfig['username'], $this->dbconfig['password'], $this->dbconfig['database']);
        $this->db->autoCommit(false);
        $this->db->query('SET time_zone = "UTC";');
		return $this->db;
    }
        
    /**
	*The class destructor which closes the DB connection
	*/
	function __destruct(){
        $this->closeDB();
    }
    
    /**
	* Close the DB connection
	*/
	function closeDB(){
 	    $this->db->rollback();
        $this->db->close();
    }
  
    
}  
?>
