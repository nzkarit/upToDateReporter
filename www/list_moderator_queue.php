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
    $smarty = new Smarty_Header('list_moderator_queue.tpl');
    $smarty->assign('title', 'Moderation Queue');
    $auth = new Authenticate();
    $auth->notSecurePage($smarty);
    $db = new DB_Handler();
    $connection = $db->connectDB();
    $query =<<<'EOT'
        SELECT l.library_queue_id, l.library_queue_name, l.library_queue_url, u.user_email
            FROM library_queue l JOIN user u on l.user_id = u.user_id
            WHERE l.user_id <> ?
	        ORDER BY l.library_queue_name ASC    
EOT;
    $statement = $connection->prepare($query);
    $statement->bind_param('i', $user_id);
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = -1;
    }
    
    $statement->execute();
    $statement->bind_result($library_id, $library_name, $library_url, $user_email);
    $libraries = array();
    while ($statement->fetch()){
        $row = array('library_id' => $library_id, 'library_name' => $library_name, 'library_url' => $library_url, 'user_email' => $user_email);
        array_push($libraries, $row);
    }
    $statement->close();
    $smarty->assign('libraries', $libraries);
    $query =<<<'EOT'
        SELECT v.version_queue_id, v.version_queue_name, v.version_queue_release_notes, v.version_queue_release_date, v.version_queue_number_of_fixes, v.version_queue_number_of_security_fixes, u.user_email, l.library_name
            FROM version_queue v JOIN user u on v.user_id = u.user_id JOIN library l on v.library_id = l.library_id
            WHERE v.user_id <> ?
	        ORDER BY v.version_queue_name ASC    
EOT;
    $statement = $connection->prepare($query);
    $statement->bind_param('i', $user_id);
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = -1;
    }
    $statement->execute();
    $statement->bind_result($version_id, $version_name, $version_release_notes, $version_release_date, $version_number_of_fixes, $version_number_of_security_fixes, $user_email, $library_name);
    $versions = array();
    while ($statement->fetch()){
        $row = array('version_id' => $version_id, 'version_name' => $version_name, 'version_release_notes' => $version_release_notes, 'version_release_date' => $version_release_date, 'version_number_of_fixes' => $version_number_of_fixes, 'version_number_of_security_fixes' => $version_number_of_security_fixes, 'user_email' => $user_email, 'library_name' => $library_name);
        array_push($versions, $row);
    }
    $statement->close();
    $smarty->assign('versions', $versions);
    $smarty->display();
?>
