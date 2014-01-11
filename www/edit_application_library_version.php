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
    $smarty = new Smarty_Header('edit_application_library_version.tpl');
    $auth = new Authenticate();
    $auth->securePage($smarty);
    $db = new DB_Handler();
    $connection = $db->connectDB();
    $id = intval($_GET['id']);
    if($id<1){
        die('Bad id');
    }
    $query = <<<'EOT'
        SELECT a.application_name, l.library_id, l.library_name, al.applib_description, v.version_id, v.version_name, v.version_release_date
            FROM applib al
            JOIN version v ON al.version_id = v.version_id
            JOIN application a ON al.application_id = a.application_id
            JOIN library l ON v.library_id = l.library_id
            WHERE a.user_id = ? AND al.applib_id = ?
EOT;
    $statement = $connection->prepare($query);
    $statement->bind_param('ii', $user_id, $applib_id);
    $user_id = $_SESSION['user_id'];
    $applib_id = $id;
    $statement->execute();
    $statement->bind_result($application_name, $library_id, $library_name, $applib_description, $version_id, $version_name, $version_release_date);
    $statement->fetch();
    $statement->close();
    $smarty->assign('title', 'Application Library Version Details - '.$application_name.' - '.$library_name);
    $smarty->assign('applib_id', $id);
    $smarty->assign('application_name', $application_name);
    $smarty->assign('library_id', $library_id);
    $smarty->assign('library_name', $library_name);
    $smarty->assign('applib_description', $applib_description);
    $smarty->assign('version_id', $version_id);
    $smarty->assign('version_name', $version_name);
    $smarty->assign('version_release_date', $version_release_date);
    $query = 'SELECT v.version_id, v.version_name, v.version_release_date FROM version v WHERE v.library_id = ? ORDER BY v.version_release_date DESC;';
    $statement = $connection->prepare($query);
    $statement->bind_param('i', $library_id);
    $statement->bind_result($version_id, $version_name, $version_release_date);
    $statement->execute();
    $versions = array();
    while ($statement->fetch()){
        $versions[$version_id] = $version_name.' - '.$version_release_date;
    }
    $statement->close();
    $smarty->assign('versions', $versions);
    $smarty->display();
?>

