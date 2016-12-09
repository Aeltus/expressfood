# Express Food

OpenClassrooms Projet n°4 du parcours développeur d'application php/symfony 

####1- Fonctionnement général :

Le projet étant assez simple, il n'a pas été jugé nécessaire de faire appel à un Framework. Cependant, pour
garder une certaine lisibilité, les fichiers ont été classés comme suit :

        - conf : contient la configuration du projet (BDD, API)
        
        - vues : contient les vues (ces sont plutôt des controller/vues)
            - assets : les fichiers css, images et js
            
        - class : les classes en 3 catégories
            - DAO : qui est l'entité qui permet d'accéder à la BDD
            - Les classes nommées Manager gèrent les entités, et prépare les requettes pour DAO
            - Les classes portant le nom de leur type (ex : Produit ou Utilisateur) seront les entités
            - La classe ServiceProvider sert juste à fournir les services de base de l'application gérer les session, les routes etc...
                    
        - Dans le dossier racine, index.php fait office de controller frontal
        
        
        
####2- Informations sur le fonctionnement :

Les fonctions mail() présentes dans le code, sont commentées, mais fonctionnelles. Elles ont été commentés, car par défaut, Wamp server (serveur de développement que j'ai utilisé pour développer cette maquette en local), désactive cette fonction.
Si on enlève les commentaires, et que la fonction n'est as activée en local, une exception sera levée.

Bonne lecture :)
