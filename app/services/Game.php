<?php
/**
 * Created by PhpStorm.
 * User: karolbrennan
 * Date: 12/3/14
 * Time: 8:15 PM
 */

namespace services;

class Game {

    /**
     * Game Factory to return game objects using Factory design pattern
     *
     * @param int $id holds game id
     * @param string $title holds game title
     * @param array $developer holds game developers
     * @param array $publisher holds game publishers
     * @param string $genre holds game genre
     * @param string $console holds game console
     * @param int $consoleName holds consoleName
     * @param string $rating holds game rating
     * @param string $releaseDate holds game release date
     * @return \models\Game returns a game object
     */
    public static function factory($id, $title, $developer, $publisher, $genre, $console, $consoleName, $rating, $releaseDate){
        return new \models\Game($id, $title, $developer, $publisher, $genre, $console, $consoleName, $rating, $releaseDate);
    }

    /**
     * Get All Games Function to return game query
     *
     * @param string $limit sets the limit of what to return from the database
     * @return array returns an array of results
     */
    public static function getAllGames($resultNum, $filterConsole, $limit) {
        $db = DatabaseConnection::getConnection();
        $sql = "select games.id, games.title, games.release_date, games.console_id,
		        genres.name as genre,
                consoles.name as console,
                ratings.name as rating,
                publishers.name as publisher,
                developers.name as developer
                from games
                left join genres on games.genre_id=genres.id
                left join consoles on games.console_id=consoles.id
                left join ratings on games.rating_id=ratings.id
                left join publishers on games.publisher_id=publishers.id
                left join developers on games.developer_id=developers.id ";

        if(!is_null($filterConsole)) {
            $sql .= "where games.console_id='$filterConsole' ";
        };

        if(!is_null($limit)) {
            $sql .= $limit;
        }
        return $db->select($sql);
    }

    /**
     * Gets game data and creates a game object based on game id
     *
     * @param int $gameid
     * @return game object
     */
    public static function getGameById($gameid){
        $db = DatabaseConnection::getConnection();
        $gameid = intval($gameid);
        $sql = "select games.id, games.title, games.release_date, games.console_id,
		        genres.name as genre,
                consoles.name as consoleName,
                ratings.name as rating,
                publishers.name as publisher,
                developers.name as developer
                from games
                left join genres on games.genre_id=genres.id
                left join consoles on games.console_id=consoles.id
                left join ratings on games.rating_id=ratings.id
                left join publishers on games.publisher_id=publishers.id
                left join developers on games.developer_id=developers.id
                where games.id=$gameid";
        $game = $db->select($sql);
        $game = $game[0];
        $gameObject = new \models\Game($game['id'], $game['title'], $game['developer'], $game['publisher'], $game['genre'], $game['console_id'], $game['consoleName'], $game['rating'], $game['release_date']);
        return $gameObject;
    }

    /**
     * Creates an array of game objects
     *
     * @param string $limit sets the limit of what to return from the database
     * @return array returns an array of game objects
     */
    public static function createGameObjectArray($resultNum, $filterConsole, $limit){
        $gamesArray = self::getAllGames($resultNum, $filterConsole, $limit);
        $gameObjects = array();
        foreach($gamesArray as $game) {
            $gameObjects[] = self::factory($game['id'], $game['title'], $game['developer'], $game['publisher'], $game['genre'], $game['console_id'], $game['consoleName'], $game['rating'], $game['release_date']);
        }
        return $gameObjects;
    }

    /**
     * Get the total of the records in the database
     *
     * @return int returns the count of how many records there are
     */
    public static function getTotalOfRecords($filterConsole){
        $db = DatabaseConnection::getConnection();
        $sql = "select count(id) as total from games";
        if(!is_null($filterConsole)) {
            $sql .= " WHERE console_id='" . intval($filterConsole) . "'";
        };
        $result = $db->select($sql);
        return intval($result[0]['total']);
    }
}