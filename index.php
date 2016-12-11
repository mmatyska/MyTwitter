<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include_once 'src/polaczenie.php';
        include_once 'src/User.php';
        include_once 'src/Tweet.php';
        
        $conn = new prototypPolaczenia('warsztaty2');
        User::$conn = $conn->getConn();
        
        $tweetsObj = new Tweet();
        $usersObj = new User();
        
        echo "<h3>Lista wpisów:</h3>";
        echo "<table>";
        foreach ($tweetsObj->loadAllTweets() as $rows){
           echo "<tr>";
           echo "<td>{$rows->getTweet()}</td>";
           echo "</tr>";
        }
        echo "</table>";
        ?>
    </body>
</html>
