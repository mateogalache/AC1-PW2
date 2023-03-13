<?php

use JetBrains\PhpStorm\NoReturn;

class controller{

    private function connectDb(): PDO
    {
        return new PDO('mysql:host=db:3306;dbname=test','admin','admin');
    }

    private function validateEmailPassword(string $email, string $password): array
    {

        return array(filter_var($email, FILTER_VALIDATE_EMAIL),preg_match("^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{7,}$^"
            ,$password));
    }
    private function messageError(string $email, string $password): array
    {
        $email_message = '';
        $password_message = '';

        if (!$this->validateEmailPassword($email,$password)[0] && !$this->validateEmailPassword($email,$password)[1]){
            $email_message = "Email is not valid";
            $password_message = "Password must contain at least one number, one capital letter, one small letter, and should be longer than or equal to 7 characters";
        } else if (!$this->validateEmailPassword($email,$password)[0]){
            $email_message = "Email is not valid";
        } else {
            $password_message = "Password must contain at least one number, one capital letter, one small letter, and should be longer than or equal to 7 characters";
        }
        return array($email_message,$password_message);
    }

    #[NoReturn] private function insertEmailPassword(PDO $connection, string $email, string $password): void{
        $statement = $connection->prepare('INSERT INTO Users (email, password) VALUES (:email, :password)');
        $statement->execute([
            'email' => $email,
            'password' => $password,
        ]);
        header("Location: /login.php");
        exit;
    }

    private function postData(): array
    {
        return array($_POST['email'],$_POST['password']);
    }

    public function executeRegister(): array
    {
            $email = $this->postData()[0];
            $password = $this->postData()[1];

            $this->connectDb();

            if ($this->validateEmailPassword($email,$password)[0] && $this->validateEmailPassword($email,$password)[1]){
                $this->insertEmailPassword($this->connectDb(),$email,$password);
            }else{
                $errorMessage = $this->messageError($email,$password);
            }

        return $errorMessage;
    }

   public function executeLogin(): array
   {
       $email = $this->postData()[0];
       $password = $this->postData()[1];

       $this->connectDb();

       if ($this->validateEmailPassword($email,$password)[0] && $this->validateEmailPassword($email,$password)[1]){

       }else{
           $errorMessage = $this->messageError($email,$password);
       }

       return $errorMessage;
   }

   private function compareEmailPassword(): array{
        $bad_message= '';


        return $bad_message;
   }





}