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
    $smarty = new Smarty_Header('submit_add_new_version.tpl');
    $auth = new Authenticate();
    $auth->securePage($smarty);    
    $smarty->assign('title', 'New Version Added');

    $ok_flag = true;
    $errors = array();

    $_POST['version_name'] = trim($_POST['version_name']);
    if(strlen($_POST['version_name']) == 0) {
        $ok_flag = false;
        array_push($errors, 'Version Name can\'t be blank');
    }
    if(strlen($_POST['version_name']) > 255) {
        $ok_flag = false;
        array_push($errors, 'Version Name too long');
    }

    $_POST['version_release_notes'] = trim($_POST['version_release_notes']);
    if(strlen($_POST['version_release_notes']) == 0) {
        $ok_flag = false;
        array_push($errors, 'Version Release Notes URL can\'t be blank');
    }
    if(strlen($_POST['version_release_notes']) > 255) {
        $ok_flag = false;
        array_push($errors, 'Version Release Notes URL too long');
    }
    if(!filter_var($_POST['version_release_notes'], FILTER_VALIDATE_URL)){
        $ok_flag = false;
        array_push($errors, 'Version Release Notes not valid URL');
    }

    $_POST['version_release_date'] = trim($_POST['version_release_date']);
    if(!strtotime($_POST['version_release_date'])){
        $ok_flag = false;
        array_push($errors, 'Version Release Date not a valid date');
    }

    $_POST['version_number_of_fixes'] = intval($_POST['version_number_of_fixes']);
    if($_POST['version_number_of_fixes'] < 0){
        $ok_flag = false;
        array_push($errors, 'Number of Fixes must be a number greater or equal to zero');
    }

    $_POST['version_number_of_security_fixes'] = intval($_POST['version_number_of_security_fixes']);
    if($_POST['version_number_of_security_fixes'] < 0){
        $ok_flag = false;
        array_push($errors, 'Number of Security Fixes must be a number greater or equal to zero');
    }

    $_POST['library_id'] = intval($_POST['library_id']);




    if($ok_flag){
        $db = new DB_Handler();
        $connection = $db->connectDB();
        $query = 'INSERT INTO version_queue (library_id, version_queue_name, version_queue_release_notes, version_queue_number_of_fixes, version_queue_number_of_security_fixes, version_queue_release_date, user_id) VALUES (?, ?, ?, ?, ?, ?, ?);';
        $statement = $connection->prepare($query);
        $statement->bind_param('issiisi', $library_id, $version_name, $version_release_notes, $version_number_of_fixes, $version_number_of_security_fixes, $version_release_date, $user_id);
        $library_id = $connection->real_escape_string($_POST['library_id']);
        $version_name = $connection->real_escape_string($_POST['version_name']);
        $version_release_notes = $connection->real_escape_string($_POST['version_release_notes']);
        $version_number_of_fixes = $connection->real_escape_string($_POST['version_number_of_fixes']);
        $version_number_of_security_fixes = $connection->real_escape_string($_POST['version_number_of_security_fixes']);
        $version_release_date = $connection->real_escape_string($_POST['version_release_date']);
        $user_id = $_SESSION['user_id'];
        $statement->execute();
        $connection->commit();  
        $statement->close();
    }else{
        $smarty->assign('title', 'Errors in Submission');
        $smarty->changeTemplate('errors.tpl');
        $smarty->assign('errors', $errors);
    }
    $smarty->display();
?>
