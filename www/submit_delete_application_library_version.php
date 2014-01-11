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

    $_POST['applib_id'] = intval($_POST['applib_id']);


    $db = new DB_Handler();
    $connection = $db->connectDB();
    $query = <<<'EOT'
        SELECT a.application_id
            FROM application a
                JOIN applib al ON a.application_id = al.application_id
            WHERE user_id = ? AND applib_id = ? FOR UPDATE;    
EOT;
    $statement = $connection->prepare($query);
    print_r($connection->error_list);
    $statement->bind_param('ii', $user_id, $applib_id);
    $user_id = $_SESSION['user_id'];
    $applib_id = $_POST['applib_id'];
    $statement->execute();
    $statement->bind_result($application_id);
    $statement->store_result();
    if($statement->num_rows == 1){        
        $statement->fetch();
        $statement->close();            
        $query = 'DELETE FROM applib WHERE applib_id = ?;';
        $statement = $connection->prepare($query);
        $statement->bind_param('i', $applib_id);
        $applib_id = $_POST['applib_id'];
        $statement->execute();
        $connection->commit();  
        $statement->close();
        $config = new Config();
        header('Location: '.$config->getSiteBaseURL().'view_application.php?id='.$application_id);
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

