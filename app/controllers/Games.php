<?php
/**
 * Created by PhpStorm.
 * User: karolbrennan
 * Date: 12/7/14
 * Time: 9:07 PM
 */

namespace controllers;
use core\view as View;


class Games {
    /**
     * Get games listing page and handle filtering of results
     */
    public function gamesListingPage() {
        Auth::redirectToLoginIfNotLoggedIn();
        if(isset($_GET['resultNum']) && $_GET['resultNum'] !== 'Per Page'){
            $resultNum = filter_var($_GET['resultNum'], FILTER_SANITIZE_NUMBER_INT);
        }else{
            $resultNum = 20;
        };
        $data['selectedNumber'] = $resultNum;
        $ext = "&resultNum=" . $resultNum;

        if(isset($_GET['console'])){
            if($_GET['console'] !== 'Select Console') {

                $console = filter_var($_GET['console'], FILTER_SANITIZE_STRING);
                switch ($console) {
                    case 'Atari 2600';
                        $filterConsole = '1';
                        $consoleName = 'Atari+2600';
                        break;
                    case 'Atari 5200';
                        $filterConsole = '4';
                        $consoleName = 'Atari+5200';
                        break;
                    case 'Atari 7800';
                        $filterConsole = '7';
                        $consoleName = 'Atari+7800';
                        break;
                    case 'Atari Jaguar';
                        $filterConsole = '14';
                        $consoleName = 'Atari+Jaguar';
                        break;
                    case 'ColecoVision';
                        $filterConsole = '5';
                        $consoleName = 'ColecoVision';
                        break;
                    case 'Commodore 64';
                        $filterConsole = '6';
                        $consoleName = 'Commodore+64';
                        break;
                    case 'Intellivision';
                        $filterConsole = '2';
                        $consoleName = 'Intellivision';
                        break;
                    case 'NES';
                        $filterConsole = '9';
                        $consoleName = 'NES';
                        break;
                    case 'SNES';
                        $filterConsole = '13';
                        $consoleName = 'SNES';
                        break;
                    case 'N64';
                        $filterConsole = '17';
                        $consoleName = 'N64';
                        break;
                    case 'Sega Master System';
                        $filterConsole = '8';
                        $consoleName = 'Sega+Master+System';
                        break;
                    case 'Sega 32X';
                        $filterConsole = '11';
                        $consoleName = 'Sega+32X';
                        break;
                    case 'Sega CD';
                        $filterConsole = '10';
                        $consoleName = 'Sega+CD';
                        break;
                    case 'Sega Genesis';
                        $filterConsole = '12';
                        $consoleName = 'Sega+Genesis';
                        break;
                    case 'Sega Saturn';
                        $filterConsole = '16';
                        $consoleName = 'Sega+Saturn';
                        break;
                    case 'PlayStation';
                        $filterConsole = '15';
                        $consoleName = 'PlayStation';
                        break;
                };
                $data['selectedConsole'] = $console;
                $ext .= "&console=" . $consoleName;
            }
        }else{
            $filterConsole = null;
        };

        $data['title'] = 'Games';
        $data['message'] = 'Here is a listing of available games.';
        $pages = new \helpers\paginator($resultNum,'p');
        $data['games'] = \services\Game::createGameObjectArray($resultNum, $filterConsole, $pages->get_limit($resultNum));
        $total = \services\Game::getTotalOfRecords($filterConsole);
        $pages->set_total($total);
        $path = '?';
        $data['pages'] = $pages->page_links($path,$ext);

        View::rendertemplate('header', $data);
        View::render('games/games', $data);
        View::rendertemplate('footer', $data);
    }


} 