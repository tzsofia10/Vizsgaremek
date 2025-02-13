<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/slider.css">
    <title>Gazdanapló</title>
   
    
</head>
<body>
    <header>
        <h1>Gazdanapló</h1>
        <p>Üdvözöljük a gazdálkodók digitális naplójában!</p>
        <?php include './nav.php'; ?>
    </header>

    <main>
    <div class="slideshow-container">

            <div class="mySlides fade">
         
                <img src="../cowPicture/sliderPC/001.jpg" alt="Cowpic1" style="width:100%">
                
            </div>
            
            <div class="mySlides fade">
          
                <img src="../cowPicture/sliderPC/DSC_1089.JPG" alt="Cowpic2" style="width:100%">
                
            </div>
            
            <div class="mySlides fade">
                <img src="../cowPicture/sliderPC/DSC_1104.JPG" alt="Cowpic3" style="width:100%">
                
            </div>

            <a class="prev" onclick="plusSlides(-1)">❮</a>
            <a class="next" onclick="plusSlides(1)">❯</a>
            
           
            <br>
            
            <div style="text-align:center">
                <span class="dot" onclick="currentSlide(1)"></span> 
                <span class="dot" onclick="currentSlide(2)"></span> 
                <span class="dot" onclick="currentSlide(3)"></span> 
            </div>
        </div>
        
    </main>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>
    <script src="../js/slider.js"></script>
</body>
</html>
