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

        <form id="add_new_library_to_application" name="add_new_library_to_application" method="post" action="submit_add_new_library_to_application.php">
            <table>
                <tr>
                    <td>
                        <label for="library_id">Library Name: </label>
                    </td>
                    <td>
                        {html_options name=library_id options=$libraries}
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="applib_description">Use of library in Application: </label>
                    </td>
                    <td>
                        <input id="applib_description" name="applib_description" type="text" maxlength="255" value="" />
                    </td>
                </tr>
            </table>
            <p><input id="application_id" name="application_id" type="hidden" value="{$application_id}" />
            <input id="add_new_application_to_library_submit" name="add_new_application_to_library_submit" type="submit" value="Add New Library" /></p>
        </form>

{include file="footer.tpl"}
