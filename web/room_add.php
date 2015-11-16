<?php //room_add.php

$pomm = require __DIR__.'/../.pomm_cli_bootstrap.php';

if (isset($_POST['submit'])) {
    $room = $pomm['booking']
        ->getModel('\Model\Booking\RoomSchema\RoomModel')
        ->createAndSave([
            'name'       => $_POST['name'],
            'seats'      => (int) $_POST['seats'],
            'hour_price' => (float) $_POST['hour_price'],
            'size_m2'    => (float) $_POST['size_m2']
        ]);

    if ($room->getRoomId() > 0)
        header('Location: room_edit.php?idroom='.$room->getRoomId());
}

?>
<html>
    <head></head>
    <body>
        <h1>Pomm - Ajout salle</h1>

        <form method="post" action="room_add.php">

            <label for="idname">Name : </label>
            <input type="text" value="" id="idname" name="name">

            <label for="idseats">Nombre de place : </label>
            <input type="text" value="" id="idseats" name="seats">

            <label for="idhourprice">Prix de l'heure : </label>
            <input type="text" value="" id="idhourprice" name="hour_price">

            <label for="idsizem2">Surface(m2) : </label>
            <input type="text" value="" id="idsizem2" name="size_m2">

            <input type="submit" name="submit" />
        </form>
    </body>
</html>