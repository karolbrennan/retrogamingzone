<?php
/**
 * Created by PhpStorm.
 * User: karolbrennan
 * Date: 12/7/14
 * Time: 10:16 PM
 */

namespace services;


class Scraper extends DatabaseConnection {

    /**
     * Parses data from .csv files and injects data into our database
     * @return array of scraped objects
     */
    public static function scrape()
    {
//        $file = fopen(DIR . 'app/scripts/atari2600.csv','r');
//        $file = fopen(DIR . 'app/scripts/atari5200.csv','r');
//        $file = fopen(DIR . 'app/scripts/atari7800.csv','r');
//        $file = fopen(DIR . 'app/scripts/jaguar.csv','r');
//        $file = fopen(DIR . 'app/scripts/intellivision.csv','r');
//        $file = fopen(DIR . 'app/scripts/colecovision.csv','r');
//        $file = fopen(DIR . 'app/scripts/commodore64na.csv','r');
//        $file = fopen(DIR . 'app/scripts/segamastersystem.csv','r');
//        $file = fopen(DIR . 'app/scripts/segacdna.csv','r');
//        $file = fopen(DIR . 'app/scripts/sega32x.csv','r');
//        $file = fopen(DIR . 'app/scripts/gen.csv','r');
//        $file = fopen(DIR . 'app/scripts/segasaturn.csv','r');
//        $file = fopen(DIR . 'app/scripts/nes.csv','r');
//        $file = fopen(DIR . 'app/scripts/snes.csv','r');
//        $file = fopen(DIR . 'app/scripts/n64.csv','r');
        $file = fopen(DIR . 'app/scripts/ps1.csv','r');

        // array to hold games
        $games = array();

        while(! feof($file))
        {
            $row = fgetcsv($file);
            // get all of the needed data
            $console = filter_var($row[0], FILTER_SANITIZE_STRING);
            $title = filter_var($row[1], FILTER_SANITIZE_STRING);
            $developer = filter_var($row[2], FILTER_SANITIZE_STRING);
            $publisher = filter_var($row[3], FILTER_SANITIZE_STRING);
            $genre = filter_var($row[4], FILTER_SANITIZE_STRING);
            $rating = filter_var($row[5], FILTER_SANITIZE_STRING);
            $releasedate = filter_var($row[6], FILTER_SANITIZE_STRING);
            $cover = $row[7];

            // get IDs for data manipulation
            $developerid = intval(self::getIdFromTable('developers',$developer));
            $publisherid = intval(self::getIdFromTable('publishers',$publisher));
            $genreid = intval(self::getIdFromTable('genres',$genre));
            $ratingid = intval(self::getRating($rating));
            $consoleid = intval(self::getConsole($console));

            $gameExists = self::checkIfGameExists($title,$consoleid);
            if($gameExists === false){
                $games[] = self::createNewGame($title,$developerid,$publisherid,$genreid,$ratingid,$releasedate,$consoleid,$cover);
            }
            $title = null;
            $developer = null;
            $developerid = null;
            $publisher = null;
            $publisherid = null;
            $genre = null;
            $genreid = null;
            $rating = null;
            $ratingid = null;
            $releasedate = null;
            $console = null;
            $consoleid = null;
            $cover = null;
        }

        fclose($file);
        return $games;
    }

    /**
     * Determine what console it is based on console name
     * @param string $console the passed console name
     * @return int $consoleid the returned console id
     */
    public static function getConsole($console) {
        if($console == 'atari2600') {$consoleid = '1';}
        elseif($console == 'intellivision') {$consoleid = '2';}
        // elseif($console == 'intellivision') {$consoleid = '3';}
        elseif($console == 'atari5200') {$consoleid = '4';}
        elseif($console == 'colecovision') {$consoleid = '5';}
        elseif($console == 'commodore64') {$consoleid = '6';}
        elseif($console == 'atari7800') {$consoleid = '7';}
        elseif($console == 'segamastersystem') {$consoleid = '8';}
        elseif($console == 'nes') {$consoleid = '9';}
        elseif($console == 'segacd') {$consoleid = '10';}
        elseif($console == 'sega32x') {$consoleid = '11';}
        elseif($console == 'gen') {$consoleid = '12';}
        elseif($console == 'snes') {$consoleid = '13';}
        elseif($console == 'jaguar') {$consoleid = '14';}
        elseif($console == 'ps1') {$consoleid = '15';}
        elseif($console == 'segasaturn') {$consoleid = '16';}
        elseif($console == 'n64') {$consoleid = '17';}
        else{$consoleid = null;};
        return $consoleid;
    }

