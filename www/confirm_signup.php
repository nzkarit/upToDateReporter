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
    $smarty = new Smarty_Header('confirm_signup.tpl');
    $auth = new Authenticate();
    $auth->shoudNotBeLoggedIn($smarty);
    $smarty->assign('title', 'Signup Confirmed');
    
    $errors = array();

    $config = new Config();
    $db = new DB_Handler();
    $connection = $db->connectDB();
    $query = 'SELECT user_id FROM user WHERE user_confirmation_code = ? AND user_confirmed = 0 AND user_confirmation_code_datetime_sent > DATE_SUB(NOW(), INTERVAL 24 HOUR);';
    $statement = $connection->prepare($query);
    $statement->bind_param('s', $user_confirmation_code);
    $user_confirmation_code = $connection->real_escape_string($_GET['code']);
    $statement->execute();
    $statement->store_result();
    if($statement->num_rows == 1){
        $statement->close();
        $query = 'UPDATE user SET user_confirmed = 1 WHERE user_confirmation_code = ?;';
        $statement = $connection->prepare($query);
        $statement->bind_param('s', $user_confirmation_code);
        $user_confirmation_code = $connection->real_escape_string($_GET['code']);
        $statement->execute();
        $connection->commit();  
        $statement->close();
    } else {
        $connection->rollback();
        $statement->close();
        array_push($errors, 'Code not found in DB or over 24 old or already confirmed. If your email client has made the url of a couple of lines you may need to manually copy and paste it back together to make one url');
        $smarty->assign('title', 'Errors in Submission');
        $smarty->changeTemplate('errors.tpl');
        $smarty->assign('errors', $errors); 
    }
    $smarty->display();

?>
