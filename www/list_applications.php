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
    $smarty = new Smarty_Header('list_applications.tpl');
    $smarty->assign('title', 'List Applications');
    $auth = new Authenticate();
    $auth->securePage($smarty);
    $db = new DB_Handler();
    $connection = $db->connectDB();
    $query ='SELECT application_id, application_name FROM application WHERE user_id = ?;';
    $statement = $connection->prepare($query);
    $statement->bind_param('i', $user_id);
    $user_id = $_SESSION['user_id'];
    $statement->execute();
    $statement->bind_result($application_id, $application_name);
    $applications = array();
    while ($statement->fetch()){
        $row = array('application_id' => $application_id, 'application_name' => $application_name);
        array_push($applications, $row);
    }
    $statement->close();
    $smarty->assign('applications', $applications);
    $smarty->display();
   ?>
