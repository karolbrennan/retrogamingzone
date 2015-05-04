<?php
/**
 * Created by PhpStorm.
 * User: karolbrennan
 * Date: 12/13/14
 * Time: 8:48 AM
 */

namespace services;

class Leaderboard extends DatabaseConnection {

    /**
     * Return top ten game collectors
     * @todo this is really terrible, I realize that now since this
     * was meant to return both games and console collectors. OH WELL! Fix later.
     * @return array of top game collectors
     */
    public static function getTopCollectors(){
        $gameCollectors = self::getTopTenGameCollectors();
        // $consoleCollectors = self::getTopTenConsoleCollectors();
        // $collectors = array('game-collectors' => $gameCollectors, 'console-collectors' => $consoleCollectors);
        return $gameCollectors;
    }

    /**
     * Get collector name based on their id
     *
     * @param $id
     * @return mixed
     */
    public static function getCollectorName($id) {
        $db = DatabaseConnection::getConnection();
        $id = intval($id);
        $sql = "select name from users where id=$id";
        $name = $db->select($sql);
        return $name[0]['name'];
    }

    /**
     * Get top ten game collectors from the database
     *
     * @return array of game collectors
     */
    public static function getTopTenGameCollectors(){
        $db = DatabaseConnection::getConnection();
        $sql = "select userid, count(gameid) as games
                from collection
                where gameid != 0
                group by userid
                order by games
                desc limit 10";
        $results = $db->select($sql);
        $gameCollectors = array();
        foreach($results as $result){
            $collector = array();
            $collector['id'] = intval($result['userid']);
            $collector['name'] = self::getCollectorName(intval($result['userid']));
            $collector['games'] = intval($result['games']);
            $gameCollectors[] = $collector;
        }
        // echo json_encode($gameCollectors);
        return $gameCollectors;
    }

    /**
     * Get top ten console collectors
     *
     * @return array of top ten console collectors
     */
    public static function getTopTenConsoleCollectors(){
        $db = DatabaseConnection::getConnection();
        $sql = "select userid, count(consoleid) as consoles
                from collection
                where consoleid != 0
                group by userid
                order by consoles
                desc limit 10";
        $results = $db->select($sql);
        $consoleCollectors = array();
        foreach($results as $result){
            $collector = array();
            $collector['id'] = intval($result['userid']);
            $collector['name'] = self::getCollectorName(intval($result['userid']));
            $collector['consoles'] = intval($result['consoles']);
            $consoleCollectors[] = $collector;
        }
        echo json_encode($consoleCollectors);
        return $consoleCollectors;
    }

} 