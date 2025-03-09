<?php
// Betöltjük a kapcsolódási fájlt
require_once __DIR__ . '/connect.php';

try {
    // A $dbconn változó már elérhető a connect.php-ból
    if (!$dbconn) {
        throw new Exception("Adatbázis kapcsolódási hiba");
    }

    // Cikkek lekérése az adatbázisból
    $sql = "SELECT * FROM news ORDER BY creation DESC";
    $result = mysqli_query($dbconn, $sql);
    
    if (!$result) {
        throw new Exception("Hiba a lekérdezés során: " . mysqli_error($dbconn));
    }
    
    $articles = mysqli_fetch_all($result, MYSQLI_ASSOC);

} catch(Exception $e) {
    echo "Hiba: " . $e->getMessage();
    exit();
}
// ... a többi kód változatlan marad ... 
// Cikkek lekérése az adatbázisból
$sql = "SELECT * FROM news ORDER BY creation DESC";
$result = mysqli_query($dbconn, $sql);

if (!$result) {
    throw new Exception("Hiba a lekérdezés során: " . mysqli_error($dbconn));
}

$articles = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Népszerű cikkek lekérése
$popular_sql = "SELECT * FROM news ORDER BY creation DESC LIMIT 3";
$popular_result = mysqli_query($dbconn, $popular_sql);

if (!$popular_result) {
    throw new Exception("Hiba a lekérdezés során: " . mysqli_error($dbconn));
}

$popular_articles = mysqli_fetch_all($popular_result, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hírek Oldal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <style>
        .navbar {
            background-color: #333;
            padding: 1rem;
        }

        .swiper {
            width: 100%;
            height: 400px;
        }

        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .article-card {
            margin-bottom: 20px;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .article-card:hover {
            transform: translateY(-5px);
        }

        .article-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .footer {
            background-color: #333;
            color: white;
            padding: 2rem 0;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .swiper {
                height: 250px;
            }
            
            .sidebar {
                margin-top: 20px;
            }
        }
    </style>
</head>
<?php 
    $page_title = "Főoldal"; 
    $custom_css = ["css/pages/newpage.css"]; // egyedi css fájl hozzáadása
    $additional_head = "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>"; 
    include 'main/head.php'; 
?>


<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Főoldal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Hírek</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Rólunk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kapcsolat</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Slider -->
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="cowPicture/slider/header01.jpg" alt="Slider 1">
            </div>
            <div class="swiper-slide">
                <img src="cowPicture/slider/header02.jpg" alt="Slider 2">
            </div>
            <div class="swiper-slide">
                <img src="cowPicture/slider/header03.jpg" alt="Slider 3">
            </div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <!-- Tartalom -->
    <div class="container mt-4">
        <div class="row">
            <!-- Bal oldali cikkek -->
            <div class="col-lg-8">
                <?php foreach($articles as $article): ?>
                <div class="article-card card">
                    <?php if(!empty($article['image_url'])): ?>
                    <img src="<?php echo htmlspecialchars($article['image_url']); ?>" 
                         class="article-image card-img-top" 
                         alt="<?php echo htmlspecialchars($article['title']); ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($article['nav_name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars(substr($article['content'], 0, 200)) . '...'; ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="article.php?id=<?php echo $article['id']; ?>" class="btn btn-primary">Tovább olvasom</a>
                            <small class="text-muted">
                                <?php echo date('Y.m.d', strtotime($article['creation'])); ?>
                            </small>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Jobb oldali sidebar -->
            <div class="col-lg-4 sidebar">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Népszerű cikkek</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php foreach($popular_articles as $popular): ?>
                        <li class="list-group-item">
                            <a href="article.php?id=<?php echo $popular['id']; ?>" class="text-decoration-none text-dark">
                                <?php echo htmlspecialchars($popular['nav_name']); ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'main/footer.php'; ?>


    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
        });
    </script>
</body>
</html> 