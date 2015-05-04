<?php
/**
 * Created by PhpStorm.
 * User: karolbrennan
 * Date: 12/13/14
 * Time: 8:53 AM
 */

namespace services;


class AbstractService {

    /**
     * Debug function because I was writing this out way too often
     *
     * @param $param
     */
    public static function Debug($param) {
        echo "Debugging Data: <br> <pre>";
            var_dump($param);
        echo "</pre>";
        die;
    }
} 