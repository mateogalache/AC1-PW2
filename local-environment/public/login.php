<?php
require_once __DIR__ . '/vendor/autoload.php';

class login{
    public function loginExecution(): array
    {
        $controller = new controller();
        return $controller->executeLogin();
    }
}
$email_message = '';
$password_message = '';
$bad_message = '';

if (!empty($_POST)) {
    $login = new Login();
    $messageError = $login->loginExecution();
    $email_message = $messageError[0];
    $password_message = $messageError[1];
    $bad_message = $messageError[2];
}







?>
<html>
<div class="container">
    <div class="container0">
        <div class="title">SIGN IN</div>
        <form action="Register.php" method="POST" class="formInputs">
            <input type="text" placeholder="Email" name="email" class="forms" id="email">
            <p class= "errorMessage "> <?php echo $email_message ?></p>
            <input type="password" placeholder="Password" name="password" class="forms" id="email">
            <p class= "errorMessage "> <?php echo $password_message ?></p>
            <input type="submit" value="LOG IN" class="registerButton">
        </form>
        <aside class="alreadyLogged">Not registered? <a href="/Register.php"> Sign up</a></aside>
    </div>
</div>
</html>
<style>
    .alreadyLogged a{
        text-decoration: none;
        color: blue;
    }
    .alreadyLogged{
        width: 100%;
        display: flex;
        justify-content: end;
        margin-top: -1rem;
        gap: .5rem;
    }
    .errorMessage{
        color: red;
        text-align: center;
        width: 25rem;
    }
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
        width: 30rem;
        height: 25rem;
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
