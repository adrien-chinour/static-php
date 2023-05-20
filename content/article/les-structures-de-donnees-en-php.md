---
title: "Les structures de données en PHP"
createdAt: "2021-01-25"
slug: "les-structures-de-donnees-en-php"
tags:
- PHP
---

Array, array ou array ? Oui c'est vrai que PHP n'est pas riche en structure de données.
Voyons ensemble un peu ce qu'il en est réellement. 😊

<div style="text-align:center">
  <img src="/build/images/les-structures-de-donnees-en-php/cover.webp" width="1000px" height="668px" alt="couverture" />
</div>

## Les **array**

La structure de données par excellence en PHP c'est _array_, on l'utilise comme liste,
table de hachage, pile, file, etc. Voyons le fonctionnement de cette structure de données _magiques_... 🧐

_Array_ est en réalité un **dictionnaire ordonné**, avec un couple clé/valeur. Par défaut, PHP défini des clés
numériques : 0, 1, 2, etc.
Pour faire le lien entre la clé et la valeur une table de hachage est créée.

Je ne vais pas rentrer dans les détails, je vous laisse
lire <a rel="noreferrer noopener" target="_blank" href="http://nikic.github.io/2014/12/22/PHPs-new-hashtable-implementation.html">
l'article</a> de Nikita Popov
sur l'évolution entre **PHP 5** et **PHP 7** de l'implémentation d'_array_.

> La documentation de Zend fournit aussi une explication très claire sur cette
> implémentation : <a rel="noreferrer noopener" target="_blank" href="https://www.zend.com/php-arrays">PHP Arrays</a>

L'intérêt est de répondre à un maximum de cas d'usage avec des performances optimales.
Mais cette implémentation peut aussi causer des performances désastreuses à cause de l'utilisation de certaines
fonctions.

Prenons le cas
de <a rel="noreferrer noopener" target="_blank" href="https://www.php.net/manual/fr/function.array-shift.php">`array_shift`</a>
qui permet d'extraire le premier élément d'un array.
Lors d'un `array_shift` la table de hachage doit être recalculée pour mettre à jour les clés de notre tableau ce qui
cause une complexité de O(n). 😱
Sur des petits tableaux l'opération n'est pas forcément couteuse mais lorsqu'on manipule des tableaux plus grands cela
peut vraiment être un problème.
Ainsi il est moins couteux de faire un `array_reverse` puis `array_pop` lorsque les index du tableau ne sont pas
importants.

```php
$stack = array("orange", "banana", "apple", "raspberry");

// bad perf
$fruit = array_shift($stack);

// better perf
$stack = array_reverse($stack);
$fruit = array_pop($stack);
```

Des cas comme ça il n'y en a pas énormément mais on peut tout de même se poser la question des alternatives,
que ce soit pour l'expérience développeur ou de la performance.

## Il est où l'objet ? Il est où ? 🎶

Un gros problème que j'ai avec les tableaux en PHP, c'est que ce ne sont pas des objets. Il faut passer par des
fonctions
qui ne sont pas toujours simples à utiliser. Même après plusieurs années, je n'arrive pas à me souvenir de l'ordre des
paramètres
ou si le tableau est passé par référence ou par valeur. 😤

Prenons l'exemple suivant qui va calculer la moyenne des notes dans un tableau associatif :

```php
$data = [
    ['name' => 'Jean', 'note' => 8],
    ['name' => 'Alice', 'note' => 12],
    ['name' => 'Marcel', 'note' => 3],
    ['name' => 'Bob', 'note' => 18],
    ['name' => 'Elodie', 'note' => null],
];

$notes = array_filter(array_column($data, 'note'), fn($item) => null !== $item);
$average = array_sum($notes) / count($notes);
```

On comprend ce que cela fait mais honnêtement la lisibilité n'est pas top, on remarque que l'imbrication des fonctions
peut vite poser problème.

Une alternative, pour les utilisateurs de Symfony, est d'utiliser les collections de Doctrine (_doctrine/collections_).

```php
$collection = (new \Doctrine\Common\Collections\ArrayCollection($data))
    ->map(fn($item) => $item['note'])
    ->filter(fn($item) => null !== $item);
$average = array_sum($collection->toArray()) / $collection->count();
```

> La documentation
> de <a rel="noreferrer noopener" target="_blank" href="https://www.doctrine-project.org/projects/doctrine-collections/en/1.6/index.html">
> Doctrine Collection</a>

On ne se simplifie pas la vie, c'est même plus complexe puisque l'on mélange la manipulation de notre _Collection_ avec
les fonctions natives PHP.

