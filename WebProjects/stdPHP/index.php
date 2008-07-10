<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <title></title>
    </head>
    <body>
        <?php
            $conn = mysqli_connect('localhost', 'root', 'porfirio', 'autosys', '3306');
    if (!$conn) {
        die('Could not connect to MySQL: ' . mysqli_connect_error());
    }
    mysqli_query($conn, 'SET NAMES \'UTF-8\'');
    echo '<table>';
            echo '<tr>';
            echo '<th>name</th>';
            echo '<th>models</th>';
            echo '</tr>';
            $result = mysqli_query($conn, 'SELECT name, models FROM autosys_makes');
            while (($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) != NULL) {
                echo '<tr>';
                echo '<td>' . $row['name'] . '</td>';
                echo '<td>' . $row['models'] . '</td>';
                echo '</tr>';
            }
            mysqli_free_result($result);
            echo '</table>';
    mysqli_close($conn);
        ?>
    </body>
</html>
