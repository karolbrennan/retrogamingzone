<?php
/**
 * Created by PhpStorm.
 * User: karolbrennan
 * Date: 12/13/14
 * Time: 11:52 AM
 */

namespace services;

class Achievements {

    /**
     * Add achievement to user achievement table if it doesn't already exist
     *
     * @param int $gameid
     * @return array achievement data
     */
    public static function addAchievementIfDoesNotExist($gameid){
        $consoleid = \services\Console::getConsoleIdBasedOnGameId($gameid);
        $userid = \services\User::getCurrentUserId();
        $totalGames = \services\Collection::getGameCountForConsoleFromUserCollection($userid, $consoleid);
        if($totalGames >= 10){
            $achievementid = self::getAchievementId($consoleid, $totalGames);
            $achievementExists = self::checkUserAchievementsForAchievement($userid, $achievementid);
            if($achievementExists === false){
                $db = DatabaseConnection::getConnection();
                $sql = "insert into userachievements (user_id, achievement_id) VALUES ('$userid', '$achievementid')";
                $db->insert($sql);
                echo json_encode(self::getAchievementById($achievementid));
                exit();
            }
        }
    }

    /**
     * Get achievement id based on passed in consoleid and total games
     * @param int $consoleid
     * @param int $totalGames from previous function count
     * @return int achievement id
     */
    public static function getAchievementId($consoleid, $totalGames) {
        switch($consoleid){
            case 1: // Atari 2600
                switch($totalGames){
                    case ($totalGames >= 100):
                        $achievementid = 4;
                        break;
                    case ($totalGames >= 50):
                        $achievementid = 3;
                        break;
                    case ($totalGames >= 25):
                        $achievementid = 2;
                        break;
                    case ($totalGames >= 10):
                        $achievementid = 1;
                        break;
                }
                break;
            case 2: // Intellivision
                switch($totalGames){
                    case ($totalGames >= 100):
                        $achievementid = 8;
                        break;
                    case ($totalGames >= 50):
                        $achievementid = 7;
                        break;
                    case ($totalGames >= 25):
                        $achievementid = 6;
                        break;
                    case ($totalGames >= 10):
                        $achievementid = 5;
                        break;
                }
                break;
            case 3: // Intellivision II
                switch($totalGames){
                    case ($totalGames >= 100):
                        $achievementid = 12;
                        break;
                    case ($totalGames >= 50):
                        $achievementid = 11;
                        break;
                    case ($totalGames >= 25):
                        $achievementid = 10;
                        break;
                    case ($totalGames >= 10):
                        $achievementid = 9;
                        break;
                }
                break;
            case 4: // Atari 5200
                switch($totalGames){
                    case ($totalGames >= 100):
                        $achievementid = 16;
                        break;
                    case ($totalGames >= 50):
                        $achievementid = 15;
                        break;
                    case ($totalGames >= 25):
                        $achievementid = 14;
                        break;
                    case ($totalGames >= 10):
                        $achievementid = 13;
                        break;
                }
                break;
            case 5: // ColecoVision
                switch($totalGames){
                    case ($totalGames >= 100):
                        $achievementid = 20;
                        break;
                    case ($totalGames >= 50):
                        $achievementid = 19;
                        break;
                    case ($totalGames >= 25):
                        $achievementid = 18;
                        break;
                    case ($totalGames >= 10):
                        $achievementid = 17;
                        break;
                }
                break;
            case 6: // Commodore 64
                switch($totalGames){
                    case ($totalGames >= 100):
                        $achievementid = 24;
                        break;
                    case ($totalGames >= 50):
                        $achievementid = 23;
                        break;
                    case ($totalGames >= 25):
                        $achievementid = 22;
                        break;
                    case ($totalGames >= 10):
                        $achievementid = 21;
                        break;
                }
                break;
            case 7: // Atari 7800
                switch($totalGames){
                    case ($totalGames >= 100):
                        $achievementid = 28;
                        break;
                    case ($totalGames >= 50):
                        $achievementid = 27;
                        break;
                    case ($totalGames >= 25):
                        $achievementid = 26;
                        break;
                    case ($totalGames >= 10):
                        $achievementid = 25;
                        break;
                }
                break;
            case 8: // Sega Master System
                switch($totalGames){
                    case ($totalGames >= 100):
                        $achievementid = 32;
                        break;
                    case ($totalGames >= 50):
                        $achievementid = 31;
                        break;
                    case ($totalGames >= 25):
                        $achievementid = 30;
                        break;
                    case ($totalGames >= 10):
                        $achievementid = 29;
                        break;
                }
                break;
            case 9: // NES
                switch($totalGames){
                    case ($totalGames >= 100):
                        $achievementid = 36;
                        break;
                    case ($totalGames >= 50):
                        $achievementid = 35;
                        break;
                    case ($totalGames >= 25):
                        $achievementid = 34;
                        break;
                    case ($totalGames >= 10):
                        $achievementid = 33;
                        break;
                }
                break;
            case 10: // Sega CD
                switch($totalGames){
                    case ($totalGames >= 100):
                        $achievementid = 40;
                        break;
                    case ($totalGames >= 50):
                        $achievementid = 39;
                        break;
                    case ($totalGames >= 25):
                        $achievementid = 38;
                        break;
                    case ($totalGames >= 10):
                        $achievementid = 37;
                        break;
                }
                break;
            case 11: // Sega 32X
                switch($totalGames){
                    case ($totalGames >= 100):
                        $achievementid = 44;
                        break;
                    case ($totalGames >= 50):
                        $achievementid = 43;
                        break;
                    case ($totalGames >= 25):
                        $achievementid = 42;
                        break;
                    case ($totalGames >= 10):
                        $achievementid = 41;
                        break;
                }
                break;
            case 12: // Sega Genesis
                switch($totalGames){
                    case ($totalGames >= 100):
                        $achievementid = 48;
                        break;
                    case ($totalGames >= 50):
                        $achievementid = 47;
                        break;
                    case ($totalGames >= 25):
                        $achievementid = 46;
                        break;
                    case ($totalGames >= 10):
                        $achievementid = 45;
                        break;
                }
                break;
            case 13: // SNES
                switch($totalGames){
                    case ($totalGames >= 100):
                        $achievementid = 52;
                        break;
                    case ($totalGames >= 50):
                        $achievementid = 51;
                        break;
                    case ($totalGames >= 25):
                        $achievementid = 50;
                        break;
                    case ($totalGames >= 10):
                        $achievementid = 49;
                        break;
                }
                break;
            case 14: // Atari Jaguar
                switch($totalGames){
                    case ($totalGames >= 100):
                        $achievementid = 56;
                        break;
                    case ($totalGames >= 50):
                        $achievementid = 55;
                        break;
                    case ($totalGames >= 25):
                        $achievementid = 54;
                        break;
                    case ($totalGames >= 10):
                        $achievementid = 53;
                        break;
                }
                break;
            case 15: // PlayStation
                switch($totalGames){
                    case ($totalGames >= 100):
                        $achievementid = 60;
                        break;
                    case ($totalGames >= 50):
                        $achievementid = 59;
                        break;
                    case ($totalGames >= 25):
                        $achievementid = 58;
                        break;
                    case ($totalGames >= 10):
                        $achievementid = 57;
                        break;
                }
                break;
            case 16: // Sega Saturn
                switch($totalGames){
                    case ($totalGames >= 100):
                        $achievementid = 64;
                        break;
                    case ($totalGames >= 50):
                        $achievementid = 63;
                        break;
                    case ($totalGames >= 25):
                        $achievementid = 62;
                        break;
                    case ($totalGames >= 10):
                        $achievementid = 61;
                        break;
                }
                break;
            case 17: // N64
                switch($totalGames){
                    case ($totalGames >= 100):
                        $achievementid = 68;
                        break;
                    case ($totalGames >= 50):
                        $achievementid = 67;
                        break;
                    case ($totalGames >= 25):
                        $achievementid = 66;
                        break;
                    case ($totalGames >= 10):
                        $achievementid = 65;
                        break;
                }
                break;
        }
        return $achievementid;
    }

