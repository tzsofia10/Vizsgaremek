<?php
require_once("connect.php");

// Menü lekérése - abc sorrend a nav_name szerint
$sql = "SELECT id, alias, nav_name FROM news WHERE states = 1 ORDER BY nav_name ASC";
$result = mysqli_query($dbconn, $sql);

$menu_items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $menu_items[] = $row;
}

// Összes cikk lekérése
$sql = "SELECT * FROM news WHERE states = 1 ORDER BY creation DESC";
$result = mysqli_query($dbconn, $sql);
$articles = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Legújabb 3 cikk a sidebar-hoz - időrend szerint, a legújabbak elöl
$newest_sql = "SELECT * FROM news WHERE states = 1 ORDER BY creation DESC LIMIT 3";
$newest_result = mysqli_query($dbconn, $newest_sql); 
$newest_articles = mysqli_fetch_all($newest_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="hu"> 
<?php
$page_title = "Főoldal";
$custom_js = ["../js/translate.js"];
$custom_css = ["https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css", "css/pages/indexpage.css"];
include 'main/head.php';
?>

<body>
    <!-- Navbar -->
    <?php include 'main/nav.php'; ?>
    <!-- Slider (Bootstrap) -->
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner position-relative">
        <div class="carousel-item active">
            <img src="cowPicture/slider/header01.jpg" class="d-block w-100" alt="Slider 1">
        </div>
        <div class="carousel-item">
            <img src="cowPicture/slider/header02.jpg" class="d-block w-100" alt="Slider 2">
        </div>
        <div class="carousel-item">
            <img src="cowPicture/slider/header03.jpg" class="d-block w-100" alt="Slider 3">
        </div>
    </div>
    
    <!-- Navigation buttons -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Előző</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Következő</span>
    </button>
    
    <!-- Constant buttons below the images -->
    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-3">
        <button class="btn btn-primary me-2" id="vacinationButton"><a href="main/vacination.php"> Oltások</a> </button>
        <button id="playSound" class="btn btn-secondary moo">Múúúú</button>
        <audio id="audio" src="./hang mu/cowmu.mp3"></audio> 
        

    </div>
</div>
   <?php $alias = isset($_GET['alias']) ? $_GET['alias'] : null; ?>
    <div class="container">
        <div class="row">
            <!-- Bal oldali menü és cikkek -->
            <div class="col-3">
                <div class="menu">
                    <h5>Menü</h5>
                    <?php foreach($menu_items as $item): ?>
                        <a href="?alias=<?php echo htmlspecialchars($item['alias']); ?>" 
                        class="<?php echo ($alias === $item['alias']) ? 'active-article' : ''; ?>">
                            <?php echo htmlspecialchars($item['nav_name']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- Középső tartalom -->
            <div class="col-6">
                <?php 
                $alias = isset($_GET['alias']) ? $_GET['alias'] : null;
                if ($alias) {
                    $sql = "SELECT * FROM news WHERE alias = '" . mysqli_real_escape_string($dbconn, $alias) . "' AND states = 1 LIMIT 1";
                    $result = mysqli_query($dbconn, $sql);
                    $article = mysqli_fetch_assoc($result);
                    
                    if ($article): ?>
                        <div class="article-card">
                            <?php if(!empty($article['img'])): ?>
                                <img src="uploads/<?php echo htmlspecialchars($article['img']); ?>" class="article-image" alt="<?php echo htmlspecialchars($article['nav_name']); ?>">
                            <?php endif; ?>
                            <h2><?php echo htmlspecialchars($article['nav_name']); ?></h2>
                            <p><?php echo $article['content']; ?></p>
                            <div class="text-muted mt-3">
                                Létrehozva: <?php echo date('Y.m.d', strtotime($article['creation'])); ?>
                            </div>
                        </div>
                    <?php endif;
                } else {
                    if (!empty($articles)): 
                        $article = $articles[0]; ?>
                        <div class="article-card">
                            <?php if(!empty($article['img'])): ?>
                                <img src="uploads/<?php echo htmlspecialchars($article['img']); ?>" class="article-image" alt="<?php echo htmlspecialchars($article['nav_name']); ?>">
                            <?php endif; ?>
                            <h2><?php echo htmlspecialchars($article['nav_name']); ?></h2>
                            <p><?php echo $article['content']; ?></p>
                            <div class="text-muted mt-3">
                                Létrehozva: <?php echo date('Y.m.d', strtotime($article['creation'])); ?>
                            </div>
                        </div>
                    <?php endif;
                }
                ?>
            </div>

            <!-- Jobb oldali sidebar -->
            <div class="sidebar">
                <div class="menu">
                    <h5>Legújabb cikkek</h5>
                    <ul>
                        <?php foreach($newest_articles as $news): ?>
                            <li>
                                <a href="?alias=<?php echo htmlspecialchars($news['alias']); ?>" class="<?php echo ($alias === $news['alias']) ? 'active-article' : ''; ?>">
                                    <?php echo htmlspecialchars($news['nav_name']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <script>
      document.getElementById("playSound").addEventListener("click", function () {
        document.getElementById("audio").play();
      });
    </script>
    <footer>
        <?php include 'main/footer.php'; ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
