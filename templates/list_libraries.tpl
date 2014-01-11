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
        <th>Library Name</th><th>Latest Version</th><th>Release Date</th>    
    </tr>
    {foreach from=$libraries item=row}
        <tr>
            <td><a href="view_library.php?id={$row.library_id}">{$row.library_name|escape:'htmlall'}</a></td>
            {if $row.library_eol}
                <td>End of Life</td>
                <td>{$row.library_eol_date|escape:'htmlall'}</td>
            {else}
                <td>{$row.version_name|escape:'htmlall'}</td>
                <td>{$row.version_release_date|escape:'htmlall'}</td>
            {/if}
        </tr>
    {/foreach}
</table>

{include file="footer.tpl"}
