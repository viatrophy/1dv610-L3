<?php

namespace model;

class RegisterModel {

    private $database;
    private $registerView;
    
    public function __construct(DatabaseModel $database) {
        $this->database = $database;
        // $this->registerView = $registerView;
    }

    public function validateRegisterAttempt($username, $password, $passwordRepeat) {
        $message = '';

        if (strlen($username) == 0 && strlen($password) == 0 && strlen($passwordRepeat) == 0) {
            $message = 'Username has too few characters, at least 3 characters. <br> Password has too few characters, at least 6 characters.';

        } else if (strlen($password) < 6) {
            $message = 'Password has too few characters, at least 6 characters.';

        } else if (strlen($username) > 0 && strlen($username) < 3 && strlen($password) > 5) {
            $message = 'Username has too few characters, at least 3 characters.';
            
        } else if (strlen($username) > 2 && strlen($password) > 5) {

            if ($password != $passwordRepeat) {
                $message = 'Passwords do not match.';

            } else if ($this->database->alreadyExist($username)) {
                $message = 'User exists, pick another username.';

            } else if (preg_match('/</',$username) || (preg_match('/>/',$username))) {
                $message = 'Username contains invalid characters.';
                // $this->registerView->setUsername(strip_tags($username));
                //Fixa 
                //bättre 
                //lösning

            } else  {
                $_SESSION['registeredName'] = $username;
                $_SESSION['isRegistered'] = true;

                $this->database->register($username, $password);
                header("Location: /1dv610-L3/index.php");
                die();
            }
        }
        $_SESSION['isRegistered'] = false;

        return $message;
    }
}
