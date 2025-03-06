<?php
require_once("connect.php");

function sanitize(string $data): string {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}


$sql = "SELECT id, alias, nav_name FROM news WHERE states = 1 ORDER BY ordering ASC";
$result = mysqli_query($dbconn, $sql);

$menu = "<ul>\n";
while ($row = mysqli_fetch_assoc($result)) {
    $menu .= "<li><a href=\"./" . sanitize($row['alias']) . "\">" . sanitize($row['nav_name']) . "</a></li>\n";
}
$menu .= "</ul>\n";

$alias = isset($_GET['alias']) ? mysqli_real_escape_string($dbconn, $_GET['alias']) : "bemutatkozas";
$sql = "SELECT nav_name, content, creation, updating, description, keywords FROM news WHERE alias = '$alias' LIMIT 1";
$result = mysqli_query($dbconn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $description = sanitize($row['description']);
    $keywords = sanitize($row['keywords']);
    $nav_name = sanitize($row['nav_name']);
    $content = $row['content'];
    $creation = sanitize($row['creation']);
} else {
    $description = "Hiba - Oldal nem található";
    $keywords = "404, hiba, nem található";
    $nav_name = "404 - Oldal nem található";
    $content = "<div class='error-container'>
                    <h1>404 - Oldal nem található</h1>
                    <p>A keresett oldal nem található vagy áthelyezésre került.</p>
                    <p><a href='./' class='btn btn-primary'>Vissza a főoldalra</a></p>
                </div>";
    $creation = date("Y-m-d H:i:s");
}

$template = file_get_contents("template.html");
$template = str_replace("{{menu}}", $menu, $template);
$template = str_replace("{{nav_name}}", $nav_name, $template);
$template = str_replace("{{content}}", $content, $template);
$template = str_replace("{{creation}}", $creation, $template);
$template = str_replace("{{description}}", $description, $template);
$template = str_replace("{{keywords}}", $keywords, $template);

echo $template;
?>

