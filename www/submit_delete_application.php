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
    $smarty = new Smarty_Header('index.tpl');
    $auth = new Authenticate();
    $auth->securePage($smarty);    

    $ok_flag = true;
    $errors = array();

    $_POST['application_id'] = intval($_POST['application_id']);


    $db = new DB_Handler();
    $connection = $db->connectDB();
    $query = <<<'EOT'
        SELECT a.application_id
            FROM application a
            WHERE user_id = ? AND application_id = ? FOR UPDATE;    
EOT;
    $statement = $connection->prepare($query);
    print_r($connection->error_list);
    $statement->bind_param('ii', $user_id, $application_id);
    $user_id = $_SESSION['user_id'];
    $application_id = $_POST['application_id'];
    $statement->execute();
    $statement->bind_result($application_id);
    $statement->store_result();
    if($statement->num_rows == 1){        
        $statement->fetch();
        $statement->close();            
        $query = 'DELETE FROM applib WHERE application_id = ?;';
        $statement = $connection->prepare($query);
        $statement->bind_param('i', $application_id);
        $application_id = $_POST['application_id'];
        $statement->execute();
        $statement->close();        
        $query = 'DELETE FROM application WHERE application_id = ?;';
        $statement = $connection->prepare($query);
        $statement->bind_param('i', $application_id);
        $application_id = $_POST['application_id'];
        $statement->execute();
        $connection->commit();  
        $statement->close();
        $config = new Config();
        header('Location: '.$config->getSiteBaseURL().'list_applications.php');
        exit();
    } else {
        $ok_flag = false;
        array_push($errors, 'Can\'t update other people\'s applications');
        $statement->close();
        $connection->rollback();            
    }
    $smarty->assign('title', 'Errors in Submission');
    $smarty->changeTemplate('errors.tpl');
    $smarty->assign('errors', $errors);
    $smarty->dispay();
 
?>

