<?php
/**
 * Created by PhpStorm.
 * User: karolbrennan
 * Date: 12/7/14
 * Time: 4:57 PM
 */

namespace models;

class Console {
    /**
     * @var int $id holds console id
     */
    public $id;
    /**
     * @var string $name holds console's title
     */
    public $name;
    /**
     * @var string $year holds the console's release year
     */
    public $year;

    /**
     * Create a new console object based on console data input
     *
     * @param int $id is console id
     * @param string $name is console name
     * @param string $year is console release year
     */
    public function __construct($id, $name, $year) {
        $this->id = $id;
        $this->name = $name;
        $this->year = $year;
        $this->inCollection = \services\Collection::checkCurrentUserCollectionForConsole($this->id);
        $this->inWishlist = \services\Wishlist::checkCurrentUserWishlistForConsole($this->id);
    }
} 