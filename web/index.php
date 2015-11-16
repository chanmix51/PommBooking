<?php //index.php

$pomm = require __DIR__.'/../.pomm_cli_bootstrap.php';

$rooms = $pomm['booking']
    ->getModel('\Model\Booking\RoomSchema\RoomModel')
    ->findAll()
?>
<html>
    <head></head>
    <body>
        <h1>Pomm - Booking</h1>

        <p>Liste des salles : </p>
        <?php if ($rooms->isEmpty()) { ?>
            <p>Aucune salle</p>
        <?php }else{  ?>
            <ul>
                <?php
                foreach ($rooms as $room): ?>
                    <li><?php echo $room->getName(); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php } ?>
    </body>
</html>