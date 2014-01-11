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

<table>
    <tr>
        <td>Application Name:</td>
        <td>{$application_name}</td>
    </tr>
    <tr>
        <td>Library Name:</td>
        <td>{$library_name}</td>
    </tr>
    <tr>
        <td>Library Use:</td>
        <td>{$applib_description}</td>
    </tr>
    <tr>
        <td>Current Version:</td>
        <td>{$version_name}</td>
    </tr>
    <tr>
        <td>Current Version Release Date:</td>
        <td>{$version_release_date}</td>
    </tr>
</table>

<form id="edit_application_library_version" name="edit_application_library_version" method="post" action="submit_edit_application_library_version.php">
<p><label for="version_id">Change Version in use: </label>{html_options name=version_id options=$versions selected=$version_id}</p>
<p><input id="applib_id" name="applib_id" type="hidden" value="{$applib_id}" /><input id="edit_application_library_version_submit" name="edit_application_library_version_submit" type="submit" value="Update Version" /></p>
</form>

{include file="footer.tpl"}
