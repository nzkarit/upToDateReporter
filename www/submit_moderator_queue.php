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
    $smarty = new Smarty_Header('submit_moderator_queue.tpl');
    $auth = new Authenticate();
    $auth->securePageMod($smarty);    
    $smarty->assign('title', 'Submit Moderator Queue');
    $db = new DB_Handler();
    $connection = $db->connectDB();
    if(isset($_POST['library'])){
        foreach($_POST['library'] as $key => $value){
            $query=<<<'EOT'
                INSERT INTO library (library_name, library_url)
                    SELECT library_queue_name, library_queue_url
                        FROM library_queue
                        WHERE library_queue_id = ? AND user_id <> ?;                        
EOT;
            $statement = $connection->prepare($query);
            $statement->bind_param('ii', $library_queue_id, $user_id);
            $library_queue_id = intval($key);
            $user_id = $_SESSION['user_id'];
            $statement->execute();
            if($statement->affected_rows == 1){
                $statement->close();
                $query = 'SELECT user_id FROM library_queue WHERE library_queue_id = ? FOR UPDATE;';
                $statement = $connection->prepare($query);
                $statement->bind_param('i', $library_queue_id);
                $library_queue_id = intval($key);
                $statement->execute();
                $statement->bind_result($user_id);
                $statement->fetch();
                $adding_user = $user_id;
                $statement->close();
                $query = 'UPDATE user SET user_libraries_added = user_libraries_added + 1 WHERE user_id = ?;';
                $statement = $connection->prepare($query);
                $statement->bind_param('i', $user_id);
                $user_id = $adding_user;              
                $statement->execute();
                $statement->close();
                $query = 'UPDATE user SET user_libraries_modded = user_libraries_modded + 1 WHERE user_id = ?;';
                $statement = $connection->prepare($query);
                $statement->bind_param('i', $user_id);
                $user_id = $_SESSION['user_id'];
                $statement->execute();
                $statement->close();
                $query = 'DELETE FROM library_queue WHERE library_queue_id = ?;';
                $statement = $connection->prepare($query);
                $statement->bind_param('i', $library_queue_id);
                $library_queue_id = intval($key);
                $statement->execute();
                $statement->close();
                $connection->commit();
            } else {
                $statement->close();
                $connection->rollback();
            }   
        }
    }
    if(isset($_POST['version'])){
        foreach($_POST['version'] as $key => $value){
            $query=<<<'EOT'
                INSERT INTO version (library_id, version_name, version_release_notes, version_release_date, version_number_of_fixes, version_number_of_security_fixes)
                    SELECT library_id, version_queue_name, version_queue_release_notes, version_queue_release_date, version_queue_number_of_fixes, version_queue_number_of_security_fixes
                        FROM version_queue
                        WHERE version_queue_id = ? AND user_id <> ?;                        
EOT;
            $statement = $connection->prepare($query);
            $statement->bind_param('ii', $version_queue_id, $user_id);
            $version_queue_id = intval($key);
            $user_id = $_SESSION['user_id'];
            $statement->execute();
            if($statement->affected_rows == 1){
                $statement->close();
                $query = 'SELECT user_id FROM version_queue WHERE version_queue_id = ? FOR UPDATE;';
                $statement = $connection->prepare($query);
                $statement->bind_param('i', $library_queue_id);
                $library_queue_id = intval($key);
                $statement->execute();
                $statement->bind_result($user_id);
                $statement->fetch();
                $adding_user = $user_id;
                $statement->close();
                $query = 'UPDATE user SET user_versions_added = user_versions_added + 1 WHERE user_id = ?;';
                $statement = $connection->prepare($query);
                $statement->bind_param('i', $user_id);
                $user_id = $adding_user;              
                $statement->execute();
                $statement->close();
                $query = 'UPDATE user SET user_versions_modded = user_versions_modded + 1 WHERE user_id = ?;';
                $statement = $connection->prepare($query);
                $statement->bind_param('i', $user_id);
                $user_id = $_SESSION['user_id'];
                $statement->execute();
                $statement->close();
                $query = 'DELETE FROM version_queue WHERE version_queue_id = ?;';
                $statement = $connection->prepare($query);
                $statement->bind_param('i', $library_queue_id);
                $library_queue_id = intval($key);
                $statement->execute();
                $statement->close();
                $connection->commit();
            } else {
                $statement->close();
                $connection->rollback();
            }   
        }
    }
    $smarty->display();
?>
