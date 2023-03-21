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
        $hashed_password = password_hash($password,PASSWORD_DEFAULT);
        $statement = $connection->prepare('INSERT INTO Users (email, password,created_at,updated_at) VALUES (:email, :password,NOW(),NOW())');

        $statement->bindParam('email',$email,PDO::PARAM_STR);
        $statement->bindParam('password',$hashed_password,PDO::PARAM_STR);
        $statement->execute();
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


       if ($user && password_verify($_POST['password'],$user['password']))
       {
           session_start();
           $_SESSION['id'] = $user['user_id'];

           header("Location: /search.php");
           exit;


       } else {
          $bad_message = "The email or the password are wrong, try again";

       }
        return $bad_message;
   }

   private function getCats(string $url): mixed
   {
       $client = new GuzzleHttp\Client();
       try {
           $res = $client->request('GET',$url, [
               'Content-type' => 'application/json',
               'x-api-key' => 'live_INrtVm1T5YHM0v8KCjO6PKHJqhxq5igHcSXl75XSja04ZGHO2Oq4MNXP86imhu0x'
           ]);
           $catsInfo = json_decode($res->getBody()->getContents());
       } catch (\GuzzleHttp\Exception\GuzzleException $e) {
           echo 'bad request';
       }
       return $catsInfo;
   }

   private function saveSearch(string $search): void
   {
       $connection = $this->connectDb();

       $statement = $connection->prepare('INSERT INTO Search (query,timestamp) VALUES (:search,NOW())');
       $statement->execute([
           'search' => $search,
       ]);

   }



   private function getCatId(): array
   {
       $connection = $this->connectDb();
       $statement = $connection->prepare('SELECT (cat_search_id) FROM Search ORDER BY cat_search_id DESC LIMIT 1');
       $statement->execute();
       return $statement->fetch(PDO::FETCH_ASSOC);
   }

  private function saveUserSearch(): void{
        $cat_search = $this->getCatId();
        $statement = $this->connectDb()->prepare('INSERT INTO UserHistory (user_id,cat_search_id) VALUES (:user_id, :cat_search_id) ');
          $statement->execute([
              'user_id' => $_SESSION['id'],
              'cat_search_id' => $cat_search['cat_search_id'],
          ]);
   }


   public function executeSearch(string $search,string $url): mixed
   {
        if (!EMPTY($_POST)){
            $this->saveSearch($search);
            $this->saveUserSearch();
        }
       //$this->saveUserSearch();
       return $this->getCats($url);
   }






}