    /**
     * Determines the rating id based on the passed rating string
     * @param string $rating the passed rating string
     * @return int returns the rating id
     */
    public static function getRating($rating) {
        if($rating === 'K-A (ESRB)') { $ratingid = '1';}
        elseif($rating === 'E (ESRB)') { $ratingid = '2';}
        elseif($rating === 'E10 (ESRB) (ESRB)') { $ratingid = '3';}
        elseif($rating === 'T (ESRB)') { $ratingid = '4';}
        elseif($rating === 'M (ESRB)') { $ratingid = '5';}
        elseif($rating === 'AO (ESRB)') { $ratingid = '6';}
        elseif($rating === 'RP (ESRB)') { $ratingid = '7';}
        else { $ratingid = null;};
        return $ratingid;
    }

    /**
     * Gets the id of a row from the table using the developer or publisher name
     *
     * Checks to see if the developer or publisher already exits, and if not it
     * creates a new dev / pub
     *
     * @param string $tablename the table to be searched/altered
     * @param string $name the name of the developer/publisher
     * @return int $id
     */
    public static function getIdFromTable($tablename, $name)
    {
        $db = DatabaseConnection::getConnection();

        $sql = "select id from " . $tablename . " where name='" . $name . "'";
        $results = $db->select($sql);
        $row = $results[0];
        $count = count($row);
        // if id exists, return the id
        if ($count >= 1) {
            $id = $row->id;
        } else { // if id doesn't exist, create new record and return id
            $id = self::createNewRecord($tablename, $name);
        }
        return $id;
    }

    /**
     * Create a new record for publishers and developers
     *
     * @param string $tablename the table to be altered
     * @param string $name the name we are creating
     * @return int $id
     */
    public static function createNewRecord($tablename, $name)
    {
        $db = DatabaseConnection::getConnection();

        $sql = "insert into " . $tablename . " (name) values ('" . $name . "')";
        $db->insert($sql);
        $id = $db->getLastId();

        return $id;
    }

    /**
     * Checks to see if game already exits in our database
     *
     * @param string $title the title of the game
     * @param int $consoleid the console the game is associated with
     * @return bool true if it exists, false if it doesn't
     */
    public static function checkIfGameExists($title,$consoleid) {
        $db = \services\DatabaseConnection::getConnection();

        $sql = "select * from games where title='$title' and console_id=" . $consoleid;

        $results = $db->select($sql);
        $count = count($results);

        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Creates a new game object based on passed parameters
     *
     * @param string $title title of game
     * @param int $developerid
     * @param int $publisherid
     * @param int $genreid
     * @param int $ratingid
     * @param string $releasedate
     * @param int $consoleid
     * @param string $cover url for the cover art
     * @return array for game object
     */
    public static function createNewGame($title,$developerid,$publisherid,$genreid,$ratingid,$releasedate,$consoleid,$cover) {

        $db = \services\DatabaseConnection::getConnection();

        $sql = "insert into games (title,developer_id,publisher_id,genre_id,rating_id,release_date,console_id)
            values ('$title',$developerid,$publisherid,$genreid,$ratingid,'$releasedate','$consoleid')";

        $db->insert($sql);
        $gameid = $db->getLastId();
        $game = array(
            "id" => $gameid,
            "title" => $title,
            "developer" => $developerid,
            "publisher" => $publisherid,
            "genre" => $genreid,
            "rating" => $ratingid,
            "releasedate" => $releasedate,
            "console" => $consoleid
        );
        self::getCoverArt($gameid,$cover,$consoleid);
        self::createJoinDeveloper($gameid,$developerid);
        self::createJoinPublisher($gameid,$publisherid);

        return $game;
    }

    /**
     * Go to cover url and take the game and upload to our server
     *
     * @param int $gameid id of the game for renaming purposes
     * @param string $cover url of where we can get the cover
     * @param int $consoleid id of the console the game belongs to
     */
    public static function getCoverArt($gameid,$cover,$consoleid){
        $srcfile = $cover;
        $fileExists = get_headers($cover);
        if($fileExists[0] === "HTTP/1.1 404 Not Found") {
            echo "Image not found <br><br>";
        } else {
            $dir = $_SERVER["DOCUMENT_ROOT"] . "/app/templates/default/images/consoles/$consoleid/";
            $dstfile = $dir . "$gameid.jpg";
            copy($srcfile, $dstfile);
        }
    }

    /**
     * Creates a row in the developedby table for joins
     *
     * @param int $gameid
     * @param int $developerid
     */
    public static function createJoinDeveloper($gameid,$developerid) {
        $db = \services\DatabaseConnection::getConnection();
        $gameid = intval($gameid);
        $developerid = intval($developerid);
        $sql = "insert into developedby (gameid, developerid) values ('$gameid', '$developerid')";
        $db->insert($sql);

    }

    /**
     * Creates a row in the publishedby table for joins
     *
     * @param int $gameid
     * @param int $publisherid
     */
    public static function createJoinPublisher($gameid,$publisherid) {
        $db = \services\DatabaseConnection::getConnection();
        $gameid = intval($gameid);
        $publisherid = intval($publisherid);
        $sql = "insert into publishedby (gameid, publisherid) values ('$gameid', '$publisherid')";
        $db->insert($sql);

    }

} 