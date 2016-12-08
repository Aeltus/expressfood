# Express Food

OpenClassrooms Projet n°4 du parcours développeur d'application php/symfony 

####1- Fonctionnement général :

Le projet étant assez simple, il n'a pas été jugé nécessaire de faire appel à un Framework. Cependant, pour
garder une certaine lisibilité, les fichiers ont été classés comme suit :

        - conf : contient la configuration du projet (BDD, API)
        
        - vues : contient les vues
            - assets : les fichiers css, images et js
            
        - class : les classes en 3 catégories
            - DAO : qui est l'entité qui permette d'accéder à la BDD
            - Les classes nommées Manager gèrent les entités, et préparent en conséquence les requettes pour DAO
            - Les classes portant le nom de leur type (ex : Produit ou Utilisateur) seront les entités
            - La classe ServiceProvider sert à fournir les services de base de l'application gérer les session, les routes etc...
                    
        - Dans le dossier racine, index.php fait office de controller frontal
        
        
        
Bonne lecture :)
