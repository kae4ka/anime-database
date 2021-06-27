<!doctype html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <?php
            $hostname = "std-mysql";
            $db = "std_1401_animebase";
            $username = "std_1401_animebase";
            $password = "PolytechAnimeBase";
            $charset = 'utf8';
            $dsn = "mysql:host=$hostname;dbname=$db;charset=$charset";
            $opt = [
                   PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                   PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                   PDO::ATTR_EMULATE_PREPARES   => false,
                   ];
            $link = new PDO($dsn, $username, $password, $opt);
        ?>
    </body>
</html>