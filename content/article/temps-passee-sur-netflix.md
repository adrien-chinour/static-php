---
title: "Votre temps passé sur Netflix ?"
createdAt: "2020-11-14"
slug: "temps-passee-sur-netflix"
tags:
- Projet
- Symfony
- PHP
---

_Combien de temps vous avez passé sur Netflix ? Vous pouvez le savoir simplement depuis que Netflix permet d'exporter
ses données._

<div style="text-align:center">
    <img src="/images/temps-passee-sur-netflix/cover.webp" width="750px" height="500px" alt="En détente devant Netflix"/>
</div>

Pour avoir ma réponse plutôt que de simplement prendre les données au format CSV et calculer ça moi-même,
j'ai développé un programme en PHP pour me donner les informations que je voulais connaître.

Pour faire ça j'ai utilisé deux composants Symfony :

- **symfony/console** : pour créer des applications CLI en PHP.
- **symfony/serializer** : pour désérialiser les données CSV de l'export Netflix en objet PHP.

Vous pouvez utiliser et adapter mon programme disponible sur
GitHub : <a rel="noreferrer noopener" href="https://github.com/adrien-chinour/netflix-data" target="_blank">
netflix-data</a>

La commande que j'ai développée est `time` et elle permet de connaître le temps passé sur Netflix par profil ainsi que
le temps passé par programme.

> Pour ma part, j'ai passé plus de 65 jours sur Netflix et le programme que j'ai le plus regardé est **Naruto Shippuden
** avec plus de 3 jours de visionnage...

Sinon si vous souhaitez simplement exporter vos données il suffit d'en faire la
demande <a rel="noreferrer noopener" href="https://www.netflix.com/account/getmyinfo" target="_blank">ici</a>.
Les données sont alors disponibles sous quelques heures et un PDF détail les données présentent dans l'export.

J'avais réalisé un programme similaire avec les données de Facebook
Messenger : <a rel="noreferrer noopener" href="https://github.com/adrien-chinour/statistiques-messenger" target="_blank">
statistiques-messenger</a>.
