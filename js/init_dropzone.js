// Initialisation des textes en FR
Dropzone.prototype.defaultOptions.dictRemoveFile = "❌ Supprimer";
Dropzone.prototype.defaultOptions.dictDefaultMessage = "Déposez ici vos Images (5 minimum)";
Dropzone.prototype.defaultOptions.dictFallbackMessage = "Votre nabigateur ne supporte pas le Drag & Drop";
Dropzone.prototype.defaultOptions.dictFileTooBig = "L'image est trop grosse ({{filesize}}MiB). Maximum autorisé: {{maxFilesize}}MiB.";
Dropzone.prototype.defaultOptions.dictInvalidFileType = "Vous ne pouvez pas uploader ce type de fichier";
Dropzone.prototype.defaultOptions.dictResponseError = "Réponse serveur n° {{statusCode}}.";
Dropzone.prototype.defaultOptions.dictCancelUpload = "Stopper l'upload";
Dropzone.prototype.defaultOptions.dictCancelUploadConfirmation = "Etes-vous certain de vouloir stopper l'upload ?";
Dropzone.prototype.defaultOptions.dictMaxFilesExceeded = "Limite d'image atteinte";

// Array de stockage des ID uniques des images
var file_uuid = [];

// Initialisation de la première dropzone
var drop_avant = new Dropzone(
 //id of drop zone element 1
 '#drop_avant', {
   addRemoveLinks: true,
   paramName: "file",
   maxFilesize: 128, // MB
   clickable: true,
   maxFiles: 12,
   acceptedFiles: 'image/*',
   init: function() {
     this.on("maxfilesexceeded", function(file) {
       this.removeAllFiles();
       this.addFile(file);
     });
     this.on('processing', function(file) {
       console.log(file.upload.uuid);
       // Ici on peut changer les paramètres comme on veut !
       drop_avant.options.url = "php/traitement_upload.php?position=1&id_vendeur=<?php echo $id_vendeur; ?>&id_stock=<?php echo $id_stock; ?>&dataURL=" + file.upload.uuid;
       console.log(drop_avant.options.url);
     });
     this.on("success", function(file, responseText) {
       file_uuid.push(file.upload.uuid);
     });
     this.on("removedfile", function(file) {
       x = confirm('Etes-vous certain de vouloir supprimer cette photo ?');
       if (!x) return false;
       for (var i = 0; i < file_uuid.length; ++i) {
         if (file_uuid[i] == file.upload.uuid) {

           var url = "php/delete_photo.php";
           var params = "dataURL=" + file.upload.uuid;
           var http = new XMLHttpRequest();
           http.open("GET", url + "?" + params, true);
           http.onreadystatechange = function() {
             if (http.readyState == 4 && http.status == 200) {
               //alert(http.responseText);
             }
           }
           http.send(null);
         }
       }
     });
     this.on("error", function(data, errorMessage, xhr) {
       // do something here
       console.log(data);
     });
   }
 });


 var drop_arriere = new Dropzone(
  //id of drop zone element 1
  '#drop_arriere', {
    url : "php/traitement_upload.php?position=2&id_vendeur=<?php echo $id_vendeur; ?>&id_stock=<?php echo $id_stock; ?>",
    addRemoveLinks: true,
    paramName: "file",
    maxFilesize: 128, // MB
    clickable: true,
    maxFiles: 12,
    acceptedFiles: 'image/*',
    init: function() {
      this.on("maxfilesexceeded", function(file) {
        this.removeAllFiles();
        this.addFile(file);
      });
      this.on('processing', function(file) {
        console.log(file.upload.uuid);
        // Ici on peut changer les paramètres comme on veut !
        drop_avant.options.url = "php/traitement_upload.php?position=2&id_vendeur=<?php echo $id_vendeur; ?>&id_stock=<?php echo $id_stock; ?>&dataURL=" + file.upload.uuid;
        console.log(drop_avant.options.url);
      });
      this.on("success", function(file, responseText) {
        file_uuid.push(file.upload.uuid);
      });
      this.on("removedfile", function(file) {
        x = confirm('Etes-vous certain de vouloir supprimer cette photo ?');
        if (!x) return false;
        for (var i = 0; i < file_uuid.length; ++i) {
          if (file_uuid[i] == file.upload.uuid) {

            var url = "php/delete_photo.php";
            var params = "dataURL=" + file.upload.uuid;
            var http = new XMLHttpRequest();
            http.open("GET", url + "?" + params, true);
            http.onreadystatechange = function() {
              if (http.readyState == 4 && http.status == 200) {
                //alert(http.responseText);
              }
            }
            http.send(null);
          }
        }
      });
      this.on("error", function(data, errorMessage, xhr) {
        // do something here
        console.log(data);
      });
    }
  });

