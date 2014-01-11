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
    $smarty = new Smarty_Header('view_application.tpl');
    $auth = new Authenticate();
    $auth->shoudNotBeLoggedIn($smarty);
    $db = new DB_Handler();
    $connection = $db->connectDB();
    $query = 'SELECT application_name FROM application WHERE application_id = 1 AND application_sample = 1;';
    $statement = $connection->prepare($query);
    $statement->execute();
    $statement->bind_result($application_name);
    $statement->fetch();
    $statement->close();
    $smarty->assign('title', 'Application Details - '.$application_name);
    $smarty->assign('application_name', $application_name);
    $smarty->assign('application_id', 1);
    
    
    $query = <<<'EOT'
        SELECT al.applib_id, al.applib_description, l.library_name, l.library_eol, library_eol_date, v.version_name, v.version_release_date, v2.version_name, v2.version_release_date, v3.version_name, v3.version_release_date
	        FROM applib al
		        JOIN application a ON al.application_id = a.application_id
		        LEFT OUTER JOIN version v ON al.version_id = v.version_id
		        JOIN library l ON v.library_id = l.library_id
		        LEFT OUTER JOIN (SELECT v.library_id, v.version_name, v.version_release_date
				        FROM version v
					        JOIN (SELECT v2.library_id, MAX(v2.version_release_date) version_release_date
							        FROM applib al
								        JOIN version v ON al.version_id = v.version_id
								        JOIN version v2 ON v.library_id = v2.library_id
							        WHERE al.application_id = ?
							        GROUP BY v2.library_id) v2 
						        ON v.version_release_date = v2.version_release_date AND v.library_id = v2.library_id) v2
			        ON v.library_id = v2.library_id
		        LEFT OUTER JOIN (SELECT v.library_id, v.version_name, v.version_release_date
				        FROM version v
					        JOIN (SELECT v2.library_id, MIN(v2.version_release_date) version_release_date
							        FROM applib al
								        JOIN version v ON al.version_id = v.version_id
								        JOIN version v2 ON v.library_id = v2.library_id
							        WHERE v.version_release_date < v2.version_release_date AND al.application_id = ?
							        GROUP BY v2.library_id) v2 
						        ON v.version_release_date = v2.version_release_date AND v.library_id = v2.library_id) v3
			        ON v.library_id = v3.library_id
	        WHERE al.application_id = ? AND a.application_sample = 1
	        ORDER BY l.library_name, al.applib_description;
EOT;

    $statement = $connection->prepare($query);
    //print_r($connection->error_list);
    $statement->bind_param('iii', $application_id, $application_id, $application_id);
    $application_id = 1;
    $statement->execute();
    //The next release refers to the version that came after the current in use one i.e. the first one to superseed it
    $statement->bind_result($applib_id, $applib_description, $library_name, $library_eol, $library_eol_date, $current_version_name, $current_version_release_date, $latest_version_name, $latest_version_release_date, $next_version_name, $next_version_release_date);
    $uses = array();
    while($statement->fetch()){
        $days = null;
        if($current_version_name==$latest_version_name){
            if($library_eol){
                $date_now = new DateTime('now');
                $date_eol = new DateTime($library_eol_date);
                $interval = $date_eol->diff($date_now);
                $days = $interval->format('%a');
            } else {
                $days = 0;
            }
        } else {
            $date_now = new DateTime('now');
            $date_next_version = new DateTime($next_version_release_date);
            $interval = $date_next_version->diff($date_now);
            $days = $interval->format('%a');
        }
        $row = array('applib_id' => $applib_id, 'applib_description' => $applib_description, 'library_name' => $library_name, 'library_eol' => $library_eol, 'library_eol_date' => $library_eol_date, 'current_version_name' => $current_version_name, 'current_version_release_date' => $current_version_release_date, 'latest_version_name' => $latest_version_name, 'latest_version_release_date' => $latest_version_release_date, 'next_version_name' => $next_version_name, 'next_version_release_date' => $next_version_release_date, 'days' => $days);
        array_push($uses, $row);
    }
    $statement->close();
    $smarty->assign('uses', $uses);
    $smarty->display();
?>
