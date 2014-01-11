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

{include file="header.tpl"}
<form id="change_password" name="change_password" method="post" action="submit_change_password.php">
    <table>
        <tr>  
            <td>   
                <label for="current_password">Current Password: </label>
            </td>
            <td>
                <input id="current_password" name="current_password" type="password" maxlength="255" value="" />
            </td>
        </tr>
        <tr>  
            <td>   
                <label for="new_password_1">New Password: </label>
            </td>
            <td>
                <input id="new_password_1" name="new_password_1" type="password" maxlength="255" value="" />
            </td>
        </tr>
        <tr>  
            <td>   
                <label for="new_password_2">Retype New Password: </label>
            </td>
            <td>
                <input id="new_password_2" name="new_password_2" type="password" maxlength="255" value="" />
            </td>
        </tr>
    </table> 
    <p><input id="change_password_submit" name="change_password_submit" type="submit" value="Change Password" /></p>
</form>
{include file="footer.tpl"}