// Initialisation de la 2eme
 var drop_cabine = new Dropzone(
  //id of drop zone element 1
  '#drop_cabine', {
    url : "php/traitement_upload.php?position=3&id_vendeur=<?php echo $id_vendeur; ?>&id_stock=<?php echo $id_stock; ?>",
    addRemoveLinks: true,
    paramName: "file",
    maxFilesize: 128, // MB
    clickable: true,
    maxFiles: 12,
    acceptedFiles: 'image/*',
    init: function() {
      this.on("maxfilesexceeded", function(file) {
        this.removeAllFiles();
        this.addFile(file);
      });
      this.on('processing', function(file) {
        console.log(file.upload.uuid);
        // Ici on peut changer les paramètres comme on veut !
        drop_avant.options.url = "php/traitement_upload.php?position=2&id_vendeur=<?php echo $id_vendeur; ?>&id_stock=<?php echo $id_stock; ?>&dataURL=" + file.upload.uuid;
        console.log(drop_avant.options.url);
      });
      this.on("success", function(file, responseText) {
        file_uuid.push(file.upload.uuid);
      });
      this.on("removedfile", function(file) {
        x = confirm('Etes-vous certain de vouloir supprimer cette photo ?');
        if (!x) return false;
        for (var i = 0; i < file_uuid.length; ++i) {
          if (file_uuid[i] == file.upload.uuid) {

            var url = "php/delete_photo.php";
            var params = "dataURL=" + file.upload.uuid;
            var http = new XMLHttpRequest();
            http.open("GET", url + "?" + params, true);
            http.onreadystatechange = function() {
              if (http.readyState == 4 && http.status == 200) {
                //alert(http.responseText);
              }
            }
            http.send(null);
          }
        }
      });
      this.on("error", function(data, errorMessage, xhr) {
        // do something here
        console.log(data);
      });
    }
  });

// 3 eme Dropzone
 var drop_mecanique = new Dropzone(
  //id of drop zone element 1
  '#drop_mecanique', {
    url : "php/traitement_upload.php?position=4&id_vendeur=<?php echo $id_vendeur; ?>&id_stock=<?php echo $id_stock; ?>",
    addRemoveLinks: true,
    paramName: "file",
    maxFilesize: 128, // MB
    clickable: true,
    maxFiles: 12,
    acceptedFiles: 'image/*',
    init: function() {
      this.on("maxfilesexceeded", function(file) {
        this.removeAllFiles();
        this.addFile(file);
      });
      this.on('processing', function(file) {
        console.log(file.upload.uuid);
        // Ici on peut changer les paramètres comme on veut !
        drop_avant.options.url = "php/traitement_upload.php?position=4&id_vendeur=<?php echo $id_vendeur; ?>&id_stock=<?php echo $id_stock; ?>&dataURL=" + file.upload.uuid;
        console.log(drop_avant.options.url);
      });
      this.on("success", function(file, responseText) {
        file_uuid.push(file.upload.uuid);
      });
      this.on("removedfile", function(file) {
        x = confirm('Etes-vous certain de vouloir supprimer cette photo ?');
        if (!x) return false;
        for (var i = 0; i < file_uuid.length; ++i) {
          if (file_uuid[i] == file.upload.uuid) {

            var url = "php/delete_photo.php";
            var params = "dataURL=" + file.upload.uuid;
            var http = new XMLHttpRequest();
            http.open("GET", url + "?" + params, true);
            http.onreadystatechange = function() {
              if (http.readyState == 4 && http.status == 200) {
                //alert(http.responseText);
              }
            }
            http.send(null);
          }
        }
      });
      this.on("error", function(data, errorMessage, xhr) {
        // do something here
        console.log(data);
      });
    }
  });

