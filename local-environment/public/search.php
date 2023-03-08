<?php
    require_once __DIR__ . '/vendor/autoload.php';


    if (!empty($_POST)) {
        $search = $_POST['search'];
        $client = new GuzzleHttp\Client();
        try {
            $res = $client->request('GET', "https://api.thecatapi.com/v1/images/search", [
                'Content-type' => 'application/json',
                'x-api-key' => 'live_INrtVm1T5YHM0v8KCjO6PKHJqhxq5igHcSXl75XSja04ZGHO2Oq4MNXP86imhu0x'
            ]);
            echo $res->getBody();
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {

        }

    }
?>

<html>
    <div class="container">
        <form  action="search.php" class="searchbar">
            <input type="text" placeholder="Search" id="search" name="search">
            <input type="submit" value="Search">
        </form>
        <div class="cats">

        </div>
    </div>
</html>
<style>
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