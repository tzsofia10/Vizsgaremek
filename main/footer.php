<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $cleanedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

    // E-mail cím ellenőrzése
    if (filter_var($cleanedEmail, FILTER_VALIDATE_EMAIL)) {
        echo "Érvényes és tiszta e-mail cím: " . htmlspecialchars($cleanedEmail);
    } else {
        echo "Hibás e-mail cím.";
    }
}
?>


<footer>
    <div class="container">        
        <h3>Elérhetőségek</h3>
        <div class="contacts">
            <p>E-mail</p>
            <p><a href="mailto:zsiros.kata02@gmail.com">zsiros.kata02@gmail.com</a></p>
            <p><a href="mailto:tothzsofiaa2016@gmail.com">tothzsofiaa2016@gmail.com</a></p>
            <p></p>
        </div>
        <div class="newsletter">
            <h4>Feliratkozz a hírlevélre!</h4>
            <form method="post" action="">
                <input type="email" name="email" placeholder="E-mail cím" required>
                <input type="submit" value="Küldés">
            </form>

        </div>
        <p class="center">&copy; 2025 Gazdanapló.</p>
    </div>

</footer>