POMM 2 tutoriel - CRUD
======================

```findAll()``` est une des nombreuses fonctions mises a disposition à notre Model par les traits :
   - [ReadQueries](https://github.com/pomm-project/ModelManager/blob/master/sources/lib/Model/ModelTrait/ReadQueries.php)
   - [WriteQueries](https://github.com/pomm-project/ModelManager/blob/master/sources/lib/Model/ModelTrait/WriteQueries.php)

Création 
--------
Nous souhaitons enregistrer une salle, pour ce faire nous utiliserons la fonction ```createAndSave()``` mise à disposition par ReadQueries :

```php
<?php //room_add.php

$pomm = require __DIR__.'/../.pomm_cli_bootstrap.php';

if (isset($_POST['submit'])) {
    // Création et sauvegarde de l'objet Room
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
```

La fonction créé un enregistrement et retourne un objet flexible hydraté.

Edition 
-------

Une fois notre salle enregistré nous souhaitons la modifier grâce à la fonction ```updateByPk()``` : 

```php
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
```

Comme la fonction précédente celle ci nous retourne l'objet flexible hydraté.

Un array est nécessaire pour les fonctions travaillant avec les primary key (suffixé par Pk) afin de pouvoir travailler avec des clés composites.

