<!doctype html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <!-- Файл подключения к базе данных -->
        <?php require_once('connection.php'); ?>
        <title>Типы аниме</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- Поле навигации -->
        <h2>База данных аниме</h2>
        <nav>
            <a class="nav" href="index.php">Главная</a>
            <a class="nav" href="animegenre.php">Аниме по жанрам</a>
            <a class="nav" href="animestudio.php">Аниме по студии</a>
            <a class="nav" href="types.php">Типы</a>
            <a class="nav" href="genres.php">Жанры</a>
            <a class="nav" href="studios.php">Студии</a>
        </nav>
        <!-- Заголовок страницы -->
        <h4>Типы</h4>
        <?php
        // Вывод данных из таблицы "Типы"
        $query = "SELECT * FROM `types`";
        $stmt = $link->query($query);
        echo "<section>
                <table><tr>
                <th>ID</th>
                <th>Тип</th>
                </tr>";  
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            echo '<tr>
            <td>'.$row['id'].'</td>
            <td>'.$row['type'].'</td>
            </tr>';
        }
        echo '</section>';
        // Если форма отправлена
        if (!empty($_POST))
        {
            $type = $_POST['anime_type'];
            $query = "INSERT INTO `types` (`type`)
                      VALUES (:type)";
            $stmt = $link->prepare($query);
            $data = array(
                'type' => "$type",
            );
            $stmt->execute($data);
        }
        ?>
        <!-- Форма для ввода данных в таблицу "Типы" -->
        <section>
            <form action="" method="post">
                <label for="anime_type">Введите тип: </label>
                <input type="text" name="anime_type">
                <input type="submit" value="Добавить">
            </form>
        </section>
    </body>
</html>