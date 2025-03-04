<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : "Alapértelmezett cím"; ?></title>
    <meta name="author" content="Tóth Zsófia, Zsíros Kata">
    
    <?php 
    $current_path = $_SERVER['REQUEST_URI'];
    $base_path = (strpos($current_path, '/admin/') !== false || strpos($current_path, '/main/') !== false) ? '../' : '';

    ?>

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo $base_path; ?>cowPicture/cowfavicon.png">
    
    <!-- alap css fájlok betöltése -->
    <link rel="stylesheet" href="<?php echo $base_path; ?>css/footer.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>css/nav.css">

    <!-- egyedi css fájlok betöltése -->
    <?php 
    if (!empty($custom_css)) { 
        foreach ($custom_css as $css) {
            echo "<link rel='stylesheet' href='$css'>\n";
        }
    }
    ?>
    <!-- sweetalert és az egyedi js fájlok betöltése -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo $base_path; ?>js/nav.js"></script>
    <?php 
    if (!empty($custom_js)) { 
        foreach ($custom_js as $js) {
            echo "<script src='$js' defer></script>\n";
        }
    }
    ?>
    <!-- SweetAlert2 CSS és JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <!-- Your page content -->
</body>
</html>
