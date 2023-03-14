<?php
require_once __DIR__ . '/vendor/autoload.php';
include 'controller.php';
class Register{
    public function registerExecution(): array
    {
        $controller = new controller();
        return $controller->executeRegister();
    }
}

$email_message = '';
$password_message = '';

if (!empty($_POST)) {
    $register = new Register();
    $messageError = $register->registerExecution();
    $email_message = $messageError[0];
    $password_message = $messageError[1];
}

?>

<html>
<div class="container">
    <div class="container0">
        <div class="title">SIGN UP</div>
        <form action="Register.php" method="POST" class="formInputs">
            <input type="text" placeholder="Email" name="email" class="forms" id="email">
            <p class= "errorMessage "> <?php echo $email_message ?></p>
            <input type="password" placeholder="Password" name="password" class="forms" id="email">
            <p class= "errorMessage "> <?php echo $password_message ?></p>
            <input type="submit" value="Register" class="registerButton">
        </form>
        <aside class="alreadyLogged">Already registered? <a href="/login.php"> Sign in</a></aside>
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
        width: 30rem;
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
