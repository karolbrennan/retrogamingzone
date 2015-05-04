<?php
/**
 * Created by PhpStorm.
 * User: karolbrennan
 * Date: 12/7/14
 * Time: 4:57 PM
 */

namespace models;

class Game {
    /**
     * @var int $id holds game id
     */
    public $id;
    /**
     * @var string $title holds game's title
     */
    public $title;
    /**
     * @var array $developer holds developers
     */
    public $developer; //= array();
    /**
     * @var array $publisher holds publishers
     */
    public $publisher; //= array();
    /**
     * @var string $genre holds game genre
     */
    public $genre;
    /**
     * @var string $console holds game console id
     */
    public $console;
    /**
     * @var string $consoleName holds game console
     */
    public $consoleName;
    /**
     * @var string $rating holds game rating
     */
    public $rating;
    /**
     * @var string $releaseDate holds game release date
     */
    public $releaseDate;

    /**
     * Create a new game object based on game data input
     *
     * @param int $id is game id
     * @param string $title is game title
     * @param array $developer is game developer
     * @param array $publisher is game publisher
     * @param string $genre is game genre
     * @param string $console is game console id
     * @param string $consoleName is game console
     * @param string $rating is game rating
     * @param string $releaseDate is game release date
     */
    public function __construct($id, $title, $developer, $publisher, $genre, $console, $consoleName, $rating, $releaseDate) {
        $this->id = $id;
        $this->title = $title;
        $this->developer = $developer;
        $this->publisher = $publisher;
        $this->genre = $genre;
        $this->console = $console;
        $this->consoleName = $consoleName;
        $this->rating = $rating;
        $this->releaseDate = $releaseDate;
        $this->inCollection = \services\Collection::checkCurrentUserCollectionForGame($this->id);
        $this->inWishlist = \services\Wishlist::checkCurrentUserWishlistForGame($this->id);
    }
} 