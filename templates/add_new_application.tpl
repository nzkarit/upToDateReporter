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
<form id="add_new_application" name="add_new_application" method="post" action="submit_add_new_application.php">
    <table>
        <tr>
            <td>
                <label for="application_name">Application Name: </label>
            </td>
            <td>
                <input id="application_name" name="application_name" type="text" maxlength="255" value="" />
            </td>
        </tr>
    </table> 
    <p><input id="add_new_application_submit" name="add_new_application_submit" type="submit" value="Add New Application" /></p>
</form>
{include file="footer.tpl"}
