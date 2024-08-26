<?php

require_once 'auth.php';

class Bank {
    private $accounts = [];
    private $auth;

    public function __construct() {
        $this->auth = new Auth();
    }

    public function createAccount($accountHolder, $initialBalance = 0, $password) {
        if (!isset($this->accounts[$accountHolder])) {
            $this->auth->register($accountHolder, $password);
            $account = new Account($accountHolder, $initialBalance);
            $this->accounts[$accountHolder] = $account;
            echo "Account created for $accountHolder.\n";
        } else {
            echo "Account for $accountHolder already exists.\n";
        }
    }

    public function loginAndGetAccount($accountHolder, $password) {
        if ($this->auth->login($accountHolder, $password)) {
            return $this->accounts[$accountHolder] ?? null;
        } else {
            echo "Login failed.\n";
            return null;
        }
    }

    public function displayAllAccounts() {
        echo "All Bank Accounts:\n";
        foreach ($this->accounts as $accountHolder => $account) {
            $account->displayBalance();
        }
    }
}
?>
