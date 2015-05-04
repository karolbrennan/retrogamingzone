<?php
/**
 * Created by PhpStorm.
 * User: karolbrennan
 * Date: 11/11/14
 * Time: 6:00 PM
 */

namespace controllers;
use core\view as View;
use services\Game;


class Manage extends BaseController {

    /**
     * Displays the index page and passes relevant data to it
     */
    public function indexPage()
    {
        Auth::redirectToLoginIfNotLoggedIn();
        $data = array();
        $data['title'] = "Dashboard";
        $data['message'] = "Check out your progress here!";
        $data['error'] = \helpers\session::pull('errors');
        $data['user'] = \helpers\session::get('user');
        $userid = \services\User::getCurrentUserId();
        $data['achievements'] = \services\Achievements::getUserAchievements($userid);

        // render templates and pass data to them
        View::rendertemplate('header', $data);
        View::render('manage/index', $data);
        View::rendertemplate('footer', $data);
    }

    /**
     * Displays all of the available achievements
     */
    public function achievementsPage(){
        Auth::redirectToLoginIfNotLoggedIn();
        $data = array();
        $data['title'] = "Available Achievements";
        $data['achievements'] = \services\Achievements::getAchievements();

        View::rendertemplate('header', $data);
        View::render('manage/achievements', $data);
        View::rendertemplate('footer', $data);
    }

    /**
     * Displays the collection page and passes relevant data to it
     */
    public function collectionPage()
    {
        Auth::redirectToLoginIfNotLoggedIn();
        $data = array();

        $data['title'] = 'My Collection';
        $data['no-games'] = "You don't have any games yet - why not add some to your collection?";
        $data['no-consoles'] = "You don't have any consoles yet - why not add some to your collection?";
        $data['user'] = \helpers\session::get('user');

        $data['games'] = \services\Collection::getCurrentUserGameCollection();
        $data['consoles'] = \services\Collection::getCurrentUserConsoleCollection();

        View::rendertemplate('header', $data);
        View::render('manage/collection', $data);
        View::rendertemplate('footer', $data);

    }

    /**
     * Displays the wishlist page and passes relevant data to it
     */
    public function wishlistPage()
    {
        Auth::redirectToLoginIfNotLoggedIn();
        $data = array();

        $data['title'] = 'My Wishlist';
        $data['no-games'] = "You don't have any games yet - why not add some to your wishlist?";
        $data['no-consoles'] = "You don't have any consoles yet - why not add some to your wishlist?";

        $data['games'] = \services\Wishlist::getCurrentUserGameWishlist();
        $data['consoles'] = \services\Wishlist::getCurrentUserConsoleWishlist();

        View::rendertemplate('header', $data);
        View::render('manage/wishlist', $data);
        View::rendertemplate('footer', $data);

    }

    /**
     * Adds game to collection
     */
    public static function addGameToCollection()
    {
        $user = \helpers\session::get('user');
        $userid = intval($user->id);
        $userExists = \services\User::checkIfUserExistsById($userid);
        if($userExists) {
            if (isset($_GET['gameid'])) {
                $gameid = filter_input(INPUT_GET, 'gameid', FILTER_SANITIZE_NUMBER_INT);
                $inCollection = \services\Collection::checkCurrentUserCollectionForGame($gameid);
                $inWishlist = \services\Wishlist::checkCurrentUserWishlistForGame($gameid);
                if ($inCollection === false) {
                    \services\Collection::addGameToCollection($gameid);
                    \services\Achievements::addAchievementIfDoesNotExist($gameid);
                    if ($inWishlist === true) {
                        \services\Wishlist::removeGameFromWishlist($gameid);
                    }
                }
            }
        } else {
            $array = array(
                "redirect" => true,
                "url" => "/login"
            );
            echo json_encode($array);
            exit();
        }
    }

    /**
     * Adds game to wishlist
     */
    public static function addGameToWishlist()
    {
        $user = \helpers\session::get('user');
        $userid = intval($user->id);
        $userExists = \services\User::checkIfUserExistsById($userid);
        if($userExists) {
            if (isset($_GET['gameid'])) {
                $gameid = filter_input(INPUT_GET, 'gameid', FILTER_SANITIZE_NUMBER_INT);
                $inCollection = \services\Collection::checkCurrentUserCollectionForGame($gameid);
                $inWishlist = \services\Wishlist::checkCurrentUserWishlistForGame($gameid);
                if($inWishlist === false) {
                    \services\Wishlist::addGameToWishlist($gameid);
                    if ($inCollection === true) {
                        \services\Collection::removeGameFromCollection($gameid);
                    }

                }
            }
        } else {
            $array = array(
                "redirect" => true,
                "url" => "/login"
            );
            echo json_encode($array);
            exit();
        }
    }

