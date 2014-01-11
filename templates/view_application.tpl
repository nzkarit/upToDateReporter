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
        <td>Name:</td>
        <td>{$application_name}</td>
    </tr>
</table>
<p>{if $logged_in}<p><a href="add_new_library_to_application.php?id={$application_id}">Add New Library to Application</a> |{/if} <a href="view_application_csv.php?id={$application_id}">Export to CSV</a></p>
<table border="1">
    <tr>
        <th>Library Name</th>
        <th>Library Use</th>
        <th>Used Version</th>
        <th>Used Version Release Date</th>
        <th>Latest Version</th>
        <th>Latest Version Release Date</th>
        <th>Up to Date</th>
        <th>Days since used version no longer the latest</th>
        {if $logged_in}
            <th>Edit</th>
            <th>Delete</th>
        {/if}
    </tr>
    {foreach from=$uses item=row}
        <tr>
            <td>{$row.library_name}</td>
            <td>{$row.applib_description}</td>
            <td>{$row.current_version_name}</td>
            <td>{$row.current_version_release_date}</td>
            <td>{$row.latest_version_name}</td>
            <td>{$row.latest_version_release_date}</td>
            <td>
                {if $row.library_eol}
                    Library End of Life
                {elseif $row.current_version_name == $row.latest_version_name}
                    Yes
                {else}
                    No
                {/if}
            </td>
            <td>{$row.days}</td>
            {if $logged_in}
                <td><a href="edit_application_library_version.php?id={$row.applib_id}">Edit</a></td>
                <td>
                    <form id="delete_application_library_version_{$row.applib_id}" name="delete_application_library_version[{$row.applib_id}]" method="post" action="submit_delete_application_library_version.php">
                        <p>
                            <input id="applib_id_{$row.applib_id}" name="applib_id" type="hidden" value="{$row.applib_id}" />
                            <input id="delete_application_library_version_submit_{$row.applib_id}" name="delete_application_library_version[{$row.applib_id}]_submit" type="submit" value="Delete" />
                        </p>
                    </form>
                </td>
            {/if}
        </tr>   
    {/foreach}
</table>
{include file="footer.tpl"}
