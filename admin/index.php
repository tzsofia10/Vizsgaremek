<?php
session_start();

if (isset($_POST['submit'])) {
    $email = strip_tags(strtolower(trim($_POST['email'])));
    $password = $_POST['password'];

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "<div class='error-message'>Érvénytelen e-mail cím vagy jelszó!</div>";
    } else {
        require "../connect.php";
	
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $dbconn->prepare($sql);

        if (!$stmt) {
            die("Lekérdezési hiba: " . $dbconn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_email'] = $row['email'];
                header("Location: main.php");
                exit;
            } else {
                $error = "<div class='error-message'>A jelszó nem egyezik!</div>";
            }
        } else {
            $error = "<div class='error-message'>Az email nem található az adatbázisban!</div>";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
    <link href="../css/adminpanel.css" rel="stylesheet">
</head>

<body>
<h1>Bejelentkezés</h1>
<form method="post" action="">
    <?php if (isset($error)) echo $error; ?>
    <p><label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required></p>
    <p><label for="password">Jelszó:</label><br>
    <input type="password" id="password" name="password" required></p>
    
    <input type="submit" id="submit" name="submit" value="Belépés">
</form>
</body>
</html>
