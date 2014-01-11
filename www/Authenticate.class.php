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

    require_once('DB_Handler.class.php');
    require_once('Config.class.php');

class Authenticate {
    
	/**
	* When the class loads start a cookie session
	*/
	function Authenticate() {
	    self::isIPAllowed();
        session_start();
    }
    
    /**
    * For pages where the user shouldn't be logged in before going there e.g. signup login
    */
    function shoudNotBeLoggedIn($smarty){
        if(!isset($_SESSION['logged_in'])){
	        $smarty->assign('logged_in', false);
			$smarty->assign('admin', false);
			$smarty->assign('mod', false);
	    } else {
	        $smarty->changeTemplate('logout_first.tpl');
            $smarty->assign('title', 'Need to log out first');
            $smarty->display();
            exit();
	    }
    }
    
    /**
    * For pages that don't need securing just set up some smarty stuff
    */
	function notSecurePage($smarty){
	    if(!isset($_SESSION['logged_in'])){
	        $smarty->assign('logged_in', false);
			$smarty->assign('admin', false);
			$smarty->assign('mod', false);
	    } else {
	        $smarty->assign('logged_in', true);
			$smarty->assign('admin', $_SESSION['admin']);
			$smarty->assign('mod', $_SESSION['mod']);
	    }
	}
	
	/**
	* Secure the page will if not logged show the login form else it will conitnue and show you the page requested
	*/
	function securePage($smarty){
		if(!isset($_SESSION['logged_in'])){
            $smarty->changeTemplate('login.tpl');
            $smarty->assign('title', 'Login');
            $smarty->display();
            exit();
        } else {
            $smarty->assign('logged_in', true);
			$smarty->assign('admin', $_SESSION['admin']);
			$smarty->assign('mod', $_SESSION['mod']);
		}
    }
	
	/**
	* This will only show the page to admins
	*/
	function securePageAdmin($smarty){
		if(!isset($_SESSION['logged_in'])){
            $smarty->changeTemplate('login.tpl');
            $smarty->assign('loginForm', 'true');
            $smarty->assign('title', 'Login');
            $smarty->display();
            exit();
		} elseif($_SESSION['admin']) {
		    $smarty->assign('logged_in', true);
			$smarty->assign('admin', $_SESSION['admin']);
			$smarty->assign('mod', $_SESSION['mod']);	
        } else {
            echo 'You need to be an admin to view this page';
			exit(); 
		}
    }
    
    /**
	* This will only show the page to admins or mods
	*/
	function securePageMod($smarty){
	    //print_r($_SESSION);
		if(!isset($_SESSION['logged_in'])){
            $smarty->changeTemplate('login.tpl');
            $smarty->assign('loginForm', 'true');
            $smarty->assign('title', 'Login');
            $smarty->display();
            exit();
		} elseif($_SESSION['admin']){
			$smarty->assign('logged_in', true);
			$smarty->assign('admin', $_SESSION['admin']);
			$smarty->assign('mod', $_SESSION['mod']);
	    } elseif($_SESSION['mod']){
	        $smarty->assign('logged_in', true);
			$smarty->assign('admin', $_SESSION['admin']);
			$smarty->assign('mod', $_SESSION['mod']);
        } else {
            echo 'You need to be an admin or mod to view this page';
			exit();
		}
    }
	
	
	/**
	* This will log the person out and remove all the cookie
	*/
	function logOut(){
        $_SESSION = null;
        if(isset($_COOKIE[session_name()])){
            setcookie(session_name(), '', time()-42000, '/');
        }
        session_destroy();
    }
	
	/**
	* This will do the login and populate the session from the DB
	*/
	function login($email, $password){
        $_SESSION = array();
        $db = new DB_Handler();
        $config = new Config();
        $connection = $db->connectDB();
        self::isUserAllowed($email, $connection);
        $query = 'SELECT user_id, user_email, user_password, user_admin, user_mod, user_password_failure_count, user_password_failure_last_datetime FROM user WHERE user_email = ? AND user_confirmed = 1 FOR UPDATE;';
        $statement = $connection->prepare($query);
        $statement->bind_param('s', $user_email);
        $user_email = $connection->real_escape_string($email);
        $statement->execute(); 
        $statement->bind_result($user_id, $user_email, $user_password, $user_admin, $user_mod, $user_password_failure_count, $user_password_failure_last_datetime);
        $statement->store_result();
        if($statement->num_rows == 1){
            $statement->fetch();
            if(password_verify($password, $user_password)){
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['email'] = $user_email;
                $_SESSION['admin'] = $user_admin;
                $_SESSION['mod'] = $user_mod;
                $statement->close();
                if(password_needs_rehash($user_password, $config->passwordAlgorithm, ['cost' => $config->getWorkFactor()])) {
                    $new_password = password_hash($password, $config->passwordAlgorithm, ['cost' => $config->getWorkFactor()]);
                    $query = 'UPDATE user SET user_password = ? WHERE user_email = ?;';
                    $statement = $connection->prepare($query);
                    $statement->bind_param('ss', $user_password, $user_email);
                    $user_password = $new_password;
                    $user_email = $connection->real_escape_string($email);
                    $statement->execute();
                }
                $connection->commit();
                self::clearFailedPassword($email, $connection);
                return true;
            } else {
                $connection->rollback();
                $statement->close();
                self::failedPassword($email, $connection);
                return false;
            }
        } else {
            $connection->rollback();
            $statement->close();
            self::failedPassword($email, $connection);
            return false;
        }        
        
    }
    
