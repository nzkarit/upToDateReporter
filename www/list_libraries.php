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

    require_once('Smarty_Header.class.php');
    require_once('DB_Handler.class.php');
    require_once('Authenticate.class.php');
    $smarty = new Smarty_Header('list_libraries.tpl');
    $smarty->assign('title', 'List Libraries');
    $auth = new Authenticate();
    $auth->notSecurePage($smarty);
    $db = new DB_Handler();
    $connection = $db->connectDB();
    $query =<<<'EOT'
        SELECT l.library_id, l.library_name, l.library_url, l.library_eol, l.library_eol_date, v2.version_name, v2.version_release_date
            FROM library l LEFT OUTER JOIN
                (SELECT v.library_id, v.version_name, v.version_release_date
                    FROM version v
                    WHERE v.version_release_date = 
	                    (SELECT MAX(version_release_date) 
		                    FROM version 
		                    GROUP BY library_id 
		                    HAVING library_id = v.library_id)) v2 
	        ON l.library_id = v2.library_id
	        ORDER BY l.library_name ASC    
EOT;
    $statement = $connection->prepare($query);
    $statement->execute();
    $statement->bind_result($library_id, $library_name, $library_url, $library_eol, $library_eol_date, $version_name, $version_release_date);
    $libraries = array();
    while ($statement->fetch()){
        $row = array('library_id' => $library_id, 'library_name' => $library_name, 'library_eol' => $library_eol, 'library_eol_date' => $library_eol_date, 'version_name' => $version_name, 'version_release_date' => $version_release_date);
        array_push($libraries, $row);
    }
    $statement->close();
    $smarty->assign('libraries', $libraries);
    $smarty->display();
   ?>
