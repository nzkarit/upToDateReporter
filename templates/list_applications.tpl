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

<table border="1">
    <tr>
        <th>Application Name</th> <th>Delete</th>   
    </tr>
    {foreach from=$applications item=row}
        <tr>
            <td><a href="view_application.php?id={$row.application_id}">{$row.application_name}</a></td>        
            <td>
                <form id="delete_application_{$row.application_id}" name="delete_application[{$row.application_id}]" method="post" action="submit_delete_application.php">
                    <p>
                        <input id="application_id_{$row.application_id}" name="application_id" type="hidden" value="{$row.application_id}" />
                        <input id="delete_application_submit_{$row.application_id}" name="delete_application_[{$row.applib_id}]_submit" type="submit" value="Delete" />
                    </p>
                </form>
            </td>
       </tr>
    {/foreach}
</table>

{include file="footer.tpl"}
