<?php //index.php

require_once __DIR__.'/../vendor/autoload.php';

use \PommProject\Foundation\Pomm;

// 1. Initialisation de pomm
$pomm = new Pomm(['booking' => ['dsn' => 'pgsql://user:pass@host:port/db_name']]);

// 2. Exécution de la requête permettant de récupérer les salles
$result = $pomm['booking']
    ->getQueryManager()
    ->query('select * from room.room');
?>
<html>
    <head></head>
    <body>
        <h1>Pomm - Booking</h1>

        <p>Liste des chambres : </p>
        <?php if ($result->isEmpty()) { ?>
            <p>Aucune chambre</p>
        <?php }else{  ?>
            <ul>
                <?php
                // 3. On parcours les résultats
                foreach ($result as $room): ?>
                    <li><?php echo $room['name']; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php } ?>
    </body>
</html>