<?php
/**
 * Created by PhpStorm.
 * User: karolbrennan
 * Date: 12/3/14
 * Time: 7:57 PM
 */

namespace services;

class User  {

    /**
     * @var string holds the table we are working with within this class
     */
    protected static $table = 'users';

    /**
     * User factory to return user objects using Factory design pattern
     *
     * @param string $name user's name
     * @param string $email user's email
     * @param string $role user's role
     * @param string $id user's id
     * @return \models\User returns user data
     */
    public static function factory($name, $email, $role, $id){
        return new \models\User($name, $email, $role, $id);
    }

    /**
     * Utility function to return current user's ID
     *
     * @return int user's id
     */
    public static function getCurrentUserId(){
        $user = \helpers\session::get('user');
        return intval($user->id);
    }

    /**
     * Check database to see if user exists based on email input
     *
     * @param string $email email from input
     * @return bool
     */
    public static function checkIfUserExists($email) {
        $db = DatabaseConnection::getConnection();
        $sql = "select email from " . self::$table . " where email=" . $db->quote($email);
        $result = $db->select($sql);

        if($result){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Create a new user from passed new user array
     *
     * @param array $newUser data from registration form
     */
    public static function createNewUserFromArray(array $newUser){
        $db = DatabaseConnection::getConnection();
        $sql = "insert into " . self::$table . " (name, email, password) values (" .
                $db->quote($newUser['name']) . ", " .
                $db->quote($newUser['email']) . ", " .
                $db->quote(password_hash($newUser['password'], PASSWORD_BCRYPT)) .
                ")";
        $db->insert($sql);
    }

    /**
     * Log user into the system
     *
     * @param array $user holds user input
     * @return array holds errors or success and user data
     */
    public static function loginUser(array $user) {
        $db = DatabaseConnection::getConnection();
        $sql = "select id, name, email, role, password from " . self::$table . " where email=" .
            $db->quote($user['email']);
        $result = $db->select($sql);
        $rows = count($result);
        $return = array();

        if($rows === 1) {
            $userArray = $result[0];
            $pwVerify = password_verify($user['password'], $userArray['password']);
            if($pwVerify === true) {
                $user = self::factory($userArray['name'], $userArray['email'], $userArray['role'], $userArray['id']);
                $return['user'] = $user;
                $return['success'] = true;
                \helpers\session::set('user', $user);
            } else {
                $return['success'] = false;
                $return['error'] = "No user exists with that email/password combination.";
            }
        } elseif($rows > 1) {
            $return['success'] = false;
            $return['error'] = "There was an error, please contact the admin.";
        } else {
            $return['success'] = false;
            $return['error'] = "No user exists with that email/password combination.";
        }

        return $return;
    }

    /**
     * Checks to make sure a user exists in the database
     *
     * @param $userid
     * @return bool return true if exists, false if not
     */
    public static function checkIfUserExistsById($userid){
        $db = DatabaseConnection::getConnection();
        $sql = "select * from users where id=$userid";
        $result = $db->select($sql);
        if($result){
            return true;
        } else {
            return false;
        }
    }
} 