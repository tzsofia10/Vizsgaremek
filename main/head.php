
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : "Alapértelmezett cím"; ?></title>
    
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="../cowPicture/cowfavicon.png">
    
    <!-- alap css fájlok betöltése -->
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/nav.css">

    <!-- egyedi css fájlok betöltése -->
    <?php 
    if (!empty($custom_css)) { 
        foreach ($custom_css as $css) {
            echo "<link rel='stylesheet' href='$css'>\n";
        }
    }
    ?>
    <script src="../js/nav.js"></script>
    <!-- egyedi js fájlok betöltése -->
    <?php 
    if (!empty($custom_js)) { 
        foreach ($custom_js as $js) {
            echo "<script src='$js' defer></script>\n";
        }
    }
    ?>
</head>
<body>
    <!-- Your page content -->
</body>
</html>
