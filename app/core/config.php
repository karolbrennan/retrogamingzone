<?php namespace core;

class Config {

    public function __construct() {

        //turn on output buffering
        ob_start();

        //site address
        define('DIR', 'http://retrogaming.zone/');

        //set default controller and method for legacy calls
        define('DEFAULT_CONTROLLER', 'index');
        define('DEFAULT_METHOD' , 'index');

        //set a default language
        define('LANGUAGE_CODE', 'en');

        //database details ONLY NEEDED IF USING A DATABASE
        // should include:
        // define('DB_TYPE','mysql');
//        define('DB_HOST', 'localhost');
//        define('DB_NAME', 'DB NAME');
//        define('DB_USER', 'DB USER');
//        define('DB_PASS', 'DB PASSWORD');
//        define('PREFIX', 'DB PREFIX');

        require('credentials.php');

        //set prefix for sessions
        define('SESSION_PREFIX', 'rgz_');

        //optionall create a constant for the name of the site
        define('SITETITLE', 'Retro Gaming Zone');

        //turn on custom error handling
        set_exception_handler('core\logger::exception_handler');
        set_error_handler('core\logger::error_handler');

        //set timezone
        date_default_timezone_set('America/Chicago');

        //start sessions
        \helpers\session::init();

        //set the default template
        \helpers\session::set('template', 'default');
    }

}