// 4eme
 var drop_defauts = new Dropzone(
  //id of drop zone element 1
  '#drop_defauts', {
    url : "php/traitement_upload.php?position=5&id_vendeur=<?php echo $id_vendeur; ?>&id_stock=<?php echo $id_stock; ?>",
    addRemoveLinks: true,
    paramName: "file",
    maxFilesize: 128, // MB
    clickable: true,
    maxFiles: 12,
    acceptedFiles: 'image/*',
    init: function() {
      this.on("maxfilesexceeded", function(file) {
        this.removeAllFiles();
        this.addFile(file);
      });
      this.on('processing', function(file) {
        console.log(file.upload.uuid);
        // Ici on peut changer les paramètres comme on veut !
        drop_avant.options.url = "php/traitement_upload.php?position=5&id_vendeur=<?php echo $id_vendeur; ?>&id_stock=<?php echo $id_stock; ?>&dataURL=" + file.upload.uuid;
        console.log(drop_avant.options.url);
      });
      this.on("success", function(file, responseText) {
        file_uuid.push(file.upload.uuid);
      });
      this.on("removedfile", function(file) {
        x = confirm('Etes-vous certain de vouloir supprimer cette photo ?');
        if (!x) return false;
        for (var i = 0; i < file_uuid.length; ++i) {
          if (file_uuid[i] == file.upload.uuid) {

            var url = "php/delete_photo.php";
            var params = "dataURL=" + file.upload.uuid;
            var http = new XMLHttpRequest();
            http.open("GET", url + "?" + params, true);
            http.onreadystatechange = function() {
              if (http.readyState == 4 && http.status == 200) {
                //alert(http.responseText);
              }
            }
            http.send(null);
          }
        }
      });
      this.on("error", function(data, errorMessage, xhr) {
        // do something here
        console.log(data);
      });
    }
  });


 var drop_options = new Dropzone(
  //id of drop zone element 1
  '#drop_options', {
    url : "php/traitement_upload.php?position=6&id_vendeur=<?php echo $id_vendeur; ?>&id_stock=<?php echo $id_stock; ?>",
    addRemoveLinks: true,
    paramName: "file",
    maxFilesize: 128, // MB
    clickable: true,
    maxFiles: 12,
    acceptedFiles: 'image/*',
    init: function() {
      this.on("maxfilesexceeded", function(file) {
        this.removeAllFiles();
        this.addFile(file);
      });
      this.on('processing', function(file) {
        console.log(file.upload.uuid);
        // Ici on peut changer les paramètres comme on veut !
        drop_avant.options.url = "php/traitement_upload.php?position=6&id_vendeur=<?php echo $id_vendeur; ?>&id_stock=<?php echo $id_stock; ?>&dataURL=" + file.upload.uuid;
        console.log(drop_avant.options.url);
      });
      this.on("success", function(file, responseText) {
        file_uuid.push(file.upload.uuid);
      });
      this.on("removedfile", function(file) {
        x = confirm('Etes-vous certain de vouloir supprimer cette photo ?');
        if (!x) return false;
        for (var i = 0; i < file_uuid.length; ++i) {
          if (file_uuid[i] == file.upload.uuid) {
            
            var url = "php/delete_photo.php";
            var params = "dataURL=" + file.upload.uuid;
            var http = new XMLHttpRequest();
            http.open("GET", url + "?" + params, true);
            http.onreadystatechange = function() {
              if (http.readyState == 4 && http.status == 200) {
                //alert(http.responseText);
              }
            }
            http.send(null);
          }
        }
      });
      this.on("error", function(data, errorMessage, xhr) {
        // do something here
        console.log(data);
      });
    }
  });