L'intérêt de cette librairie est de fournir une implémentation utile pour Doctrine dans le traitement des collections d'
entités.
Elle n'est donc pas faite pour remplacer les fonctions natives de PHP mais reste utile pour certaines manipulations :
map, filtre, etc.

Une autre alternative pour manipuler les tableaux PHP est celle de
Lavarel : <a rel="noreferrer noopener" target="_blank" href="https://laravel.com/docs/8.x/collections">
tightenco/collect</a>

```php
$average = collect($data)->avg(fn($item) => $item['note']);
```

On obtient un code lisible avec une méthode qui vient "wrapper" toute notre logique autour de notre objectif.
L'intérêt de cette librairie est de fournir aux développeurs un outil plus intuitif et évolué que les fonctions natives
de PHP.

> À noter que la fonction `avg` retire automatiquement les valeurs `null` pour le calcul.

La complexité en temps et en mémoire reste la même puisque ces librairies ne sont que des wrappers objet des fonctions
PHP.

Il y a surement d'autres librairies similaires, j'ai
trouvé <a rel="noreferrer noopener" target="_blank" href="https://github.com/voku/Arrayy">_voku/arrayy_</a> qui semble
relativement complète.

## Et les autres structures de données ?

Comme on l'a vu au début PHP semble proposer une seule structure de données (_array_) mais depuis **PHP 7** nous avons
la **SPL**...

Grâce à la SPL (Standard PHP Library) nous avons des structures de données supplémentaires présentées
dans <a rel="noreferrer noopener" target="_blank" href="https://www.php.net/manual/fr/spl.datastructures.php">la
documentation PHP</a>.

> Je vous conseille cette vidéo qui explique un peu tout ce que je vais dire dans cette partie (et en
> mieux) : <a rel="noreferrer noopener" target="_blank" href="https://www.youtube.com/watch?v=tX1jbqnjrR0">Les structures
> de données en PHP - Frédéric BOUCHERY - AFUP Day 2020 Nantes</a>

Mais le problème majeur de la SPL est que des opérations qui ne devraient pas être présente dans une structure de
données soient possible.
On se retrouve avec SplStack qui permet de faire des shift/unshift et des push/pop. 🤨

Une autre extension qui malheureusement n'est pas présente de base dans PHP est l'extension Data Structure. Elle corrige
tous les problèmes de la SPL en allant encore plus loin.
Je ne vais pas expliquer en détail les structures disponibles, je vous laisse
regarder <a rel="noreferrer noopener" target="_blank" href="https://www.php.net/manual/fr/book.ds.php">la
documentation</a>.

D'un point de vue performance il y a un intérêt sur des gros volumes de données mais comme dans les librairies orientées
objet pour la manipulation de tableau on améliore surtout l'expérience développeur.

> Un article traitant des
> performances <a rel="noreferrer noopener" target="_blank" href="https://medium.com/@rtheunissen/efficient-data-structures-for-php-7-9dda7af674cd">
> Efficient data structures for PHP 7</a>.

Pour vous aider à comprendre l'utilité voici un exemple qui reprend le problème de `array_shift`:

```php
// FIFO array style
$queue = ['a', 'b'];
$queue[] = 'c'; // on ajoute un élément
array_push($queue, 'd'); // la aussi
$item = array_shift($queue); // on enlève le premier élément, en O(n)...

// FIFO Spl style
$queue = new SplQueue();
$queue->enqueue('a'); // on ajoute un élément à la fin
$queue->push('b'); // on ajoute aussi un élément à la fin...
$queue->add(2, 'c'); // on peut aussi ajouter à un index...
$item = $queue->dequeue(); // on enlève le premier élément en O(1)

// FIFO DS style
$queue = new \Ds\Queue();
$queue->push("a"); // on ajoute un élément
$queue->push("b", "c"); // on ajoute plusieurs éléments
$queue->push(...["d", "e"]); // on ajoute plusieurs élément depuis un array
$item = $queue->pop(); // on enlève le premier élément en O(1)
```

Alors oui on peut faire les choses bien avec la Spl ou avec array mais ça reste plus sympa avec DS. 😉

L'utilisation de structure de données autre que _array_ renforce l'utilisation de PHP dans des domaines annexes au web :
pour des cron ou des tâches asynchrones par exemple. _Array_ est indispensable à PHP, c'est simple et efficace, mais
dans certains
cas **Data Structure** ou **Laravel Collection** rendent les projets bien plus sympas ! 🥳
