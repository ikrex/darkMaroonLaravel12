<?php
// migrate.php

// Titkos kulcs a jogosulatlan hozzáférés megakadályozására
$secretKey = 'valami_titkos_kulcs_amit_csak_te_tudsz';

// Ellenőrizd, hogy a helyes kulccsal hívták-e meg
if (!isset($_GET['key']) || $_GET['key'] !== $secretKey) {
    die('Jogosulatlan hozzáférés');
}

// Az alkalmazás betöltése
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

// A kernelt szerezzük meg
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Futtatjuk a migrációt
$status = $kernel->call('migrate', [
    '--force' => true, // Éles környezetben való futtatáshoz
]);

// Kijelezzük az eredményt
echo '<pre>' . $status . '</pre>';
echo '<h3>Migráció befejezve!</h3>';

// PHP script lezárása
$kernel->terminate(null, $status);
