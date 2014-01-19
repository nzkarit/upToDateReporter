{*
This file is part of Up To Date Reporter.

Up To Date Reporter is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Up To Date Reporter is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Up To Date Reporter.  If not, see <http://www.gnu.org/licenses/>.

(c)Copyright 2014 David Robinson (copyright AT karit DOT geek DOT nz)
*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title>{$appName} - {$title}</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>
	<body>
	    <div id="container">
		    <div id="header">
		        <h1>{$appName} - {$title}</h1>
		    	<p>
		    	    <a href="index.php">Home</a> 
		        	| <a href="list_libraries.php">List Libraries</a> 
		        	{if $logged_in}
		        	    | <a href="list_applications.php">List Applications</a> 
		        	{else}
		        	    | <a href="view_sample_application.php">Sample Application</a>
		        	{/if}
		        	{if $logged_in}| <a href="add_new_application.php">Add New Application</a> {/if}
		        	{if $logged_in}| <a href="add_new_library.php">Add New Library</a> {/if}
		        	| <a href="list_moderator_queue.php">Moderator Queue</a> 
		        	{if !$logged_in}| <a href="signup.php">Signup</a> {/if}
		        	{if !$logged_in}| <a href="login.php">Login</a> {/if}
		        	{if $logged_in}| <a href="change_password.php">Change Password</a> {/if}
		        	{if $logged_in}| <a href="logout.php">Logout</a> {/if}
		        	| <a href="roadmap.php">Roadmap</a>
		    	</p>		    	
		    </div> <!-- header -->
		    <div id="contentwrapper">
                <div id="content">
