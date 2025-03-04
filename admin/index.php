<?php
session_start();

if (isset($_POST['submit'])) {
    $email = strip_tags(strtolower(trim($_POST['email'])));
    $password = $_POST['password'];

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Érvénytelen e-mail cím vagy jelszó!";
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
                echo "Bejelentkezés sikeres!";
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_email'] = $row['email'];
                header("Location: list.php");
                exit;
            } else {
                echo "A jelszó nem egyezik!";
            }
        } else {
            echo "Az email nem található az adatbázisban!";
        }

        $stmt->close();
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Panel Login</title>
<link href="../css/adminpanel.css" rel="stylesheet">
</head>

<body>
<h1>Login</h1>
<form method="post" action="">
    <?php if (isset($error)) echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
    <p><label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required></p>
    <p><label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required></p>
    
    <input type="submit" id="submit" name="submit" value="Belépés">
</form>
</body>
</html>
