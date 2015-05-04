<?php
/**
 * Created by PhpStorm.
 * User: karolbrennan
 * Date: 12/5/14
 * Time: 7:58 PM
 */
namespace models;

class User {

    /**
     * @var user's name
     */
    public $name;
    /**
     * @var user's email
     */
    public $email;
    /**
     * @var user's role
     */
    public $role;
    /**
     * @var user's id
     */
    public $id;

    /**
     * Create new user object based on passed variables
     *
     * @param $name user's name
     * @param $email user's email
     * @param $role user's role
     * @param $id user's id
     */
    public function __construct($name, $email, $role, $id) {
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
        $this->id = $id;
    }

    /**
     * Validates the name input field
     *
     * Validates the name input field to check and ensure that it is not empty,
     * and is more than 2 characters. If it is valid, it will return the value and true.
     * @param string $name this is the submitted name from the form
     * @return array
     */
    public static function validateName($name) {
        $return = array();
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        if(!$name) {
            $return['valid'] = false;
            $return['message'] = "Please enter your name.";
        } elseif (strlen($name) < 2) {
            $return['valid'] = false;
            $return['message'] = "Name must be longer than 2 characters.";
        } else {
            $return['valid'] = true;
        }
        $return['value'] = $name;
        return $return;
    }

    /**
     * Validates the email input field
     *
     * Validates the email input field to ensure that it is not empty, and is a
     * valid email address. If valid, it will return true and the email value.
     * @param string $email this is the submitted email from the form
     * @return array
     */
    public static function validateEmail($email) {
        $return = array();
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if(!$email) {
            $return['valid'] = false;
            $return['message'] = "Please enter a valid email address.";
        }else {
            $return['valid'] = true;
        }
        $return['value'] = $email;
        return $return;
    }

    /**
     * Validates the password input field
     *
     * Validates the password input field to ensure that it is not empty,
     * and is longer than 8 characters. If valid, it will return true and the password.
     * @param string $password this is the submitted password from the form
     * @return array
     */
    public static function validatePassword($password) {
        $return = array();
        $password = filter_var($password, FILTER_SANITIZE_STRING);
        if(!$password) {
            $return['valid'] = false;
            $return['message'] = "Please enter a valid password.";
        }elseif(strlen($password) < 8) {
            $return['valid'] = false;
            $return['message'] = "Passwords must be at least 8 alpha-numeric characters.";
        }else {
            $return['valid'] = true;
        }
        $return['value'] = $password;
        return $return;
    }

    /**
     * Validates the confirm password input field
     *
     * Validates the confirm password input field to ensure that it is not empty,
     * and is longer than 8 characters. If valid, returns true and the value.
     * @param string $confirmpw this is the submitted confirm password from the form
     * @return array
     */
    public static function validateConfirmPw($confirmpw){
        $return = array();
        $confirmpw = filter_var($confirmpw, FILTER_SANITIZE_STRING);
        if(!$confirmpw) {
            $return['valid'] = false;
            $return['message'] = "Please enter a valid password.";
        }elseif(strlen($confirmpw) < 8) {
            $return['valid'] = false;
            $return['message'] = "Passwords must be at least 8 alpha-numeric characters.";
        }else {
            $return['valid'] = true;
        }
        $return['value'] = $confirmpw;
        return $return;
    }

    /**
     * Validates that password and confirm password match
     *
     * Validates the password and confirm password inputs and compares them
     * to ensure that they match. If valid, return true.
     * @param string $password this is the submitted password from the form
     * @param string $confirmpw this is the submitted confirm password from the form
     * @return array
     */
    public static function validatePasswordMatch($password, $confirmpw) {
        $return = array();
        $password = filter_var($password, FILTER_SANITIZE_STRING);
        $confirmpw = filter_var($confirmpw, FILTER_SANITIZE_STRING);
        if($password !== $confirmpw) {
            $return['valid'] = false;
            $return['message'] = "Passwords must match.";
        }else {
            $return['valid'] = true;
        }
        return $return;
    }
} 