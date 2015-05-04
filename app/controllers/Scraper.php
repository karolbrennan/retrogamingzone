<?php
/**
 * Created by PhpStorm.
 * User: karolbrennan
 * Date: 11/2/14
 * Time: 2:36 PM
 */

namespace controllers;
use core\view as View;


class Scraper extends BaseController {

    /**
     * Displays the scraper page and passes relevant data to it
     */
    public function index(){
        Auth::redirectToLoginIfNotLoggedIn();
        $data = array();

        $data['user'] = \helpers\session::get('user');

        $data['title'] = 'Scrape That Ish!';
        $data['games'] = \services\Scraper::scrape();

        View::rendertemplate('header', $data);
        View::render('index/scraper', $data);
        View::rendertemplate('footer', $data);
    }

} 