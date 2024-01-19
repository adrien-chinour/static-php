---
title: "Utiliser des alias d'email"
createdAt: "2020-11-15"
slug: "gestionnaire-alias-email"
tags:
- Projet
- Vie numérique
- Symfony
- PHP
---

Depuis quelques mois déjà je ne donne plus mon adresse email personnel lorsque je créer un compte sur un site mais un
alias unique à chaque service.
Et je vais vous expliquer pourquoi vous devriez *peut être* aussi le faire.

<div style="text-align:center">
    <img src="/images/gestionnaire-alias-email/cover.webp"  width="512px" height="256px" alt="Pourquoi ?!"/>
</div>

### 1. Pour éviter les SPAM

Un alias ça se supprime alors qu'une adresse email, on n'a pas forcément envie de la supprimer tous les quatre matins.
Alors oui, la plupart des services permettent de se désinscrire des emails, mais si un jour une base de données
contenant votre email est volée, vous avez de fortes chances de recevoir de nombreux spams.

Mais aussi pour des emails publicitaires qui nous parviennent sans savoir pourquoi ça sera beaucoup plus facile d'en
connaître la source.
Exemple : si je me créais un compte sur EBay avec l'alias suivant `ebay@exemple.com` qui sera redirigé sur ma boîte
personnelle `email@exemple.com`.
Maintenant si demain, je reçois un email avec des publicités pour du café avec l'adresse de
destination `ebay@exemple.com`, je saurai directement qui blâmer.

### 2. Pour la sécurité

Le fait d'avoir un email par service évite aussi, lorsqu'une base de données utilisateurs est dérobée, que le couple
email et mot de passe soit testé sur d'autres sites dans le cas ou vous avez des mots de passe identiques.

Ce qui est aussi possible, c'est d’anonymiser vos alias avec un générateur d'alias aléatoire.
En utilisant par exemple un gestionnaire de mot de passe et d'alias, vous pouvez avoir un compte sur Facebook par
exemple avec des identifiants totalement impossible à deviner.
Ce cas n'est pas forcément pertinent sur tous les services, mais cela peut-être un plus parfois.

### 3. Pour organiser vos comptes en ligne

Avant d'avoir mes alias, j'utilisais 3 adresses emails : une pour les "spams", une professionnelle et une personnelle.
Mais ça vous demande d'avoir trois comptes différents alors qu'en possédant des alias vous avez les trois en une boite
mail.
En plus de cela vous pouvez tout à fait avoir plusieurs comptes sur un site avec la même adresse email en utilisant
plusieurs alias.

De plus, vous pouvez rajouter des règles de gestion, si votre fournisseur le permet, pour lier une adresse à un dossier
en particulier.
Par exemple en redirigeant l'adresse `pub@exemple.com` vers le dossier `Spam`.

## Comment s'organiser ?

La première fois que j'ai parlé de mon service, on m'a dit :
*"Super ! Du coup maintenant en plus de ne pas me souvenir de mon mot de passe, j'oublierai aussi mon email !"*.
Et oui, c'est pas faux... Mais avec un minimum d'organisation et de logique, c'est plutôt simple : `twitter@exemple.com`
pour Twitter, `facebook@exemple.com` pour Facebook, etc.
Cet exemple part du principe que vous avez un domaine personnel qui n'est pas partagé, ce qui est pas le cas de tout le
monde.
Mais vous pouvez avoir `̀twitter.prenom.nom@exemple.com` par exemple, il faut adapter ça à votre cas personnel.

## Quelles sont les services qui me permettent de faire ça ?

Le gros problème avec la création d'alias, c'est que ça dépend de votre fournisseur. Du coup, il n'y a pas de solution
unique et universelle.
Pour ma part, j'ai créé mon propre service, je vais le présenter juste après.

Juste avant voici une liste de certains autres projets similaires qui peuvent être utilisés :

- Un gestionnaire d'alias pour Gandi : <a target="_blank" href="https://sylvain.dev/article/email-alias-manager/">
  Gestionnaire d'alias d'emails</a>
- Et puis, après je ne sais pas, je n'ai pas vraiment trouvé, mis à part que chaque fournisseur dispose d'un système
  pour faire ça, mais pas toujours rapide et simple à utiliser.

Sinon, vous pouvez créer des emails simplement de cette manière : `email+alias@exemple.com` .
Une adresse `email@exemple.com` dispose déjà d'une infinité d'alias en rajoutant un `+quelquechose`.
L’avantage est limité puisque certains sites bloque l'utilisation d'alias à l'inscription et il est impossible de les
supprimer et facile de connaître l'adresse réelle.

### Ellias - Manage your inbox

Comme je le disais, j'ai réalisé une application web en PHP sur le framework Symfony pour gérer mes alias.
Les sources sont disponibles sur
GitHub : <a rel="noreferrer noopener" href="https://github.com/adrien-chinour/ellias" target="_blank">Ellias</a>

Le projet est relativement simple et dispose d'un système extensible permettant de rajouter simplement son propre
fournisseur d’email.
Pour le moment, j'ai 2 fournisseurs : Gandi et Ovh et un faux fournisseur pour les tests.

J'utilise ça maintenant au quotidien depuis plusieurs mois et je trouve ça relativement pratique.
En plus de ça, j'utilise KeePass pour gérer mes mots de passes et le combo marche très bien pour organiser mes comptes
en lignes.

Les prochaines étapes sont :

- la réalisation d'**une application mobile**, en cours de
  développement : <a href="https://github.com/adrien-chinour/ellias-mobile-app" target="_blank">ellias-mobile-app</a>.
- **une extension pour navigateur** pour facilement générer un alias lors de l'inscription sur un site.

Je ferai sûrement un article sur le développement de l'application mobile une fois que j'aurai terminé pour présenter le
développement
de bout en bout d'une application Ionic 5 avec Angular et Capacitor pour iOS et Android.
