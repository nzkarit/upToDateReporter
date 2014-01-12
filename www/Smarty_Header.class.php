<?php
/**
* This file is part of Up To Date Reporter.
*
* Up To Date Reporter is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Up To Date Reporter is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Up To Date Reporter.  If not, see <http://www.gnu.org/licenses/>.
*
* (c)Copyright 2014 David Robinson (copyright AT karit DOT geek DOT nz)
*/

require_once('Config.class.php');
require_once('/usr/share/php/smarty3/Smarty.class.php');
class Smarty_Header {

    var $smarty;
    var $template;
    var $config = null;
    
    function Smarty_Header($template) {
        $this->config = new Config();
        $this->smarty = new Smarty();
        $my_security_policy = new Smarty_Security($this->smarty);
        $my_security_policy->php_functions = null;
        $my_security_policy->php_handling = Smarty::PHP_REMOVE;
        $my_security_policy->php_modifiers = null;
        $this->smarty->enableSecurity($my_security_policy);
        $this->template = $template;
        
        $this->assign('appName', $this->config->appName);
        $this->assign('appVersion', $this->config->appVersion);
        $this->assign('baseURL', $this->config->getSiteBaseURL());
        $this->assign('showGoogleAnalytics', $this->config->getShowGoogleAnalytics());
        $this->assign('googleAnaylticsCode', $this->config->getGoogleAnaylticsCode());
        $this->assign('googleAnaylticsSiteName', $this->config->getGoogleAnaylticsSiteName());

        $this->smarty->template_dir = $this->config->getSmartyTemplateDir();
        $this->smarty->compile_dir = $this->config->getSmartyCompileDir();
        $this->smarty->cache_dir = $this->config->getSmartyCacheDir();
        $this->smarty->config_dir = $this->config->getSmartyConfigDir();
        $this->smarty->default_modifiers = array('escape:"htmlall"');
    }
    
	/**
	* This will changfe the template which is currently set
	*/
    function changeTemplate($template){
       $this->template = $template; 
    }
    
	/**
	* This will assign a name value pair for a template 
	*/
    function assign($name, $value){
        $this->smarty->assign($name,$value);
    }
    
	/**
	* This is called when you have finished adding name value paris and you want to render the page
	*/
    function display(){
        $this->smarty->display($this->template);   
    }
    
	/**
	* This will get the base URL of the page
	*/
    function getBaseURL(){
        return $this->siteBaseURL;
    } 
}
?>
