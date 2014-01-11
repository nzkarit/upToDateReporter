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
        <td>{$library_name}</td>
    </tr>
    <tr>
        <td>URL:</td>
        <td><a href="{$library_url}">{$library_url}</a></td>
    </tr>
    {if $library_eol}
        <tr>
            <td>End of Life:</td>
            <td>Yes</td>
        </tr>
        <tr>
            <td>End of Life Date:</td>
            <td>{$library_eol_date}</td>
        </tr>
    {else}
        <tr>
            <td>End of Life:</td>
            <td>No</td>
        </tr>
    {/if}
</table>
{if $logged_in}<a href="add_new_version.php?id={$library_id}">Add New Version to Library</a>{/if}
<table border="1">
    <tr>
        <th>Version Name</th>
        <th>Version Release Date</th>
        <th>Version Release Notes</th>
        <th>Number of Fixes</th>
        <th>Number of Security Fixes</th>
    </tr>
    {foreach from=$versions item=row}
        <tr>
            <td>{$row.version_name}</td>
            <td>{$row.version_release_date}</td>
            <td><a href="{$row.version_release_notes}">{$row.version_release_notes}</a></td>
            <td>{$row.version_number_of_fixes}</td>
            <td>{$row.version_number_of_security_fixes}</td>
        </tr>   
    {/foreach}
</table>

{include file="footer.tpl"}