    function changePassword($old_password, $new_password){
        $db = new DB_Handler();
        $config = new Config();
        $connection = $db->connectDB();
        $query = 'SELECT user_password FROM user WHERE user_id = ? AND user_confirmed = 1 FOR UPDATE;';
        $statement = $connection->prepare($query);
        $statement->bind_param('i', $user_id);
        $user_id = $_SESSION['user_id'];
        $statement->execute(); 
        $statement->bind_result($user_password);
        $statement->store_result();
        if($statement->num_rows == 1){
            $statement->fetch();
            if(password_verify($old_password, $user_password)){
                $statement->close();
                $new_password = password_hash($new_password, $config->passwordAlgorithm, ['cost' => $config->getWorkFactor()]);
                $query = 'UPDATE user SET user_password = ? WHERE user_id = ?;';
                $statement = $connection->prepare($query);
                $statement->bind_param('si', $user_password, $user_id);
                $user_password = $new_password;
                $statement->execute();
                $connection->commit();
                return true;
            } else {
                $connection->rollback();
                $statement->close();
                return false;
            }
        } else {
            $connection->rollback();
            $statement->close();
            return false;
        }        
    }
    
    function isIPAllowed(){
        $db = new DB_Handler();
        $connection = $db->connectDB();
        $query = 'SELECT password_failures_count, password_failures_last_datetime FROM password_failures WHERE password_failures_ip = ?;';
        $statement = $connection->prepare($query);
        $statement->bind_param('s', $password_failures_ip);
        $password_failures_ip = $_SERVER['REMOTE_ADDR'];
        $statement->execute();
        $statement->bind_result($password_failures_count, $password_failures_last_datetime);
        $statement->store_result();
        if($statement->num_rows >= 1){
            $statement->fetch();
            if($password_failures_count >= 5){
                $number_of_minutes = $password_failures_count * 3; //3 minutes so gives 15 minute wait for 5 password failures
                $password_failures_last_datetime = new DateTime($password_failures_last_datetime);
                $lockout_time = date_add($password_failures_last_datetime, date_interval_create_from_date_string($number_of_minutes.' minutes'));
                $now = new DateTime();
                if ($lockout_time >= $now){
                    $statement->close();
                    echo('Too Many Failed Password Attempts');
                    exit();
                    return false;
                }
                $statement->close();
                return true;
            }
            $statement->close();
            return true;
        }
        $statement->close();
        return true;
    }
    
    function isUserAllowed($email, $connection){
        $query = 'SELECT user_password_failure_count, user_password_failure_last_datetime FROM user WHERE user_email = ?;';
        $statement = $connection->prepare($query);
        $statement->bind_param('s', $user_email);
        $user_email = $connection->real_escape_string($email);
        $statement->execute();
        $statement->bind_result($user_password_failure_count, $user_password_failure_last_datetime);
        $statement->store_result();
        if($statement->num_rows >= 1){
            $statement->fetch();
            if($user_password_failure_count >= 5){
                $number_of_minutes = $user_password_failure_count * 3; //3 minutes so gives 15 minute wait for 5 password failures
                $user_password_failure_last_datetime = new DateTime ($user_password_failure_last_datetime);
                $lockout_time = date_add( $user_password_failure_last_datetime, date_interval_create_from_date_string($number_of_minutes.' minutes'));
                $now = new DateTime();
                if ($lockout_time >= $now){
                    $statement->close();
                    echo('Too Many Failed Password Attempts');
                    exit();
                    return false;
                }
            }
            $statement->close();
            return true;
        }
        $statement->close();
        return true;
    }
    
    function failedPassword($email, $connection){
        $query = 'UPDATE user SET user_password_failure_count = user_password_failure_count + 1, user_password_failure_last_datetime = NOW() WHERE user_email = ?;';
        $statement = $connection->prepare($query);
        $statement->bind_param('s', $user_email);
        $user_email = $connection->real_escape_string($email);
        $statement->execute();
        $statement->close();
        $query = 'SELECT password_failures_id FROM password_failures WHERE password_failures_ip = ? FOR UPDATE;';
        $statement = $connection->prepare($query);
        $statement->bind_param('s', $password_failures_ip);
        $password_failures_ip = $_SERVER['REMOTE_ADDR'];
        $statement->execute();
        $statement->store_result();
        if($statement->num_rows >= 1){
            $statement->close();
            $query = 'UPDATE password_failures SET password_failures_count = password_failures_count + 1, password_failures_last_datetime = NOW() WHERE password_failures_ip = ?;';
            $statement = $connection->prepare($query);
            $statement->bind_param('s', $password_failures_ip);
            $password_failures_ip = $_SERVER['REMOTE_ADDR'];
            $statement->execute();
            $statement->close();            
        } else {
            $statement->close();
            $query = 'INSERT INTO password_failures (password_failures_ip, password_failures_last_datetime) VALUES (?, NOW());';
            $statement = $connection->prepare($query);
            $statement->bind_param('s', $password_failures_ip);
            $password_failures_ip = $_SERVER['REMOTE_ADDR'];
            $statement->execute();
            $statement->close(); 
        }
        $connection->commit();
    
    }
    
    function clearFailedPassword($email, $connection){
        $query = 'UPDATE user SET user_password_failure_count = 0 WHERE user_email = ?;';
        $statement = $connection->prepare($query);
        $statement->bind_param('s', $user_email);
        $user_email = $connection->real_escape_string($email);
        $statement->execute();
        $statement->close();
        $query = 'UPDATE password_failures SET password_failures_count = 0 WHERE password_failures_ip = ?;';
        $statement = $connection->prepare($query);
        $statement->bind_param('s', $password_failures_ip);
        $password_failures_ip = $_SERVER['REMOTE_ADDR'];
        $statement->execute();
        $statement->close(); 
        $connection->commit();
    }
}
?>
