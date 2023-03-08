<?php
require_once __DIR__ . '/vendor/autoload.php';

final class Register{



    public function sqlRegister(): void{
        $user = 'admin';
        $pass = 'admin';
        $connection = new PDO('mysql:host=db:3306;dbname=test',$user,$pass);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $password = preg_match("^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{7,}$"
            ,$_POST['password']);

        if ($email && $password){
            $statement = $connection->prepare('INSERT INTO Users (email, passwod) VALUES (:email, :password)');
            $statement->execute([
                'email' => $email,
                'password' => $password,
            ]);
        }else{
            //show error
        }
    }

}

$register = new Register;



?>
<html>
<div class="container">
    <div class="container0">
        <div class="title">SIGN UP</div>
        <form action="Register.php" method="POST" class="formInputs">
            <input type="email" placeholder="Email" name="email" class="forms" id="email">
            <input type="password" placeholder="Password" name="password" class="forms" id="email">
            <input type="submit" value="Register" class="registerButton">
        </form>
    </div>
</div>
</html>
<style>
    .container{
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }
    .container0{
        display: flex;
        align-items: center;
        flex-direction: column;
        gap: 2rem;
        border: black solid 2px;
        border-radius: 50px;
        padding: 5rem;
    }
    .formInputs{
        display: flex;
        align-items: center;
        flex-direction: column;
        gap: 1rem;
    }
    .title{
        font-size: 50px;
    }
    .registerButton{
        font-size: 25px;
        background: none;
        border-radius: 50px;
        cursor: pointer;
        margin-top: 1.5rem;
        transition: all 300ms ease;
    }
    .registerButton:hover{
        color: white;
        background: black;
    }
    .forms{
        width: 20rem;
        height: 2rem;
    }

</style>
