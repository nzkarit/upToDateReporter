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
    require_once('Config.class.php');
    require_once('Authenticate.class.php');
    $smarty = new Smarty_Header('index.tpl');
    $auth = new Authenticate();
    $auth->securePage($smarty);
    
    $ok_flag = true;
    $errors = array();
    
    if(strlen($_POST['new_password_1']) < 8) {
        $ok_flag = false;
        array_push($errors, 'Password too short');
    }
    if(strlen($_POST['new_password_1']) > 255) {
        $ok_flag = false;
        array_push($errors, 'Password too long');
    }
    if($_POST['new_password_1'] != $_POST['new_password_2']){
        $ok_flag = false;
        array_push($errors, 'The two new passwords don\'t match');
    }
    
    if($ok_flag){
        $result = $auth->changePassword($_POST['current_password'], $_POST['new_password_1']);
        if($result){
            $config = new Config();
            header('Location: '.$config->getSiteBaseURL());
            exit();
        } else {
            $ok_flag = false;
            array_push($errors, 'Current password incorrect');
        }
    }
    $smarty->assign('title', 'Errors in Submission');
    $smarty->changeTemplate('errors.tpl');
    $smarty->assign('errors', $errors);
    $smarty->display();
?>
