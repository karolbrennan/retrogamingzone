<?php
/**
 * Created by PhpStorm.
 * User: karolbrennan
 * Date: 11/9/14
 * Time: 7:29 PM
 */
namespace controllers;
use core\view as View;

class Auth extends BaseController
{
    /**
     * Set data elements and display login page
     */
    public function loginPage()
    {
        $data = array();
        $data['title'] = "Login";
        $data['message'] = "Please login to use Retro Gaming Zone!";
        $data['errors'] = \helpers\session::pull('errors');
        $data['sticky-form'] = \helpers\session::pull('sticky-form');

        // render templates and pass data to them
        View::rendertemplate('header', $data);
        View::render('auth/login', $data);
        View::rendertemplate('footer', $data);
    }

    /**
     * Process form when someone attempts to log in
     */
    public function processLogin() {
        $user = array();
        $errors = array();
        $stickyForm = array();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST['email'])) {
                $email = \models\User::validateEmail($_POST['email']);
                if($email['valid'] === true) {
                    $user['email'] = $email['value'];
                } else {
                    $errors['login']['email'] = $email['message'];
                    $stickyForm['email'] = $email['value'];
                }
            }
            if(!empty($_POST['password'])) {
                $password = \models\User::validatePassword($_POST['password']);
                if($password['valid'] === true) {
                    $user['password'] = $password['value'];
                } else {
                    $errors['login']['password'] = $password['message'];
                }
            }
        } else {
            $errors['login']['required'] = "Please fill out the form.";
        }

        if(empty($errors)) {
            $loginStatus = \services\User::loginUser($user);
            if($loginStatus['success'] === false) {
                $errors['login']['combo'] = $loginStatus['error'];
            }
        }

        if (empty($errors)) {
            \helpers\session::destroy('errors');
            \helpers\session::destroy('sticky-form');
            \helpers\url::redirect('');
        } else {
            \helpers\session::set('errors', $errors);
            \helpers\url::redirect('login');
        }
    }


    /**
     * Set data elements and display the logout page
     */
    public function logoutPage()
    {
        $this->processLogout();
        $data['message'] = "You have successfully logged out!";

        View::rendertemplate('header', $data);
        View::render('auth/logout', $data);
        View::rendertemplate('footer', $data);
    }

    /**
     * Processes a log out by destroying the user session along with errors and sticky form data
     */
    public function processLogout() {
        \helpers\session::destroy('user');
    }


    /**
     * Redirect to registration page if user is not logged in
     */
    public static function redirectToRegisterIfNotLoggedIn(){
        $user = \helpers\session::get('user');
        if(empty($user)) {
            \helpers\url::redirect('register');
        }
    }

    /**
     * Redirect to login page if user is not logged in
     */
    public static function redirectToLoginIfNotLoggedIn(){
        $user = \helpers\session::get('user');
        if(empty($user)) {
            \helpers\url::redirect('login');
        }
    }

    /**
     * Redirect to home page if user is logged in
     */
    public static function redirectToHomeIfLoggedIn(){
        $user = \helpers\session::get('user');
        if(!empty($user)) {
            \helpers\url::redirect('');
        }
    }
} 