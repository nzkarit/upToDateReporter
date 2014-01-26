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
"Library Name","Library Use","Used Version","Used Version Release Date","Latest Version","Latest Version Release Date","Up to Date","Days since used version no longer the latest","Number of Fixes","Number of Security Fixes"
{foreach from=$uses item=row}
"{$row.library_name}","{$row.applib_description}","{$row.current_version_name}","{$row.current_version_release_date}","{$row.latest_version_name}","{$row.latest_version_release_date}","{if $row.library_eol}Library End of Life{elseif $row.current_version_name == $row.latest_version_name}Yes{else}No{/if}","{$row.days}","{$row.number_fixes}","{$row.number_security_fixes}"
{/foreach}
