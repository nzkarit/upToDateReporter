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
{if $admin || $mod}<form id="moderator_queue" name="moderator_queue" method="post" action="submit_moderator_queue.php">{/if}
    <table border="1">
        <tr>
            <th>Library Name</th><th>Library URL</th>{if $admin || $mod}<th>User Email</th>{/if}{if $admin || $mod}<th>Approve</th>{/if}
        </tr>
        {foreach from=$libraries item=row}
            <tr>
                <td>{$row.library_name}</td>
                <td>{$row.library_url}</td>
                {if $admin || $mod}<td>{$row.user_email}</td>{/if}
                {if $admin || $mod}<td><input id="library[{$row.library_id}]" name="library[{$row.library_id}]" type="checkbox" /></td>{/if}
            </tr>
        {/foreach}
    </table>
    
    <table border="1">
        <tr>
            <th>Library Name</th><th>Version Name</th><th>Version Release Date</th><th>Version URL</th><th>Fixes</th><th>Security Fixes</th>{if $admin || $mod}<th>User Email</th>{/if}{if $admin || $mod}<th>Approve</th>{/if}
        </tr>
        {foreach from=$versions item=row}
            <tr>
                <td>{$row.library_name}</td>
                <td>{$row.version_name}</td>
                <td>{$row.version_release_date}</td>
                <td>{$row.version_release_notes}</td>
                <td>{$row.version_number_of_fixes}</td>
                <td>{$row.version_number_of_security_fixes}</td>
                {if $admin || $mod}<td>{$row.user_email}</td>{/if}
                {if $admin || $mod}<td><input id="version[{$row.version_id}]" name="version[{$row.version_id}]" type="checkbox" /></td>{/if}
            </tr>
        {/foreach}    
    </table>
    {if $admin || $mod}<p><input id="submit" name="submit" type="submit" value="Submit" /></p>{/if}
{if $admin || $mod}</form>{/if}
<p>Records you have entered don't show up in list. If you want to see the ones you have entered please log out. This is to do with not being able to moderate your own entries</p>
{include file="footer.tpl"}
