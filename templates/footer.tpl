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

			    </div> <!-- content -->
	            <div id="ad">
	                {if showGoogleAdSense}
                        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                        <ins class="adsbygoogle"
                             style="display:inline-block;width:160px;height:600px"
                             data-ad-client="{$googleAdSenseClient}"
                             data-ad-slot="{$googleAdSenseSlot}"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    {/if}
	            </div> <!-- ad -->
	        </div><!-- content wrapper -->
		    <div id="footer">
			    <p>&copy; 2014 David Robinson</p>
			    <p>Contact: {$contactEmailAddress}</p>
		    </div>	<!-- footer -->
		</div> <!-- container -->
		{if $showGoogleAnalytics}
		    <script>
                (function(i,s,o,g,r,a,m) { i['GoogleAnalyticsObject']=r;i[r]=i[r]||function() { 
                (i[r].q=i[r].q||[]).push(arguments) } ,i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                } )(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                ga('create', '{$googleAnaylticsCode}', '{$googleAnaylticsSiteName}');
                ga('send', 'pageview');
            </script>
        {/if}
	</body>
</html>
