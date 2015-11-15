POMM 2 tutoriel - Découverte
============================

Foundation est la porte d'entrée de Pomm, il permet l'interaction avec Postgres.

```
 // composer.json
 "require": {
      "pomm-project/foundation": "2.0.0"
  },
```

Ajout de pomm-project/foundation dans le composer.json.

```
   $ php composer.phar install
```

Première Requête
----------------

Nous souhaitons récupérer la liste de nos salles

```php
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
```

Pomm retourne un iterator qui nous permet de manipuler les résultats de postgres.

Foundation nous permet d'exécuter rapidement des requêtes et est très approprié lors de la réalisation de worker ou de requêtes ne nécessitant pas modélisation objet, typiquement lors de statistiques (nous y reviendrons plus tard).

Cependant avec les langages modernes nous avons rapidement besoin de modéliser nos résultats grâce à des objets.

ModelManager nous permet cela !

Le duo ModelManager + CLI
-------------------------

ModelManager est une "surcouche" à Foundation afin de nous permettre de manipuler notre base grâce à des objets.

CLI est un composant qui étend de [symfony/console](http://symfony.com/doc/current/components/console/introduction.html)

Celui-ci nous servira à générer nos objets mais il possède également des commandes permettant d'inspecter notre base... [voir documentation cli](https://github.com/pomm-project/Cli)

Ajout de CLI dans composer :

```
$ php composer.phar require pomm-project/cli
```

CLI requiert ModelManager donc pas besoin de l'ajouter.

Afin que CLI puisse communiquer avec Postgres nous devons créer le fichier .pomm_cli_bootstrap.php a la racine de notre projet.

```php
<?php

use \PommProject\Foundation\Pomm;

$loader = require __DIR__.'/vendor/autoload.php';
$loader->add(null, __DIR__);

return new Pomm(['booking' =>
    [
        'dsn' => 'pgsql://user:pass@host:port/db_name',
        'class:session_builder' => '\PommProject\ModelManager\SessionBuilder',
    ]
]);
```

La class "session_builder" permet de définir les clients, types... que notre session ```$pomm['booking']``` va embarquer.

Précédemment nous n'avions rien déclaré et celui de Foundation était donc utilisé par défaut. Comme nous avons besoin maintenant d'utiliser le client Model alors nous déclarons le "session_builder" fournit avec ModelManager.
 
Plus tard nous personnaliserons ce "session_builder" comme il est fortement conseillé.

Génération des objets du schemas : 

```
$ php vendor/bin/pomm.php  pomm:generate:schema-all -d sources -a Model booking room
 ✓  Creating file 'sources/Model/Booking/RoomSchema/AutoStructure/Booking.php'.
 ✓  Creating file 'sources/Model/Booking/RoomSchema/BookingModel.php'.
 ✓  Creating file 'sources/Model/Booking/RoomSchema/Booking.php'.
 ✓  Creating file 'sources/Model/Booking/RoomSchema/AutoStructure/Room.php'.
 ✓  Creating file 'sources/Model/Booking/RoomSchema/RoomModel.php'.
 ✓  Creating file 'sources/Model/Booking/RoomSchema/Room.php'.
```

Les objets s'articulent sous 3 axes : 
   - Structure : contiennent les informations de structure de relations
   - Model : permettent de manipuler postgres
   - FlexibleEntity : c'est la réprésentation objet du résultat des requêtes SQL.

Important:
    Seuls les fichiers de structure seront supprimés lors de la nouvelle éxécution de la commande.
    Ceux ci ne doivent pas être versionnés. (Ex: Ajout au .gitignore **/AutoStructure/)
    
Reprenons notre fichier index.php
    
```php
<?php //index.php

$pomm = require __DIR__.'/../.pomm_cli_bootstrap.php';

$rooms = $pomm['booking']
    ->getModel('\Model\Booking\RoomSchema\RoomModel')
    ->findAll();
?>
<html>
    <head></head>
    <body>
        <h1>Pomm - Booking</h1>

        <p>Liste des chambres : </p>
        <?php if ($rooms->isEmpty()) { ?>
            <p>Aucune chambre</p>
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
```

Pour initialiser POMM, nous avons repris le .pomm_cli_bootstrap créé pour notre CLI afin de ne pas multiplier les configurations.

Décortiquons l'appel du Model :

```php
$rooms = $pomm['booking']
    ->getModel('\Model\Booking\RoomSchema\RoomModel')
    ->findAll()
```

La fonction getModel() nous permet de récupérer le model dont nous avons besoin et de le déclarer à notre session.

Les objets Model possèdent des fonctions fournit par les traits ReadQueries et WriteQueries, findAll() fait parti de celle-ci.

La totalité des fonctions sont décritent dans la [documentation de ModelManager](https://github.com/pomm-project/ModelManager/blob/master/documentation/model_manager.rst)
 
La fonction findAll() renvoit un iterator composé de FlexibleEntity rattaché au model utilisé, dans notre cas RoomModel.



