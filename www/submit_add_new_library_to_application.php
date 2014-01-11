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
    
    $_POST['applib_description'] = trim($_POST['applib_description']);
    if(strlen($_POST['applib_description']) == 0) {
        $ok_flag = false;
        array_push($errors, 'Use of Library in Appliction can\'t be blank');
    }
    if(strlen($_POST['applib_description']) > 255) {
        $ok_flag = false;
        array_push($errors, 'Use of Library in Appliction too long');
    }
    $_POST['library_id'] = intval($_POST['library_id']);
    $_POST['application_id'] = intval($_POST['application_id']);

   if($ok_flag){
        $db = new DB_Handler();
        $connection = $db->connectDB();
        $query = 'SELECT user_id FROM application WHERE user_id = ? AND application_id = ? FOR UPDATE';
        $statement = $connection->prepare($query);
        $statement->bind_param('ii', $user_id, $application_id);
        $user_id = $_SESSION['user_id'];
        $application_id = $_POST['application_id'];
        $statement->execute();
        $statement->store_result();
        if($statement->num_rows == 1){
            $statement->close();            
            $query = <<<'EOT'
                SELECT library_id, version_id, MAX(version_release_date)
                    FROM version
                    WHERE library_id = ?
                    GROUP BY library_id FOR UPDATE
EOT;
            $statement = $connection->prepare($query);
            $statement->bind_param('i', $library_id);
            $library_id = $_POST['library_id'];
            $statement->execute();
            $statement->store_result();
            if($statement->num_rows == 1){
                $statement->bind_result($null, $version_id, $null);
                $statement->fetch();
                $statement->close();
                $query = 'INSERT INTO applib (applib_description, version_id, application_id) VALUES (?, ?, ?);';
                $statement = $connection->prepare($query);
                $statement->bind_param('sii', $applib_description, $version_id, $application_id);
                $applib_description = $connection->real_escape_string($_POST['applib_description']);
                
                $application_id = $_POST['application_id'];
                $statement->execute();
                $connection->commit();  
                $statement->close();
                $config = new Config();
                header('Location: '.$config->getSiteBaseURL().'view_application.php?id='.$_POST['application_id']);
                exit();
            } else {
                $ok_flag = false;
                array_push($errors, 'Can\'t get a version_id can only use libraries have have at least one version');
                $statement->close();
            $connection->rollback();
            }
        } else {
            $ok_flag = false;
            array_push($errors, 'Can\'t update other people\'s applications');
            $statement->close();
            $connection->rollback();            

        }
    }
    
    
    $smarty->assign('title', 'Errors in Submission');
    $smarty->changeTemplate('errors.tpl');
    $smarty->assign('errors', $errors);
    $smarty->dispay();
 
?>

