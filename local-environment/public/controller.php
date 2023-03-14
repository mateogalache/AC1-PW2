<?php

use JetBrains\PhpStorm\NoReturn;

$EMAIL_MESSAGE = "Email is not valid";
$PASSWORD_MESSAGE = "Password must contain at least one number, one capital letter, one small letter, and should be longer than or equal to 7 characters";
$BAD_MESSAGE = "The email or the password are wrong, try again";
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
       $email_message = '';
       $password_message = '';
       $bad_message = '';

       $this->connectDb();

       if ($this->validateEmailPassword($email,$password)[0] && $this->validateEmailPassword($email,$password)[1]){
            $bad_message = $this->compareEmailPassword($this->connectDb());
       }else{
           $errorMessage = $this->messageError($email,$password);
           $email_message = $errorMessage[0];
           $password_message = $errorMessage[1];
       }

       return array($email_message,$password_message,$bad_message);
   }

   private function compareEmailPassword(PDO $connection): string
   {
        $bad_message= '';

        $statement = $connection->prepare("SELECT * FROM Users WHERE email =?");
        $statement->execute([$_POST['email']]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

       if ($user && !strcmp($_POST['password'],$user['password']))
       {
           //$_SESSION["login"] = "OK";
           //$_SESSION["username"] = $_POST['email'];
           $redirect = "private.php";
           header("Location: /search.php");
           exit;
           // $bad_message = $user['password'];

       } else {
          $bad_message = "The email or the password are wrong, try again";
           //$bad_message = $user['password'] . $_POST['password'];
       }
        return $bad_message;
   }

   public function getCats(string $url): mixed
   {
       $client = new GuzzleHttp\Client();
       try {
           $res = $client->request('GET',$url , [
               'Content-type' => 'application/json',
               'x-api-key' => 'live_INrtVm1T5YHM0v8KCjO6PKHJqhxq5igHcSXl75XSja04ZGHO2Oq4MNXP86imhu0x'
           ]);
           $catsInfo = json_decode($res->getBody()->getContents());
       } catch (\GuzzleHttp\Exception\GuzzleException $e) {
           echo 'bad request';
       }
       return $catsInfo;
   }






}