    /**
     * Removes game from collection
     */
    public static function removeGameFromCollection()
    {
        $user = \helpers\session::get('user');
        $userid = intval($user->id);
        $userExists = \services\User::checkIfUserExistsById($userid);
        if($userExists) {
            if (isset($_GET['gameid'])) {
                $gameid = filter_input(INPUT_GET, 'gameid', FILTER_SANITIZE_NUMBER_INT);
                $inCollection = \services\Collection::checkCurrentUserCollectionForGame($gameid);
                if($inCollection === true) {
                    \services\Collection::removeGameFromCollection($gameid);
                }
            }
        } else {
            $array = array(
                "redirect" => true,
                "url" => "/login"
            );
            echo json_encode($array);
            exit();
        }
    }

    /**
     * Removes game from wishlist
     */
    public static function removeGameFromWishlist()
    {
        $user = \helpers\session::get('user');
        $userid = intval($user->id);
        $userExists = \services\User::checkIfUserExistsById($userid);
        if($userExists) {
            if (isset($_GET['gameid'])) {
                $gameid = filter_input(INPUT_GET, 'gameid', FILTER_SANITIZE_NUMBER_INT);
                $inWishlist = \services\Wishlist::checkCurrentUserWishlistForGame($gameid);
                if($inWishlist === true) {
                    \services\Wishlist::removeGameFromWishlist($gameid);
                }
            }
        } else {
            $array = array(
                "redirect" => true,
                "url" => "/login"
            );
            echo json_encode($array);
            exit();
        }
    }

    /**
     * Adds console to collection
     */
    public static function addConsoleToCollection()
    {
        $user = \helpers\session::get('user');
        $userid = intval($user->id);
        $userExists = \services\User::checkIfUserExistsById($userid);
        if($userExists) {
            if (isset($_GET['consoleid'])) {
                $consoleid = filter_input(INPUT_GET, 'consoleid', FILTER_SANITIZE_NUMBER_INT);
                $inCollection = \services\Collection::checkCurrentUserCollectionForConsole($consoleid);
                $inWishlist = \services\Wishlist::checkCurrentUserWishlistForConsole($consoleid);
                if($inCollection === false) {
                    \services\Collection::addConsoleToCollection($consoleid);
                    if($inWishlist === true){
                        \services\Wishlist::removeConsoleFromWishlist($consoleid);
                    }
                }
            }
        } else {
            $array = array(
                "redirect" => true,
                "url" => "/login"
            );
            echo json_encode($array);
            exit();
        }
    }

    /**
     * Adds console to wishlist
     */
    public static function addConsoleToWishlist()
    {
        $user = \helpers\session::get('user');
        $userid = intval($user->id);
        $userExists = \services\User::checkIfUserExistsById($userid);
        if($userExists) {
            if (isset($_GET['consoleid'])) {
                $consoleid = filter_input(INPUT_GET, 'consoleid', FILTER_SANITIZE_NUMBER_INT);
                $inCollection = \services\Collection::checkCurrentUserCollectionForConsole($consoleid);
                $inWishlist = \services\Wishlist::checkCurrentUserWishlistForConsole($consoleid);
                if ($inWishlist === false) {
                    \services\Wishlist::addConsoleToWishlist($consoleid);
                    if ($inCollection === true) {
                        \services\Collection::removeConsoleFromCollection($consoleid);
                    }
                }
            }
        } else {
            $array = array(
                "redirect" => true,
                "url" => "/login"
            );
            echo json_encode($array);
            exit();
        }
    }

    /**
     * Remove console from collection
     */
    public static function removeConsoleFromCollection()
    {
        $user = \helpers\session::get('user');
        $userid = intval($user->id);
        $userExists = \services\User::checkIfUserExistsById($userid);
        if($userExists) {
            if (isset($_GET['consoleid'])) {
                $consoleid = filter_input(INPUT_GET, 'consoleid', FILTER_SANITIZE_NUMBER_INT);
                $inCollection = \services\Collection::checkCurrentUserCollectionForConsole($consoleid);
                if($inCollection === true) {
                    \services\Collection::removeConsoleFromCollection($consoleid);
                }
            }
        } else {
            $array = array(
                "redirect" => true,
                "url" => "/login"
            );
            echo json_encode($array);
            exit();
        }
    }

    /**
     * Remove console from wishlist
     */
    public static function removeConsoleFromWishlist()
    {
        $user = \helpers\session::get('user');
        $userid = intval($user->id);
        $userExists = \services\User::checkIfUserExistsById($userid);
        if($userExists) {
            if (isset($_GET['consoleid'])) {
                $consoleid = filter_input(INPUT_GET, 'consoleid', FILTER_SANITIZE_NUMBER_INT);
                $inWishlist = \services\Wishlist::checkCurrentUserWishlistForConsole($consoleid);
                if($inWishlist === true){
                    \services\Wishlist::removeConsoleFromWishlist($consoleid);
                }
            }
        } else {
            $array = array(
                "redirect" => true,
                "url" => "/login"
            );
            echo json_encode($array);
            exit();
        }
    }
} 