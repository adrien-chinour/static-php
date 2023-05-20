---
title: "Migration vers PHP 8"
createdAt: "2020-12-20"
slug: "migration-php8"
tags:
- PHP
- Symfony
---

PHP 8 est sorti depuis maintenant quelques jours, j'avais suivi les changements et je suis content de pouvoir utiliser
pour la première fois cette nouvelle version. <a rel="noreferrer noopener" target="_blank" href="https://www.php.net/releases/8.0/en.php">PHP 8 Released !</a>

<div style="text-align:center">
    <img src="/build/images/migration-php8/cover.webp" width="1200px" height="800px" alt="Peluche PHP"/>
</div>

Pour tester cette version j'ai repris un projet que j'avais présenté précédemment : <a rel="noreferrer noopener" target="_blank" href="https://github.com/adrien-chinour/netflix-data">Netflix data</a>.
L'objectif du projet est d'extraire des statistiques personnelles des données Netflix.

Tout d'abord pour passer en PHP 8 j'ai changé le `Dockerfile` :
```git
- FROM php:7.4-cli
+ FROM php:8.0-cli
```

Après un rebuild du projet j'ai pu mettre à jour mon `composer.json` :
```git
-    "php": "^7.4",
-    "symfony/serializer": "^5.1",
-    "symfony/console": "^5.1",
-    "symfony/property-access": "^5.1",
-    "symfony/yaml": "^5.1",
+    "php": "^8.0",
+    "symfony/serializer": "^5.2",
+    "symfony/console": "^5.2",
+    "symfony/property-access": "^5.2",
```

On remarquera la suppression de `symfony/yaml` un paquet que j'utilisais pour lire les métadonnées utiles
au mapping lors de la dénormalisation de mes entités depuis les fichiers CSV.

Depuis PHP 8 nous avons des attributs pour gérer les métadonnées : <a rel="noreferrer noopener" target="_blank" href="https://www.php.net/releases/8.0/en.php#attributes">Attributes</a>.
Et grâce au travail qui a été fait sur les dernières versions de Symfony nous pouvons donc changer notre fichier de métadonnées YAML :

```yaml
App\Model\ViewingTime:
    attributes:
        profileName: "Profile Name"
        startTime: "Start Time"
        duration: "Duration"
        title: "Title"
```

Pour fournir ces informations directement dans notre entité :

```php
class ViewingActivity extends Model
{
    #[SerializedName("Profile Name")]
    public string $profileName;

    #[SerializedName("Start Time")]
    public string $startTime;

    #[SerializedName("Duration")]
    public string $duration;

    #[SerializedName("Title")]
    public string $title;

    //...
}
```

Il s'agit d'un remplaçant direct aux annotations PHP que l'on pouvait utiliser dans les anciennes versions de PHP mais
qui n'était pas un fonctionnement prévu par PHP. En effet il est possible maintenant d'utiliser les classes de réflexion
pour lire ces métadonnées sans utiliser une dépendance tierce.

Voyons d'ailleurs comment utiliser en modifiant la manière de récupérer le fichier associé à une entité.
Dans la version précédente, par simplicité,
j'avais une variable statique qui contenait directement le chemin vers le fichier CSV associé à l'entité :

```php
class ViewingActivity extends Model
{
    static string $file = "Content_Interaction/ViewingActivity.csv";

    //...
}
```

Dans cette version PHP 8, j'ai utilisé un attribut sur la classe :

```php
#[FileModel(filename: "Content_Interaction/ViewingActivity.csv")]
class ViewingActivity extends Model
{
    //...
}
```

Pour fonctionner nous avons besoin de déclarer une classe marquée comme `Attribute`, ici `FileModel` avec les propriétés que l'on a besoin.

```php
#[Attribute]
class FileModel
{
    public function __construct(public string $filename) {}
}
```

> On peut noter l'utilisation du système de promotion de propriété : <a rel="noreferrer noopener" target="_blank" href="https://www.php.net/releases/8.0/en.php#constructor-property-promotion">Constructor property promotion</a>

Enfin, on peut récupérer les informations de cet attribut va notre classe de réflexion :

```php
class Model
{
    public static function load(): array
    {
        $attributes = (new \ReflectionClass(static::class))->getAttributes(FileModel::class);

        if (empty($attributes)) {
            throw new \LogicException(sprintf("You must add a '%s' attribute on class '%s'", FileModel::class, static::class));
        }

        /** @var FileModel $fileModel */
        $fileModel = $attributes[0]?->newInstance();

        //...
    }
}
```

> Là encore une fonctionnalité utile avec le <a rel="noreferrer noopener" target="_blank" href="https://www.php.net/releases/8.0/en.php#nullsafe-operator">Nullsafe operator</a> : `?->newInstance()`

Nous avons donc `getAttributes` qui permet de récupérer les attributs d'une classe (on peut préciser le type que l'on cherche)
et la méthode newInstance pour récupérer une instance de notre classe d'attributs.

Il y a encore tout un tas d'évolution bien pratique qui rend l'expérience développeur plus agréable et j'attends avec impatience les prochaines versions de PHP8.

> Les sources du projet sont disponibles sur GitHub : <a rel="noreferrer noopener" target="_blank" href="https://github.com/adrien-chinour/netflix-data">github.com/adrien-chinour/netflix-data</a>.
