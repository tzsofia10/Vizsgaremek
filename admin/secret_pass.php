<?php
// Hash-eljük a "ferkotanya" szót bcrypt-tel
$text_to_hash = "ferkotanya";

// Hash létrehozása bcrypt-tel
$hashed_text = password_hash($text_to_hash, PASSWORD_BCRYPT);

// Hash megjelenítése
echo $hashed_text;
?>
