<?php
/**
 * Created by PhpStorm.
 * User: karolbrennan
 * Date: 12/3/14
 * Time: 8:15 PM
 */

namespace services;

class Console {


    /**
     * Console Factory to return console objects using Factory design pattern
     *
     * @param int $id holds console id
     * @param string $name holds console name
     * @param string $year holds year the console was released
     * @return \models\Console returns a console object
     */
    public static function factory($id, $name, $year){
        return new \models\Console($id, $name, $year);
    }

    /**
     * Get All Consoles Function to return console query
     *
     * @return array returns an array of results
     */
    public static function getAllConsoles() {
        $db = DatabaseConnection::getConnection();
        $sql = "select id, name, year from consoles";
        return $db->select($sql);
    }

    /**
     * Creates an array of console objects
     *
     * @return array returns an array of game objects
     */
    public static function createConsoleObjectArray(){
        $consolesArray = self::getAllConsoles();
        $consoleObjects = array();
        foreach($consolesArray as $console) {
            $consoleObjects[] = self::factory($console['id'], $console['name'], $console['year']);
        }
        return $consoleObjects;
    }

    /**
     * Get the name of a console based on console id
     *
     * @param int $consoleid id of console passed in
     * @return string console name
     */
    public static function getConsoleName($consoleid){
        $consoleid = intval($consoleid);
        switch ($consoleid) {
            case 1:
                $consoleName = 'Atari 2600';
                break;
            case 2:
                $consoleName = 'Intellivision';
                break;
            case 3:
                $consoleName = 'Intellivision II';
                break;
            case 4:
                $consoleName = 'Atari 5200';
                break;
            case 5:
                $consoleName = 'ColecoVision';
                break;
            case 6:
                $consoleName = 'Commodore 64';
                break;
            case 7:
                $consoleName = 'Atari 7800';
                break;
            case 8:
                $consoleName = 'Sega Master System';
                break;
            case 9:
                $consoleName = 'NES';
                break;
            case 10:
                $consoleName = 'Sega CD';
                break;
            case 11:
                $consoleName = 'Sega 32X';
                break;
            case 12:
                $consoleName = 'Sega Genesis';
                break;
            case 13:
                $consoleName = 'SNES';
                break;
            case 14:
                $consoleName = 'Atari Jaguar';
                break;
            case 15:
                $consoleName = 'PlayStation';
                break;
            case 16:
                $consoleName = 'Sega Saturn';
                break;
            case 17:
                $consoleName = 'Nintendo 64';
                break;
        }
        return $consoleName;
    }


    /**
     * Get console id based on passed game id
     *
     * @param int $gameid passed game id
     * @return int console id
     */
    public static function getConsoleIdBasedOnGameId($gameid) {
        $db = DatabaseConnection::getConnection();
        $sql = "select console_id from games where id='$gameid' limit 1";
        $result = $db->select($sql);
        return intval($result[0]['console_id']);
    }
}