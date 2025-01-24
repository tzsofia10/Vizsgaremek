<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/fooldal.css">
    <link rel="stylesheet" href="../css/footer.css">
    <title>Gazdanapló</title>
   
    
</head>
<body>
    <header>
        <h1>Gazdanapló</h1>
        <p>Üdvözöljük a gazdálkodók digitális naplójában!</p>
    </header>

    <header>
        <?php include './nav.php'; ?>
    </header>

    <main>
        <section id="napi-bejegyzesek">
            <h2>Napi Bejegyzések</h2>
            <p>Itt adhatja meg a napi teendőket, jegyzeteket, vagy eseményeket.</p>
        </section>

        <section id="statisztikak">
            <h2>Statisztikák</h2>
            <p>Tekintse meg a gazdaság teljesítményéről szóló statisztikákat és elemzéseket.</p>
        </section>

        <section id="kapcsolat">
            <h2>Kapcsolat</h2>
            <p>Ha bármilyen kérdése van, vegye fel velünk a kapcsolatot.</p>
        </section>
    </main>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>
