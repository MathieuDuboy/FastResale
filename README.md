# FastResale

## Modification de la table 

````
ALTER TABLE `photos` ADD `dataURL` TEXT NOT NULL AFTER `url`;
````

## Remarques
- Pensez au CHMOD 755 ou 777 sur le dossier /uploads
