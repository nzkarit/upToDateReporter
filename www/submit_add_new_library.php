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
    $smarty = new Smarty_Header('submit_add_new_library.tpl');
    $auth = new Authenticate();
    $auth->securePage($smarty);
    $smarty->assign('title', 'New Library Added');
    $ok_flag = true;
    $errors = array();
    $_POST['library_name'] = trim($_POST['library_name']);
    if(strlen($_POST['library_name']) == 0) {
        $ok_flag = false;
        array_push($errors, 'Library Name can\'t be blank');
    }
    if(strlen($_POST['library_name']) > 255) {
        $ok_flag = false;
        array_push($errors, 'Library Name too long');
    }
    $_POST['library_url'] = trim($_POST['library_url']);
    if(strlen($_POST['library_url']) == 0) {
        $ok_flag = false;
        array_push($errors, 'Library URL can\'t be blank');
    }
    if(strlen($_POST['library_url']) > 255) {
        $ok_flag = false;
        array_push($errors, 'Library URL too long');
    }
    if(!filter_var($_POST['library_url'], FILTER_VALIDATE_URL)){
        $ok_flag = false;
        array_push($errors, 'Library URL not valid URL');
    }

    if($ok_flag){
        $db = new DB_Handler();
        $connection = $db->connectDB();
        $query = 'INSERT INTO library_queue (library_queue_name, library_queue_url, user_id) VALUES (?, ?, ?);';
        $statement = $connection->prepare($query);
        $statement->bind_param('ssi', $library_name, $library_url, $user_id);
        $library_name = $connection->real_escape_string($_POST['library_name']);
        $library_url = $connection->real_escape_string($_POST['library_url']);
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
