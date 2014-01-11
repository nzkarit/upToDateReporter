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
    $smarty = new Smarty_Header('submit_signup.tpl');
    $auth = new Authenticate();
    $auth->shoudNotBeLoggedIn($smarty);
    $smarty->assign('title', 'Signup Submitted');
    
    $ok_flag = true;
    $errors = array();
    
    $_POST['user_email'] = trim($_POST['user_email']);
    if(strlen($_POST['user_email']) == 0) {
        $ok_flag = false;
        array_push($errors, 'Email can\'t be blank');
    }
    if(strlen($_POST['user_email']) > 255) {
        $ok_flag = false;
        array_push($errors, 'Email too long');
    }
    if(!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)){
        $ok_flag = false;
        array_push($errors, 'Email not valid email address');
    }
    
    if(strlen($_POST['user_password']) < 8) {
        $ok_flag = false;
        array_push($errors, 'Password too short');
    }
    if(strlen($_POST['user_password']) > 255) {
        $ok_flag = false;
        array_push($errors, 'Password too long');
    }
    
    if($ok_flag){
        $db = new DB_Handler();
        $connection = $db->connectDB();
        $query = 'SELECT user_id FROM user WHERE user_email = ? FOR UPDATE;';
        $statement = $connection->prepare($query);
        $statement->bind_param('s', $user_email);
        $user_email = $connection->real_escape_string($_POST['user_email']);
        $statement->execute();
        $statement->store_result();
        if($statement->num_rows > 0){
            $statement->close();
            $query = 'SELECT user_id FROM user WHERE user_email = ? AND user_confirmed = 0 AND user_confirmation_code_datetime_sent < DATE_SUB(NOW(), INTERVAL 24 HOUR);';
            $statement = $connection->prepare($query);
            $statement->bind_param('s', $user_email);
            $user_email = $connection->real_escape_string($_POST['user_email']);
            $statement->execute();
            $statement->store_result();
            if($statement->num_rows == 1){
                $statement->close();
                $query = 'DELETE FROM user WHERE user = ? AND user_confirmed = 0 AND user_confirmation_code_datetime_sent < DATE_SUB(NOW(), INTERVAL 24 HOUR);';
                $statement = $connection->prepare($query);
                $statement->bind_param('s', $user_email);
                $user_email = $connection->real_escape_string($_POST['user_email']);
                $statement->execute();
            } else {
                $connection->rollback();
                $statement->close();
                $ok_flag = false;
                array_push($errors, 'Email already exists. Please check your email and spam for a confirmation email. If the email is lost please wait 24 hours from orginal signup and try registering again.');
            }
        }
    }
   
    if($ok_flag){
        $config = new Config();        
        $query = 'INSERT INTO user(user_email, user_password, user_confirmation_code) VALUES (?, ?, ?);';      
        $statement = $connection->prepare($query);
        $statement->bind_param('sss', $user_email, $user_password, $user_confirmation_code);
        $user_email = $connection->real_escape_string($_POST['user_email']);
        $user_password = password_hash($_POST['user_password'], $config->passwordAlgorithm, ['cost' => $config->getWorkFactor()]);
        //If mcrypt isn't workking see instructions on https://bugs.launchpad.net/ubuntu/+source/php-mcrypt/+bug/1241286
        $user_confirmation_code = hash('sha512', mcrypt_create_iv(128, MCRYPT_DEV_URANDOM));
        $statement->execute();
        $email_message = 'Thankyou for signing up to '.$config->getAppName()."\r\n".'Please click on the following link to confirm your registration:'."\r\n".$config->getSiteBaseURL().'confirm_signup.php?code='.$user_confirmation_code;
        $email_subject = 'Please complete your '.$config->getAppName().' Signup';
        $email_headers = 'From: '.$config->getFromEmailAddress()."\r\n".'Reply-To: '.$config->getFromEmailAddress();
        $email_result = mail($user_email, $email_subject, $email_message, $email_headers);
        if($email_result) {        
            $connection->commit();  
            $statement->close();
            $smarty->assign('user_email', $_POST['user_email']);
        } else {
            $connection->rollback();
            $statement->close();
            array_push($errors, 'Could not send email to: '.$user_email.'. Please press back and try again.');
            $smarty->assign('title', 'Errors in Submission');
            $smarty->changeTemplate('errors.tpl');
            $smarty->assign('errors', $errors); 
        }
    }else{
        $smarty->assign('title', 'Errors in Submission');
        $smarty->changeTemplate('errors.tpl');
        $smarty->assign('errors', $errors);
    }
    $smarty->display();

?>
