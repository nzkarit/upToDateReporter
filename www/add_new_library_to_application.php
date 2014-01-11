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
    require_once('Authenticate.class.php');
    $smarty = new Smarty_Header('add_new_library_to_application.tpl');
    $auth = new Authenticate();
    $auth->securePage($smarty);
    $smarty->assign('title', 'Add New Library to Application');
    $smarty->assign('application_id', intval($_GET['id']));
    $db = new DB_Handler();
    $connection = $db->connectDB();
    $query = 'SELECT library_id, library_name FROM library ORDER BY library_name;';
    $statement = $connection->prepare($query);
    $statement->execute();
    $statement->bind_result($library_id, $library_name);
    $libraries = array();
    while($statement->fetch()){
        $libraries[$library_id] = $library_name;
    }
    $statement->close();
    $smarty->assign('libraries', $libraries);  
    $smarty->display();
?>
