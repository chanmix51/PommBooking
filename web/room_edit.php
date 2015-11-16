<?php //room_edit.php

$pomm = require __DIR__.'/../.pomm_cli_bootstrap.php';

if (!isset($_GET['idroom']) && !isset($_POST['room_id']))
    header('Location: room_add.php');

if (isset($_POST['room_id'])) {
    $room = $pomm['booking']
        ->getModel('\Model\Booking\RoomSchema\RoomModel')
        ->updateByPk(
            ['room_id' => (int) $_POST['room_id']],
            [
                'name'       => $_POST['name'],
                'seats'      => (int) $_POST['seats'],
                'hour_price' => (float) $_POST['hour_price'],
                'size_m2'    => (float) $_POST['size_m2']
            ]
        );
}else{
    $room = $pomm['booking']
        ->getModel('\Model\Booking\RoomSchema\RoomModel')
        ->findByPK(
            ['room_id' => (int) $_GET['idroom']]
        );
}

if ($room === null)
    header('Location: room_add.php');

?>
<html>
    <head></head>
    <body>
        <h1>Pomm - Edition salle</h1>

        <form method="post" action="room_edit.php">
            <input type="hidden" name="room_id" value="<?php echo $room->getRoomId(); ?>"/>

            <label for="idname">Name : </label>
            <input type="text" value="<?php echo $room->getName(); ?>" id="idname" name="name">

            <label for="idseats">Nombre de place : </label>
            <input type="text" value="<?php echo $room->getSeats(); ?>" id="idseats" name="seats">

            <label for="idhourprice">Prix de l'heure : </label>
            <input type="text" value="<?php echo $room->getHourPrice(); ?>" id="idhourprice" name="hour_price">

            <label for="idsizem2">Surface(m2) : </label>
            <input type="text" value="<?php echo $room->getSizeM2(); ?>" id="idsizem2" name="size_m2">

            <input type="submit" name="submit" />
        </form>
    </body>
</html>