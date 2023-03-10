<?php
    require_once __DIR__ . '/vendor/autoload.php';



   // $search = $_POST['search'];
    $client = new GuzzleHttp\Client();
    try {
        $res = $client->request('GET', "https://api.thecatapi.com/v1/images/search?breeds_id=asy&limit=100", [
            'Content-type' => 'application/json',
            'x-api-key' => 'live_INrtVm1T5YHM0v8KCjO6PKHJqhxq5igHcSXl75XSja04ZGHO2Oq4MNXP86imhu0x'
        ]);
        $catsInfo = json_decode($res->getBody()->getContents()) ;
    } catch (\GuzzleHttp\Exception\GuzzleException $e) {
        echo 'bad request';
    }




?>

<html>
    <div class="container">
        <form  action="search.php" class="searchbar">
            <input type="text" placeholder="Search" id="search" name="search">
            <input type="submit" value="Search">
        </form>

            <div class="cats">
                <?php

                foreach ($catsInfo as $cats) {
                    echo "<div class='cat'>";
                    echo "<img src='" . $cats->url . "'>";
                    echo "<div class= 'info'>";
                    echo "<div>";
                    echo "Width: " . $cats->width . "px\n" ;
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
    }

    .container{
        width: 100%;
        height: 100%;
    }
    .searchbar{
        margin-top: 2rem ;
        display: flex;
        justify-content: space-between;
        width: 100%;
    }
    .searchbar input:first-child{
        border-radius: 50px;
        border: 2px solid black;
        padding: 1rem;
        width: 99%;
    }
</style>