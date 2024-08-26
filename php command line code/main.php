<?php

require_once 'Account.php';
require_once 'Bank.php';
require_once 'auth.php';

function welcomeMessage() {
    echo "Welcome to the Command-Line Banking System!\n";
    echo "\nManage multiple accounts, securely deposit and withdraw funds, and view account balances.\n";
    echo "Please select an option from the menu to get started.\n";
    printLine();
}

function printLine() {
    echo "=======================================\n";
}

function getValidNumberInput($prompt) {
    do {
        echo $prompt;
        $input = trim(fgets(STDIN));
        if (is_numeric($input) && $input >= 0) {
            return (float)$input;
        } else {
            echo "Invalid input. Please enter a positive number.\n";
        }
    } while (true);
}

function validatePasswordStrength($password) {
    if (strlen($password) < 8) {
        echo "Password should be at least 8 characters long.\n";
        return false;
    } elseif (!preg_match("/[0-9]/", $password)) {
        echo "Password should include at least one number.\n";
        return false;
    } elseif (!preg_match("/[A-Z]/", $password)) {
        echo "Password should include at least one uppercase letter.\n";
        return false;
    }
    return true;
}

function logTransaction($accountHolder, $action, $amount) {
    $logMessage = "[" . date('Y-m-d H:i:s') . "] $accountHolder $action $amount\n";
    file_put_contents('transactions.log', $logMessage, FILE_APPEND);
}

$bank = new Bank();
welcomeMessage();

while (true) {
    printLine();
    echo "Banking System Menu\n";
    printLine();
    echo "1. Create Account\n";
    echo "2. Deposit\n";
    echo "3. Withdraw\n";
    echo "4. Display Balance\n";
    echo "5. Display All Accounts\n";
    echo "6. Exit\n";
    echo "Choose an option: ";
    $choice = trim(fgets(STDIN));

    switch ($choice) {
        case 1:
            echo "Enter account holder name: ";
            $name = trim(fgets(STDIN));
            $balance = getValidNumberInput("Enter initial balance: ");
            do {
                echo "Create a password: ";
                $password = trim(fgets(STDIN));
            } while (!validatePasswordStrength($password));
            $bank->createAccount($name, $balance, $password);
            break;
        case 2:
            echo "Enter account holder name: ";
            $name = trim(fgets(STDIN));
            echo "Enter password: ";
            $password = trim(fgets(STDIN));
            $account = $bank->loginAndGetAccount($name, $password);
            if ($account) {
                $amount = getValidNumberInput("Enter deposit amount: ");
                $account->deposit($amount);
                logTransaction($name, "Deposited", $amount);
            }
            break;
        case 3:
            echo "Enter account holder name: ";
            $name = trim(fgets(STDIN));
            echo "Enter password: ";
            $password = trim(fgets(STDIN));
            $account = $bank->loginAndGetAccount($name, $password);
            if ($account) {
                $amount = getValidNumberInput("Enter withdrawal amount: ");
                $account->withdraw($amount);
                logTransaction($name, "Withdrew", $amount);
            }
            break;
        case 4:
            echo "Enter account holder name: ";
            $name = trim(fgets(STDIN));
            echo "Enter password: ";
            $password = trim(fgets(STDIN));
            $account = $bank->loginAndGetAccount($name, $password);
            if ($account) {
                $account->displayBalance();
            }
            break;
        case 5:
            $bank->displayAllAccounts();
            break;
        case 6:
            exit("Goodbye!\n");
        default:
            echo "Invalid option, please try again.\n";
    }
}
?>
