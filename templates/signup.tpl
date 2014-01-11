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
<form id="signup" name="signup" method="post" action="submit_signup.php">
    <table>
        <tr>
            <td>
                <label for="user_email">Email: </label>
            </td>
            <td>
                <input id="user_email" name="user_email" type="text" maxlength="255" value="" />
            </td>
        </tr>
        <tr>  
            <td>   
                <label for="user_password">Password: </label>
            </td>
            <td>
                <input id="user_password" name="user_password" type="password" maxlength="255" value="" /> (at least eight characters (<a href="http://arstechnica.com/security/2013/09/long-passwords-are-good-but-too-much-length-can-be-bad-for-security/">and less than 256</a>) and I will leave the rest up to you)
            </td>
        </tr>
    </table> 
    <input id="signup" name="signup" type="submit" value="Signup" /> (Please be patience it can take a while, while it sends the email it will show a confirmation page in the end)      
</form>
{include file="footer.tpl"}
