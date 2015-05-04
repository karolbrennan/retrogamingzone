<?php
/**
 * Created by PhpStorm.
 * User: karolbrennan
 * Date: 12/7/14
 * Time: 9:07 PM
 */

namespace controllers;
use core\view as View;


class Consoles extends BaseController {

    /**
     * Display the consoles listing page and pass relevant data
     */
    public function consolesListingPage() {
        Auth::redirectToLoginIfNotLoggedIn();

        $data['title'] = 'Consoles';
        $data['message'] = 'Here is the entire listing of available consoles.';
        $data['no-consoles'] = "Sorry, there aren't any consoles available yet.";
        $data['consoles'] = \services\Console::createConsoleObjectArray();

        View::rendertemplate('header', $data);
        View::render('consoles/consoles', $data);
        View::rendertemplate('footer', $data);
    }


} 