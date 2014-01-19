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

<p>Welcome to Up To Date Reporter. Up To Date Reporter is a tool to help you keep track of the Third Party Libraries which you use in your applications and help you ensure that they are up to date. The main driver being that these updates often include security fixes. In my time I have seen lots of applications running old libraries, people know that they are out of date but often find creating the list of out of date libraries time consuming, so hopefully this tool can help with that. Without this list as a starting point its hard to get signoff to get an library update project done. This site is collecting the number of security fixes in each version update. so that in the future the report can add the number of security fixes to help add weight for the need to spend time doing the updating of libraries rather than me features or bug fixes.</p>

<p>You can set your application up here listing the libraries and the versions that you use. It will then generate a report saying if you are up to date or not. Your application will be stored so you can come back to it at a later date. You have can have a look at the <a href="view_sample_application.php">sample application</a>, to see what the report looks like.</p>

<p>If you <a href="signup.php">sign up</a> you can help keep the list of libraries and versions up to date, by adding new ones when they become available. To keep the quality good new entries are added to the <a href="list_moderator_queue.php">moderation queue</a> before going live.</p>

<p>I am aware that some people won't be comfortable telling an internet site which versions they use, so this tool is open source and <a href="https://github.com/nzkarit/upToDateReporter">the code is available on GitHub</a>, so you can run your own instance. In the future I will be looking at providing DB dumps and/or an API so your instance can stay in sync with all the version and library updates. This hasn't been setup yet but please get in touch me as we may be able to arrange something. Would this also be something people would give a donation for? Only looking to cover hosting, domain name and SSL cert so ~$200 a year would help cover things. Yes this site has ads but I assume like me most of you will be running an ad blocker. If get enough donations will disable ads.</p>

<p>Do you see this tool being useful? Are there things that will make it more useful? I created this to scratch my own itch but not sure if others also need it? If you have questions, comments, suggestions, ideas, bugs etc please get in touch. up to date reporter AT gmail DOT com</p>

<p>I have a <a href="roadmap.php">roadmap</a> page where I have laid out some of my ideas of where I would like to see this go.</p>

{include file="footer.tpl"}
