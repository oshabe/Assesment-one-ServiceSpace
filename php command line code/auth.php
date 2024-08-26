<?php

class Auth {
    private $userCredentials = [];

    public function register($accountHolder, $password) {
        if (isset($this->userCredentials[$accountHolder])) {
            echo "Account already exists for $accountHolder.\n";
        } else {
            // Store password securely (hashed)
            $this->userCredentials[$accountHolder] = password_hash($password, PASSWORD_DEFAULT);
            echo "$accountHolder has been registered successfully.\n";
        }
    }

    public function login($accountHolder, $password) {
        if (!isset($this->userCredentials[$accountHolder])) {
            echo "No account found for $accountHolder.\n";
            return false;
        }

        // Verify password
        if (password_verify($password, $this->userCredentials[$accountHolder])) {
            echo "Login successful for $accountHolder.\n";
            return true;
        } else {
            echo "Invalid password for $accountHolder.\n";
            return false;
        }
    }
}
?>
