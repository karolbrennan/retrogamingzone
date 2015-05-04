<?php
/**
 * Created by PhpStorm.
 * User: karolbrennan
 * Date: 12/12/14
 * Time: 9:44 PM
 */

namespace services;


class Collection {


    /**
     * Gets the collection of games for the current user
     *
     * @return array of games
     */
    public static function getCurrentUserGameCollection(){
        $userid = \services\User::getCurrentUserId();
        $db = DatabaseConnection::getConnection();
        $sql = "select gameid from collection where userid=$userid";
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
     * Gets the number of games in the current user's collection
     *
     * @return int number of games
     */
    public static function getCurrentUserGameCountCollection(){
        $userid = \services\User::getCurrentUserId();
        $db = DatabaseConnection::getConnection();
        $sql = "select count(gameid) as cnt from collection where userid=$userid";
        $results = $db->select($sql);
        return $results[0]['cnt'];
    }

    /**
     * Checks the current user's collection for a game via gameid
     *
     * @param int $gameid the passed in game id
     * @return bool tells whether the game exists in the user's collection
     */
    public static function checkCurrentUserCollectionForGame($gameid){
        $userid = \services\User::getCurrentUserId();
        $gameid = intval($gameid);
        $db = DatabaseConnection::getConnection();
        $sql = "select gameid from collection where userid=$userid and gameid=$gameid";
        $result = $db->select($sql);
        if(count($result) >= 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets the collection of consoles for the current user
     *
     * @return array of console objects
     */
    public static function getCurrentUserConsoleCollection(){
        $userid = \services\User::getCurrentUserId();
        $db = DatabaseConnection::getConnection();
        $sql = "select collection.consoleid, consoles.*
                from collection
                left join consoles on collection.consoleid = consoles.id where userid='$userid'";
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
     * Checks the current user's collection for a console via the console id
     *
     * @param int $consoleid passed in console id
     * @return bool retuns whether the console exists in the user's collection
     */
    public static function checkCurrentUserCollectionForConsole($consoleid){
        $userid = \services\User::getCurrentUserId();
        $consoleid = intval($consoleid);
        $db = DatabaseConnection::getConnection();
        $sql = "select consoleid from collection where userid=$userid and consoleid=$consoleid";
        $result = $db->select($sql);
        if(count($result) >= 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Adds game to collection
     *
     * @param int $gameid
     */
    public static function addGameToCollection($gameid) {
        $userid = \services\User::getCurrentUserId();
        $db = DatabaseConnection::getConnection();
        $sql = "insert into collection (userid, gameid) values ({$userid}, {$gameid})";
        $db->insert($sql);
    }

    /**
     * Removes game from collection
     *
     * @param int $gameid
     */
    public static function removeGameFromCollection($gameid) {
        $userid = \services\User::getCurrentUserId();
        $db = DatabaseConnection::getConnection();
        $sql = "delete from collection where userid='$userid' and gameid='$gameid'";
        $db->delete($sql);
    }

    /**
     * Adds console to collection
     *
     * @param int $consoleid
     */
    public static function addConsoleToCollection($consoleid) {
        $userid = \services\User::getCurrentUserId();
        $db = DatabaseConnection::getConnection();
        $sql = "insert into collection (userid, consoleid) values ({$userid}, {$consoleid})";
        $db->insert($sql);
    }

    /**
     * Removes console from collection
     *
     * @param int $consoleid
     */
    public static function removeConsoleFromCollection($consoleid) {
        $userid = \services\User::getCurrentUserId();
        $db = DatabaseConnection::getConnection();
        $sql = "delete from collection where userid='$userid' and consoleid='$consoleid'";
        $db->delete($sql);
    }

    /**
     * Gets the number of games a user has in their collection for a specific console
     *
     * @param $userid
     * @param $consoleid
     * @return int number of games for console
     */
    public static function getGameCountForConsoleFromUserCollection($userid, $consoleid){
        $db = DatabaseConnection::getConnection();
        $sql = "select games.console_id, collection.userid, collection.gameid
                from games inner join collection
                on games.id = collection.gameid
                where gameid != 0 and collection.userid='$userid' and games.console_id='$consoleid'";
        $results = $db->select($sql);
        return count($results);
    }
}