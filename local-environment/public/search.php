<?php

use GuzzleHttp\Client;

require_once __DIR__ . '/vendor/autoload.php';
include 'controller.php';
class search{

    public function searchExecution(): mixed
    {

        $search = $_POST['search'];
        if(!EMPTY($_POST)) {

            $url = "https://api.thecatapi.com/v1/images/search?breeds_id={$search}&limit=100";

        } else{
            $url = "https://api.thecatapi.com/v1/images/search?limit=100";
        }

        $controller = new controller();

        return array($controller->executeSearch($search,$url),$controller->getHistory());
    }
}
//session_start();
/*
if(!(isset($_SESSION["login"]) && $_SESSION["login"] == "OK")) {
    header("Location: login.php");
    exit;
}else{
*/

$search = new search();
$Info = $search->searchExecution();
$catsInfo = $Info[0];
$history = $Info[1];



?>

<html>
    <div class="container">
        <form  action="search.php" class="searchbar" method="POST">
            <input type="text" placeholder="Search" id="search" name="search">
            <input type="submit" value="Search" class="searchButton">
        </form>
        <div class="history">
            <h3>History: </h3>
            <?php
            $history = array_slice(array_reverse($history),0,10);
            foreach ($history as $his){
                echo "<div>";
                echo $his['query'];
                echo"</div>";
                echo "<div>";
                echo "|";
                echo"</div>";
            }
            ?>
        </div>
        <div class="cats">
            <?php
                foreach ($catsInfo as $cats) {
                    echo "<div class='cat'>";
                    echo "<img src='" . $cats->url . "'>";
                    echo "<div class= 'info'>";
                    echo "<div>";
                    echo "Width: " . $cats->width . "px" ;
                    echo"</div>";
                    echo "<div>";
                    echo  "Height: " . $cats->height . "px" ;
                    echo "</div></div></div>";
                }
            ?>
        </div>
    </div>
</html>
<style>

    .history{
        width: 98%;
        height: 2rem;
        border: solid black 2px;
        display: flex;
        align-items: center;
        padding-left: 1rem;
        gap: .5rem;
    }
    .searchButton{
        background: none;
        border-radius: 50%;
        cursor: pointer;
        transition: all 300ms ease;
    }
    .searchButton:hover{
        background: black;
        color: white;
    }
    .cat img {
        width: 25rem;
        aspect-ratio: 1/1;
    }
    .cat {
        display: block;
    }
    .info{
        display: flex;
        flex-direction: column;
        text-align: center;
    }
    .cats{
        width: 100%;
        gap: 1rem;
        justify-content: center;
        display: flex;
        flex-wrap: wrap;
        margin-top: 2rem;
    }

    .container{
        width: 100%;
        height: 100%;
    }
    .searchbar{
        margin-top: 2rem ;
        display: flex;
        justify-content: center;
        gap: 1rem;
        width: 100%;
    }
    .searchbar input:first-child{
        border-radius: 50px;
        border: 2px solid black;
        padding: 1rem;
        width: 95%;
    }
</style>