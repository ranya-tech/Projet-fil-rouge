# **Cahier de charge: Application E-Commerce pour un Magasin de Téléphones et Accessoires.**
----------------------------------------------------------

### 1_Contexte du Projet:
Le marché des smartphones, tablettes et accessoires mobiles est en constante évolution, exigeant une forte réactivité commerciale. De nombreux points de vente physiques de téléphonie rencontrent des difficultés majeures dans la gestion quotidienne de leurs activités commerciales et logistiques.

Le manque de centralisation des informations et l’utilisation de processus manuels ou d'outils génériques non connectés (comme des fichiers Excel isolés) compliquent considérablement le suivi des stocks et le traitement des commandes. Par ailleurs, l’absence d’une vitrine numérique performante limite la visibilité du magasin aux seuls clients de proximité et freine son expansion. Ces lacunes nuisent non seulement à la productivité de l'équipe commerciale, mais impactent également l’expérience d'achat globale du client.

----------------------------------------------------------

**2_Objectifs du projet:** 
L’objectif principal de ce projet est de développer une application web e-commerce centralisée, intuitive et sécurisée, visant à :
*Optimiser la gestion commerciale* en automatisant le tunnel d'achat et le traitement des commandes.

*Faciliter la gestion des stocks* grâce à un suivi en temps réel et des alertes automatisées pour éviter les ruptures de flux.

*Assurer une expérience utilisateur fluide* et moderne sur tous les types d'écrans (Desktop et Mobile) pour maximiser les taux de conversion.

*Offrir une plateforme d'administration robuste* permettant de piloter l'activité commerciale à l'aide d'indicateurs de performance précis.

----------------------------------------------------------

### 3_Fonctionnalités Principales:

##### 1.Espace Client: 
**.Page d'accueil :** 
Mise en avant des nouveautés et des produits phares via un slider interactif (ex. : derniers smartphones haut de gamme).

Sections dédiées aux promotions, ventes flash et suggestions d'accessoires.

**.Catalogue de produits :** 
Classification claire et intuitive des produits par marque (Samsung, Apple, Xiaomi, etc.) ou par système d'exploitation (Android, iOS).

Système de filtrage et de tri (nouveautés, popularité).

**.Détails du produit :** 
Images haute définition du produit et leur prix.

Fiche technique complète (processeur, mémoire RAM, stockage, capacité de batterie, appareil photo).

Indicateur de l'état du produit et sélection des variantes (couleurs disponibles, capacité de stockage).

**.Panier d'achat :** 
Ajout rapide de smartphones ou accessoires depuis le catalogue ou la fiche produit.

Modification des quantités en temps réel et calcul automatique du montant total.

**.Système de commande :** 
Formulaire d'achat simplifié permettant au client de renseigner ses informations de livraison : nom complet, numéro de téléphone valide et adresse exacte de livraison.

##### 2.Espace admin: 
**.Gestion des produits :** 
Interface permettant d'ajouter un nouveau téléphone ou accessoire, de modifier les caractéristiques et les prix, ou de désactiver/supprimer un produit du catalogue.

**.Gestion du stock :** 
Suivi automatique des unités disponibles à chaque commande validée.

Système d'alerte visuelle sur le tableau de bord en cas de stock faible (ex. : alerte dès qu'il ne reste que 2 unités d'un modèle spécifique comme l'iPhone 15).

**.Gestion des commandes :** 
Accès à la section centralisée "Consulter les demandes" pour visualiser l'historique complet et les nouvelles commandes arrivantes.

Mise à jour des statuts de livraison via un menu déroulant : En attente, Expédiée, Livrée.

**.Statistiques :** 
Tableau de bord présentant le suivi des ventes (chiffre d'affaires par jour, par mois).

Analyses graphiques identifiant les marques et les modèles les plus demandés afin d'adapter la stratégie d'approvisionnement.

----------------------------------------------------------

### 4_Les Acteurs:
**Client (Visiteur/Acheteur) :**
Parcourt le catalogue, consulte les fiches techniques, compose son panier et valide sa commande via le formulaire dédié.

**Administrateur (Gérant du magasin) :**
Supervise l'intégralité du système.
Contrôle le catalogue, ajuste les prix, gère le niveau des stocks, traite les commandes des clients et analyse les rapports de vente.

----------------------------------------------------------

### 5_Charte Graphique:

**5.1 Logo** 
Le logo a été conçu pour refléter les valeurs essentielles de notre application e-commerce de téléphones et accessoires. Il représente :
----
![Logo SmartPhone](Logo.png)


Une icône de smartphone stylisée : Représentée par des contours épurés avec un bouton principal, elle définit immédiatement le secteur d'activité de l'application (la téléphonie et le matériel mobile).

Une ligne d’onde ECG (pulsation) : Située au cœur de l'écran du téléphone, elle symbolise la réactivité, le dynamisme du marché technologique, mais aussi la vitalité et la connexion constante.

La typographie « SmartPhone » : Écrite avec une police moderne et sans empattement, elle marque une séparation visuelle claire :

Smart : En rouge, pour évoquer l'énergie, l'innovation et l'intelligence technologique.

Phone : En blanc/clair, pour apporter de la clarté, de la lisibilité et de la simplicité.

Les couleurs utilisées renforcent cette symbolique :

Le noir (#000000) et le fond sombre : Expriment le haut de gamme, le professionnalisme, l’élégance et la modernité. Il rappelle le design des écrans OLED et des appareils technologiques premium.

Le rouge (#BA1A1A) : Apporte de l’énergie, de la passion et de la créativité. Dans le contexte e-commerce, il attire l'attention, stimule l'action d'achat (les boutons d'action, les promotions) et souligne l’aspect dynamique de la gestion des stocks et des ventes.

Le blanc (#FCF8FA) : Offre un contraste parfait, symbolisant la clarté de l'interface, la transparence des transactions et la simplicité du parcours client (tunnel d'achat épuré).

Ce logo incarne notre engagement : fournir une solution e-commerce complète, moderne et performante qui facilite la gestion commerciale et logistique pour le gérant, tout en offrant une expérience d'achat fluide, intuitive et centrée sur l'utilisateur.

**5.2 Typographie**
	Police principale : inter (Regular, Medium, Bold selon les besoins).

**5.3	Palette de Couleurs**
    Primaire: #0000(noire).
    Secondaire: :  #BA1A1A (rouge),   #0051D5 (blue). 
	Background: #FCF8FA (blanc).
    
----------------------------------------------------------
### Contraintes Techniques:
**Backend**: PHP.
**Frontend** : HTML5, CSS3, JavaScript.
**Base de Données** : MySQL.  
**Outils Annexes** : Figma , Git / GitHub, API.