    /**
     * Check the current user's achievements for achievement
     * @param int $userid
     * @param int $achievementid
     * @return bool return whether there's an existing achievement or not
     */
    public static function checkUserAchievementsForAchievement($userid, $achievementid){
        $db = DatabaseConnection::getConnection();
        $sql = "select * from userachievements where user_id='$userid' and achievement_id='$achievementid'";
        $results = $db->select($sql);
        if(count($results) === 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Gets all achievements earned by a specific user
     *
     * @param $userid
     * @return array returns all user achievements
     */
    public static function getUserAchievements($userid){
        $db = DatabaseConnection::getConnection();
        $sql = "select userachievements.*, achievements.* from userachievements
                inner join achievements on achievements.achievement_id=userachievements.achievement_id
                where user_id=$userid";
        return $db->select($sql);
    }

    /**
     * Gets all achievements possible in achievements table
     *
     * @return array of achievements
     */
    public static function getAchievements(){
        $db = DatabaseConnection::getConnection();
        $sql = "select * from achievements";
        return $db->select($sql);
    }

    /**
     * Gets achievement data for display based on id
     *
     * @param int $achievementid
     * @return array returns achievement data
     */
    public static function getAchievementById($achievementid){
        $db = DatabaseConnection::getConnection();
        $sql = "select * from achievements where achievement_id='$achievementid'";
        return $db->select($sql);
    }
}