<?php

use GuzzleHttp\Client;

require_once __DIR__ . '/vendor/autoload.php';
include 'controller.php';
class search{

    public function searchExecution(): mixed
    {

        $search = '';

        if(!EMPTY($_POST) && isset($_POST['searchButton'])) {
            $search = $_POST['search'];
            $url = "https://api.thecatapi.com/v1/images/search?breeds_id={$search}&limit=100";

        } else{
            $url = "https://api.thecatapi.com/v1/images/search?limit=100";
        }

        $controller = new controller();

        return $controller->executeSearch($search,$url);
    }
}

session_start();

if(!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}else{
$search = new search();
$catsInfo = $search->searchExecution();


}


?>

<html>
    <div class="container">
        <form  action="search.php" class="searchbar" method="POST">
            <input type="text" placeholder="Search" id="search" name="search">
            <input type="submit" value="Search" class="searchButton" name="searchButton">
        </form>

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