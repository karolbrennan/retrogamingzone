<?php
/**
 * Created by PhpStorm.
 * User: karolbrennan
 * Date: 12/12/14
 * Time: 9:44 PM
 */

namespace services;


class Wishlist {


    /**
     * Gets the wishlist of games for the current user
     *
     * @return array of games
     */
    public static function getCurrentUserGameWishlist(){
        $userid = \services\User::getCurrentUserId();
        $db = DatabaseConnection::getConnection();
        $sql = "select gameid from wishlist where userid=$userid";
        $results = $db->select($sql);
        $games = array();
        foreach($results as $game) {
            $gameid = intval($game['gameid']);
            if($gameid !== 0) {
                $games[] = \services\Game::getGameById($gameid);
            }
        }
        return $games;
    }

    /**
     * Checks the current user's wishlist for a game via gameid
     *
     * @param int $gameid the passed in game id
     * @return bool tells whether the game exists in the user's wishlist
     */
    public static function checkCurrentUserWishlistForGame($gameid){
        $userid = \services\User::getCurrentUserId();
        $gameid = intval($gameid);
        $db = DatabaseConnection::getConnection();
        $sql = "select gameid from wishlist where userid=$userid and gameid=$gameid";
        $result = $db->select($sql);
        if(count($result) >= 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets the wishlist of consoles for the current user
     *
     * @return array of console objects
     */
    public static function getCurrentUserConsoleWishlist(){
        $userid = \services\User::getCurrentUserId();
        $db = DatabaseConnection::getConnection();
        $sql = "select wishlist.consoleid, consoles.*
                from wishlist
                left join consoles on wishlist.consoleid = consoles.id where userid='$userid'";
        $results = $db->select($sql);
        $consoles = array();
        foreach($results as $console){
            $consoleid = intval($console['consoleid']);
            if($consoleid !== 0){
                $consoles[] = new \models\Console($consoleid, $console['name'], $console['year']);
            }
        }
        return $consoles;
    }


    /**
     * Checks the current user's wishlist for a console via the console id
     *
     * @param int $consoleid passed in console id
     * @return bool retuns whether the console exists in the user's wishlist
     */
    public static function checkCurrentUserWishlistForConsole($consoleid){
        $userid = \services\User::getCurrentUserId();
        $consoleid = intval($consoleid);
        $db = DatabaseConnection::getConnection();
        $sql = "select consoleid from wishlist where userid=$userid and consoleid=$consoleid";
        $result = $db->select($sql);
        if(count($result) >= 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Adds game to wishlist
     *
     * @param int $gameid
     */
    public static function addGameToWishlist($gameid) {
        $userid = \services\User::getCurrentUserId();
        $db = DatabaseConnection::getConnection();
        $sql = "insert into wishlist (userid, gameid) values ({$userid}, {$gameid})";
        $db->insert($sql);
    }

    /**
     * Removes game from wishlist
     *
     * @param int $gameid
     */
    public static function removeGameFromWishlist($gameid) {
        $userid = \services\User::getCurrentUserId();
        $db = DatabaseConnection::getConnection();
        $sql = "delete from wishlist where userid='$userid' and gameid='$gameid'";
        $db->delete($sql);
    }


    /**
     * Adds console to wishlist
     *
     * @param int $consoleid
     */
    public static function addConsoleToWishlist($consoleid) {
        $userid = \services\User::getCurrentUserId();
        $db = DatabaseConnection::getConnection();
        $sql = "insert into wishlist (userid, consoleid) values ({$userid}, {$consoleid})";
        $db->insert($sql);
    }

    /**
     * Removes console from wishlist
     *
     * @param int $consoleid
     */
    public static function removeConsoleFromWishlist($consoleid) {
        $userid = \services\User::getCurrentUserId();
        $db = \services\DatabaseConnection::getConnection();
        $sql = "delete from wishlist where userid='$userid' and consoleid='$consoleid'";
        $db->delete($sql);
    }
} 