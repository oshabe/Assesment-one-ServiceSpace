<?php

class Account {
    private $accountHolder;
    private $balance;

    public function __construct($accountHolder, $initialBalance = 0) {
        $this->accountHolder = $accountHolder;
        $this->balance = $initialBalance;
    }

    public function getAccountHolder() {
        return $this->accountHolder;
    }

    public function getBalance() {
        return $this->balance;
    }

    public function deposit($amount) {
        if ($amount > 0) {
            $this->balance += $amount;
            echo "Deposited $amount to " . $this->accountHolder . "'s account.\n";
        } else {
            echo "Deposit amount must be positive.\n";
        }
    }

    public function withdraw($amount) {
        if ($amount > 0 && $amount <= $this->balance) {
            $this->balance -= $amount;
            echo "Withdrew $amount from " . $this->accountHolder . "'s account.\n";
        } else {
            echo "Insufficient balance or invalid amount.\n";
        }
    }

    public function displayBalance() {
        echo $this->accountHolder . "'s balance is: $" . $this->balance . "\n";
    }
}
?>
