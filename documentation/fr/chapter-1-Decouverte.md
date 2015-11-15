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