<?php
// Teszteljük, hogy a PHP fut-e egyáltalán
echo "PHP működik";

// Teszteljük, hogy hozzáférünk-e az adatbázishoz
try {
    $pdo = new PDO('mysql:host=localhost;dbname=kisallatbir_balazsbettina', 'kisallatbirsql', 'sqlTV2VRv');
    echo "<br>Adatbázis kapcsolat sikeres!";
} catch (PDOException $e) {
    echo "<br>Adatbázis hiba: " . $e->getMessage();
}
?>