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

        <form id="add_new_version" name="add_new_version" method="post" action="submit_add_new_version.php">
            <table>
                <tr>
                    <td>
                        <label for="version_name">Version Name/Number: </label>
                    </td>
                    <td>
                        <input id="version_name" name="version_name" type="text" maxlength="255" value="" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="version_release_notes">Release Notes URL: </label>
                    </td>
                    <td>
                        <input id="version_release_notes" name="version_release_notes" type="text" maxlength="255" value="" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="version_release_date">Release Date (YYYY-MM-DD): </label>
                    </td>
                    <td>
                        <input id="version_release_date" name="version_release_date" type="text" maxlength="10" value="{$date}" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="version_number_of_fixes">Number of fixes (total): </label>
                    </td>
                    <td>
                        <input id="version_number_of_fixes" name="version_number_of_fixes" type="text" maxlength="3" value="0" /> (This number in the future will added to reported and summed between the current version and the version you are using to give a feeling of how bad it is. The number of fixed includes the number of security fixes.)
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="version_number_of_security_fixes">Number of Security fixes (just ones labeled as security): </label>
                    </td>
                    <td>
                        <input id="version_number_of_security_fixes" name="version_number_of_security_fixes" type="text" maxlength="3" value="0" /> (This number in the future will added to reported and summed between the current version and the version you are using to give a feeling of how bad it is.)
                    </td>
                </tr>
            </table>
            <p><input id="library_id" name="library_id" type="hidden" value="{$library_id}" />
            <input id="add_new_version_submit" name="add_new_version_submit" type="submit" value="Add New Version" />       </p>
        </form>

{include file="footer.tpl"}
