<?php
/**
 * Created by PhpStorm.
 * User: karolbrennan
 * Date: 12/5/14
 * Time: 7:56 PM
 */

namespace controllers;
use core\view as View;


class Register extends BaseController
{

    /**
     * @var array holds the errors keyed by section
     */
    protected $errors = array();

    /**
     * @var array holds the form data
     */
    protected $stickyForm = array();

    /**
     * Set data elements and display registration page
     */
    public function registrationPage()
    {
        $data = array();
        $data['title'] = "Register";
        $data['message'] = "Please use the following form to register for Retro Gaming Zone!";
        $data['errors'] = \helpers\session::pull('errors');
        $data['sticky-form'] = \helpers\session::pull('sticky-form');

        View::rendertemplate('header', $data);
        View::render('register/register', $data);
        View::rendertemplate('footer', $data);
    }

    /**
     * Process new user registration
     *
     * Obtain data from user input, then validate input.
     * For each validation process, either set the value in our new user array
     * or else set the error array to hold a returned error message.
     * after all validations have run, check for errors and send to session if
     * they exist. if not, process the registration in the User service.
     */
    public function processRegistration()
    {
        // check that the entire form has been filled out / fields are not empty.
        // if so, continue, if not, throw error and redirect.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $newUser = array();

            if (!empty($_POST['name'])) {
                $name = \models\User::validateName($_POST['name']);
                if ($name['valid'] === true) {
                    $newUser['name'] = $name['value'];
                } else {
                    $errors['registration']['name'] = $name['message'];
                }
                $stickyForm['name'] = $name['value'];
            } else {
                $errors['registration']['name'] = "Please enter your name.";
            }

            if (!empty($_POST['email'])) {
                $email = \models\User::validateEmail($_POST['email']);
                if ($email['valid'] === true) {
                    $userExists = \services\User::checkIfUserExists($email['value']);
                    if ($userExists === true) {
                        $errors['registration']['userexists'] =
                            "There is already a user registered with that email. <a href='" . DIR .
                            "login'>Login?</a>";
                    } else {
                        $newUser['email'] = $email['value'];
                    }
                } else {
                    $errors['registration']['email'] = $email['message'];
                }
                $stickyForm['email'] = $email['value'];
            } else {
                $errors['registration']['email'] = "Please enter a valid email address.";
            }

            if (!empty($_POST['password'])) {
                $password = \models\User::validatePassword($_POST['password']);
                if ($password['valid'] === true) {
                    $newUser['password'] = $password['value'];
                } else {
                    $errors['registration']['password'] = $password['message'];
                }
            } else {
                $errors['registration']['password'] = "Please enter a valid password.";
            }

            if (!empty($_POST['confirmpw'])) {
                $confirmpw = \models\User::validateConfirmPw($_POST['confirmpw']);
                if ($confirmpw['valid'] === true) {
                    $newUser['confirmpw'] = $confirmpw['value'];
                } else {
                    $errors['registration']['confirmpw'] = $confirmpw['message'];
                }
            } else {
                $errors['registration']['confirmpw'] = "Please confirm your password.";
            }

            if ($password['valid'] === true && $confirmpw['valid'] === true) {
                $pwmatch = \models\User::validatePasswordMatch($password['value'], $confirmpw['value']);
                if ($pwmatch['valid'] === false) {
                    $errors['registration']['passwordmatch'] = $pwmatch['message'];
                }
            }

            if(empty($errors)) {
                \services\User::createNewUserFromArray($newUser);
                $loginStatus = \services\User::loginUser($newUser);

                if($loginStatus['success'] === true) {
                    \helpers\session::destroy('errors');
                    \helpers\session::destroy('sticky-form');
                    \helpers\url::redirect('');
                } else {
                    $errors['login']['combo'] = $loginStatus['error'];
                    \helpers\session::set('errors', $errors);
                    \helpers\session::set('sticky-form', $stickyForm);
                    \helpers\url::redirect('login');
                }
            } else {
                \helpers\session::set('errors',$errors);
                \helpers\session::set('sticky-form',$stickyForm);
                \helpers\url::redirect('register');
            }
        } else {
            \helpers\url::redirect('register');
        }
    }
}