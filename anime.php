<!doctype html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <?php
        // Файл подключения к базе данных
        require_once('connection.php');
        // Получаем id выбранного аниме
        $anime_id = $_GET['anime_id'];
        // Запрос на получение названия и описания аниме из таблицы anime
        $query = "SELECT title, description
                  FROM `anime`
                  WHERE anime_id = $anime_id";
        $stmt = $link->query($query);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $title = $row['title'];
            $description = $row['description'];
        }
        // Если изображение отправлено на сайт
        if (isset($_POST["MAX_FILE_SIZE"]))
        {
            $tmp_file_name = $_FILES["user_file"]["tmp_name"];
            $dest_file_name = $_SERVER['DOCUMENT_ROOT']."/screenshots/"."$anime_id/".basename($_FILES["user_file"]["name"]);
            // Формируем ассоциативный массив ошибка->описание ошибки
            $phpFileUploadErrors = array(
                1 => 'Размер принятого файла превысил максимально допустимый размер (2 МБ)',
                2 => 'Размер принятого файла превысил максимально допустимый размер (2 МБ)',
                3 => 'Загружаемый файл был получен только частично',
                4 => 'Файл не был загружен',
                6 => 'Отсутствует временная папка',
                7 => 'Не удалось записать файл на диск',
                8 => 'PHP-расширение остановило загрузку файла',
            );
        }
        ?>
        <title><?php echo $title;?></title>
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
        <!-- Название аниме в виде заголовка -->
        <header> <?php echo '<h3>'.$title.'</h3>'; ?> </header>
        <?php
        // Вывод жанров аниме
        if ($anime_id)
        {
            echo '<section><h4>Жанры</h4><p>';
            $query = "SELECT genres.genre FROM `animegenre`
                      INNER JOIN `genres` ON genres.id=genre_id
                      WHERE anime_id = $anime_id";
            $stmt = $link->query($query);
                
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                echo $row['genre'].'<br>';
            }
            echo '</p>';
        }
        ?>
        <!-- Форма добавления жанра аниме -->
        <form action="" method="post">
                <label for="anime_genre">Добавить жанр: </label>
                <select name="anime_genre">
                <?php
                $query = "SELECT * FROM `genres`";
                $stmt = $link->query($query);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    echo '<option value="'.$row['id'].'">'.$row['genre'].'</option>';
                }
                ?>
                </select>
                <input type="submit" value="Добавить">
        </form></section>
        <?php
        // Вывод студий аниме
        if ($anime_id)
        {
            echo '<section><h4>Студии</h4><p>';
            $query = "SELECT studios.studio FROM `animestudio`
                      INNER JOIN `studios` ON studios.id=studio_id
                      WHERE anime_id = $anime_id";
            $stmt = $link->query($query);
                
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                echo $row['studio'].'<br>';
            }
            echo '</p>';
        }
        ?>
        <!-- Форма добавления студии аниме -->
        <form action="" method="post">
                <label for="anime_studio">Добавить студию: </label>
                <select name="anime_studio">
                <?php
                $query = "SELECT * FROM `studios`";
                $stmt = $link->query($query);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    echo '<option value="'.$row['id'].'">'.$row['studio'].'</option>';
                }
                ?>
                </select>
                <input type="submit" value="Добавить">
        </form></section>
        <?php
        // Вывод описания аниме
        echo '<section><h4>Описание</h4><p>'.$description.'</p></section>';
        // Вывод кадров аниме
        if ($anime_id)
        {
            echo '<section><h4>Кадры</h4>';
            $query = "SELECT screenshot_link FROM `screenshots`
                      WHERE anime_screenshot_id = $anime_id AND cover=0";
            $stmt = $link->query($query);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                echo '<img class="screenshots" src="'.$row['screenshot_link'].'">';
            }
            echo '</section>';
        }
        ?>
        <!-- Форма для отправки на сервер файла -->
        <section>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="MAX_FILE_SIZE" value="20971520" />
                <label for="user_file">Добавить кадр</label>
                <input type="file" name="user_file">
                <input type="submit">
            </form>
        </section>
        <?php
        // Отправить загруженный файл в папку сервера и вывести результат
        if (move_uploaded_file($tmp_file_name, $dest_file_name))
        {
            echo "Файл корректен и был успешно загружен.\n";
            $screenshot_link  = 'screenshots/'.$anime_id.'/'.$_FILES["user_file"]["name"];
            $data = [
                'anime_screenshot_id' => $anime_id,
                'screenshot_link' => $screenshot_link,
                'cover' => 0,
            ];
            $query = "INSERT INTO `screenshots` (`anime_screenshot_id`, `screenshot_link`, `cover`)
                      VALUES (:anime_screenshot_id, :screenshot_link, :cover)";
            $stmt = $link->prepare($query);
            $stmt->execute($data);
            echo "<meta http-equiv='refresh' content='0'>";
        }
        else
        {
            echo $phpFileUploadErrors[$_FILES["user_file"]["error"]];
        }
        if ($_POST['anime_genre'])
        {
            $genre_id = $_POST['anime_genre'];
            $data = [
                'anime_id' => $anime_id,
                'genre_id' => $genre_id,
            ];
            $query = "INSERT INTO `animegenre` (`anime_id`, `genre_id`)
                      VALUES (:anime_id, :genre_id)";
            $stmt = $link->prepare($query);
            $stmt->execute($data);
            echo "<meta http-equiv='refresh' content='0'>";
        }
        if ($_POST['anime_studio'])
        {
            $studio_id = $_POST['anime_studio'];
            $data = [
                'anime_id' => $anime_id,
                'studio_id' => $studio_id,
            ];
            $query = "INSERT INTO `animestudio` (`anime_id`, `studio_id`)
                      VALUES (:anime_id, :studio_id)";
            $stmt = $link->prepare($query);
            $stmt->execute($data);
            echo "<meta http-equiv='refresh' content='0'>";
        }
        ?>
    </body>
</html>