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
    <link rel="icon" href="/cowPicture/cowfavicon.png" type="image/png">
    <link rel="shortcut icon" href="/cowPicture/cowfavicon.png" type="image/png">

    
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
    <style>
    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }

    .fade-in.visible {
        opacity: 1;
        transform: translateY(0);
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('.fade-in');
        
        function checkScroll() {
            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;
                
                if (elementTop < windowHeight - 100) {
                    element.classList.add('visible');
                }
            });
        }
        
        window.addEventListener('scroll', checkScroll);
        checkScroll(); // Kezdeti ellenőrzés
    });
    </script>
</head>
<body>
    <!-- Your page content -->
</body>
</html>
