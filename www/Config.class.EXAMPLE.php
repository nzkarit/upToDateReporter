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

class Config {

    /**
    * The Database connection details
    */
	var $db_connection_variables = array(
        'username' => 'USERNAME',
        'password' => 'PASSWORD',
        'host' => 'HOSTNAME or IP',
        'database' => 'NAME of DATABASE'
    );
		
    //Remember the trailing slash it is assumed where it gets used.	
    var $siteBaseURL = 'https://example.com/';
    
    var $smartyTemplateDir = '/home/user/upToDateReporter/templates/';
    var $smartyCompileDir = '/home/user/upToDateReporter/templates/templates_c/';
    var $smartyCacheDir = '/home/user/upToDateReporter/templates/cache/';
    var $smartyConfigDir = '/home/user/upToDateReporter/templates/configs/';
    

    /*
    * The work factor to be used in the password hashing
    *
    * The following page has a script for calculting the work factor 
    * http://nz1.php.net/manual/en/function.password-hash.php
    */
    var $workFactor = 10;
    
    /*
    * The algorithm to use in the password hashing
    *
    * http://nz1.php.net/manual/en/password.constants.php
    */
    var $passwordAlgorithm = PASSWORD_DEFAULT;
    
    /*
    * The email address the confirmation emails will be sent from
    */
    var $fromEmailAddress = 'noreply@example.com';
    
    var $appName = 'Up To Date Reporter';
    var $appVersion = '0.01';
    
    
    //TODO Plumb in 
    var $readOnlyMode = false;
    var $showBitcoinAd = true;
    var $bitcoinAddress = '';
    var $showGoogleAdSense = true;
    var $googleAdSenseCode = '';
    var $showGoogleAnalytics = true;
    var $googleAnaylticsCode = '';
    var $showDonationPage = true;
    var $useReCaptcha = false;
    var $reCaptchaPrivateKey = '';
    var $reCaptchaPublicKey = '';



    function Config() {
        date_default_timezone_set('UTC');
    }
    
    function getDBConnectionVariables(){
        return $this->db_connection_variables; 
    }
    
    function getSiteBaseURL(){
        return $this->siteBaseURL;
    }

    function getSmartyTemplateDir(){
        return $this->smartyTemplateDir;
    }
    
    function getSmartyCompileDir(){
        return $this->smartyCompileDir;
    }
    
    function getSmartyCacheDir(){
        return $this->smartyCacheDir;
    }
    
    function getSmartyConfigDir(){
        return $this->smartyConfigDir;
    }
    
    function getWorkFactor(){
        return $this->workFactor;
    }
    
    function getPasswordAlgorithm(){
        return $this->passwordAlgorithm;
    }
    
    function getAppName(){
        return $this->appName;
    }
    
    function getAppVersion(){
        return $this->appVersion;     
    }
    
    function getFromEmailAddress(){
        return $this->fromEmailAddress;
    }
 }
?>
