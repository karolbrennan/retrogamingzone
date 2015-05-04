<?php
include(__DIR__ . "/vendor/FirePHPCore/fb.php");
if(file_exists('vendor/autoload.php')){
    require 'vendor/autoload.php';
} else {
    echo "<h1>Please install via composer.json</h1>";
    echo "<p>Install Composer instructions: <a href='https://getcomposer.org/doc/00-intro.md#globally'>https://getcomposer.org/doc/00-intro.md#globally</a></p>";
    echo "<p>Once composer is installed navigate to the working directory in your terminal/command promt and enter 'composer install'</p>";
    exit;
}

if (!is_readable('app/core/config.php')) {
    die('No config.php found, configure and rename config.example.php to config.php in app/core.');
}

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 *
 */
define('ENVIRONMENT', 'development');
/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but production will hide them.
 */

if (defined('ENVIRONMENT')){

    switch (ENVIRONMENT){
        case 'development':
            error_reporting(E_ALL);
            break;

        case 'production':
            error_reporting(0);
            break;

        default:
            exit('The application environment is not set correctly.');
    }

}

// turn on / off display errors
ini_set('display_errors', '1');

//initiate config
new \core\config();

//create alias for Router
use \core\router as Router,
    \helpers\url as Url;

//define routes
Router::any('', '\controllers\Index@index');
Router::any('/', '\controllers\Index@index');

Router::any('/register', '\controllers\Register@registrationPage');
Router::any('/register/process', '\controllers\Register@processRegistration');

Router::any('/login', '\controllers\Auth@loginPage');
Router::any('/logout', '\controllers\Auth@logoutPage');
Router::any('/login/process', '\controllers\Auth@processLogin');
Router::any('/logout/process', '\controllers\Auth@processLogout');

Router::any('/admin', '\controllers\Admin@indexPage');
Router::any('/admin/consoles', '\controllers\Admin@consoles');
Router::any('/admin/games', '\controllers\Admin@games');
Router::any('/admin/developers', '\controllers\Admin@developers');
Router::any('/admin/publishers', '\controllers\Admin@publishers');
Router::any('/admin/genres', '\controllers\Admin@genres');
Router::any('/admin/ratings', '\controllers\Admin@ratings');
Router::any('/admin/users', '\controllers\Admin@users');

Router::any('/manage', '\controllers\Manage@indexPage');
Router::any('/manage/account', '\controllers\Manage@accountPage');
Router::any('/manage/collection', '\controllers\Manage@collectionPage');
Router::any('/manage/collection/addgame','\controllers\Manage@addGameToCollection');
Router::any('/manage/collection/removegame','\controllers\Manage@removeGameFromCollection');
Router::any('/manage/collection/addconsole','\controllers\Manage@addConsoleToCollection');
Router::any('/manage/collection/removeconsole','\controllers\Manage@removeConsoleFromCollection');
Router::any('/manage/wishlist', '\controllers\Manage@wishlistPage');
Router::any('/manage/wishlist/addgame','\controllers\Manage@addGameToWishlist');
Router::any('/manage/wishlist/removegame','\controllers\Manage@removeGameFromWishlist');
Router::any('/manage/wishlist/addconsole','\controllers\Manage@addConsoleToWishlist');
Router::any('/manage/wishlist/removeconsole','\controllers\Manage@removeConsoleFromWishlist');

Router::any('/games', '\controllers\Games@gamesListingPage');
Router::any('/consoles', '\controllers\Consoles@consolesListingPage');

Router::any('/scraper', '\controllers\Scraper@index');

Router::any('/achievements','\controllers\Manage@achievementsPage');
Router::any('/leaderboard/update','\controllers\Index@leaderboardUpdate');

//if no route found
Router::error('\core\error@index');

//turn on old style routing
Router::$fallback = true;

//execute matched routes
Router::dispatch();
