<?php namespace controllers;
use core\view as View;

class Index extends \core\controller{

	/**
	 * call the parent construct
	 */
	public function __construct(){
		parent::__construct();

		$this->language->load('welcome');
	}

	/**
	 * define page title and load template files
	 */
	public function index(){

		$data['title'] = 'Welcome';
        $data['leaderboard'] = \services\Leaderboard::getTopCollectors();
        $data['user'] = \helpers\Session::get('user');

        $data['games'] = \services\Collection::getCurrentUserGameCountCollection();
        $data['consoles'] = \services\Collection::getCurrentUserConsoleCollection();

		View::rendertemplate('header', $data);
		View::render('index/index', $data);
		View::rendertemplate('footer', $data);
	}


    /**
     * Gets the most up to date leaderboard information
     */
    public function leaderboardUpdate(){
        echo json_encode(\services\Leaderboard::getTopTenGameCollectors());
    }
}
