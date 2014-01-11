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
    $smarty = new Smarty_Header('view_library.tpl');
    $auth = new Authenticate();
    $auth->notSecurePage($smarty);
    $db = new DB_Handler();
    $connection = $db->connectDB();
    $id = intval($_GET['id']);
    if($id<1){
        die('Bad id');
    }

    $query = 'SELECT l.library_id, l.library_name, l.library_url, l.library_eol, l.library_eol_date FROM library l WHERE l.library_id = ?;';
    $statement = $connection->prepare($query);
    $statement->bind_param('i', $library_id);
    $library_id = $id;
    $statement->execute();
    $statement->bind_result($library_id, $library_name, $library_url, $library_eol, $library_eol_date);
    $statement->fetch();
    $statement->close();
    $smarty->assign('title', 'Library Details - '.$library_name);
    $smarty->assign('library_id', $library_id);
    $smarty->assign('library_name', $library_name);
    $smarty->assign('library_url', $library_url);
    $smarty->assign('library_eol', $library_eol);
    $smarty->assign('library_eol_date', $library_eol_date);
    
    $query = 'SELECT v.version_id, v.version_name, v.version_release_notes, v.version_number_of_fixes, v.version_number_of_security_fixes, v.version_release_date FROM version v WHERE v.library_id = ? ORDER BY v.version_release_date DESC;';
    $statement = $connection->prepare($query);
    $statement->bind_param('i', $library_id);
    $library_id = $id;
    $statement->execute();
    $statement->bind_result($version_id, $version_name, $version_release_notes, $version_number_of_fixes, $version_number_of_security_fixes, $version_release_date);
    $versions = array();
    while ($statement->fetch()){
        $row = array('version_id' => $version_id, 'version_name' => $version_name, 'version_release_notes' => $version_release_notes, 'version_number_of_fixes' => $version_number_of_fixes, 'version_number_of_security_fixes' => $version_number_of_security_fixes, 'version_release_date' => $version_release_date);
        array_push($versions, $row);
    }
    $statement->close();
    $smarty->assign('versions', $versions);
    $smarty->display();
?>

