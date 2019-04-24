<!DOCTYPE html>
<html>
<head>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/dropzone.css" rel="stylesheet">
	<script src="js/bootstrap.js">
	</script>
	<script src="js/dropzone.js">
	</script>
	<script type="text/javascript">
  // Indispensable !!! Permet d'obtenir plusieurs Dropzone simultanément sur une meme page !
  // A ne pas supprimer
	         Dropzone.autoDiscover = false;
	</script>
	<title></title>
</head>
<body>
	<?php
  // Initialisation Base de données
	  include("php/config.php");
	  $id_stock = $_GET['id_stock'];

  // affichage des informations du stock
	  $query  = "SELECT * FROM `stocks` WHERE id = ".$id_stock;
	  $result = mysqli_query($link, $query);
	  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	  $id_vendeur = $row['id_vendeur'];
	  ?>
	<div class="row">
		<div class="col col-2"></div>
		<div class="col col-8" style="background-color:#f1f1f1!important">
			Id du vendeur : <?php echo $id_vendeur; ?><br>
			<small class="form-text text-muted" id="InfosAide">Autres informations concernant le stock ici ...</small> <small class="form-text text-muted" id="InfosAide2">...</small> <small class="form-text text-muted" id="InfosAide3">...</small>
		</div>
		<div class="col col-2"></div>
	</div>
  <form action="valider_formulaire.php" method="POST" onsubmit="return valider()" name="MonFormulaire">
  	<div class="row">
  		<div class="col col-2"></div>
  		<div class="col col-8" style="background-color:#f1f1f1!important">
  			<div class="form-group">
  				<label for="avant">Avant</label>
  				<div class="dropzone" id="drop_avant"></div><small class="form-text text-muted" id="avantAide">Petit texte pour aider les utilisateurs et décrire ce qu'ils doivent uploader ici (Min 5 photos).</small>
  			</div>
  			<div class="form-group">
  				<label for="arriere">Arrière</label>
  				<div class="dropzone" id="drop_arriere"></div><small class="form-text text-muted" id="arriereAide">Petit texte pour aider les utilisateurs et décrire ce qu'ils doivent uploader ici (Min 5 photos).</small>
  			</div>
  			<div class="form-group">
  				<label for="cabine">Cabine</label>
  				<div class="dropzone" id="drop_cabine"></div><small class="form-text text-muted" id="cabineAide">Petit texte pour aider les utilisateurs et décrire ce qu'ils doivent uploader ici (Min 5 photos).</small>
  			</div>
  			<div class="form-group">
  				<label for="mecanique">Mécanique</label>
  				<div class="dropzone" id="drop_mecanique"></div><small class="form-text text-muted" id="mecaniqueAide">Petit texte pour aider les utilisateurs et décrire ce qu'ils doivent uploader ici (Min 5 photos).</small>
  			</div>
  			<div class="form-group">
  				<label for="defauts">Défauts</label>
  				<div class="dropzone" id="drop_defauts"></div><small class="form-text text-muted" id="defautsAide">Petit texte pour aider les utilisateurs et décrire ce qu'ils doivent uploader ici (Min 5 photos).</small>
  			</div>
  			<div class="form-group">
  				<label for="options">Options</label>
  				<div class="dropzone" id="drop_options"></div><small class="form-text text-muted" id="optionsAide">Petit texte pour aider les utilisateurs et décrire ce qu'ils doivent uploader ici (Min 5 photos).</small>
  			</div><button class="btn btn-primary" type="submit">Valider</button>
  		</div>
  		<div class="col col-2"></div>
  	</div>
  </form>
  <script>
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
     url : "php/traitement_upload.php?position=1&id_vendeur=<?php echo $id_vendeur; ?>&id_stock=<?php echo $id_stock; ?>",
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
          drop_arriere.options.url = "php/traitement_upload.php?position=2&id_vendeur=<?php echo $id_vendeur; ?>&id_stock=<?php echo $id_stock; ?>&dataURL=" + file.upload.uuid;
          console.log(drop_arriere.options.url);
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
          drop_cabine.options.url = "php/traitement_upload.php?position=3&id_vendeur=<?php echo $id_vendeur; ?>&id_stock=<?php echo $id_stock; ?>&dataURL=" + file.upload.uuid;
          console.log(drop_cabine.options.url);
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
          drop_mecanique.options.url = "php/traitement_upload.php?position=4&id_vendeur=<?php echo $id_vendeur; ?>&id_stock=<?php echo $id_stock; ?>&dataURL=" + file.upload.uuid;
          console.log(drop_mecanique.options.url);
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
          drop_defauts.options.url = "php/traitement_upload.php?position=5&id_vendeur=<?php echo $id_vendeur; ?>&id_stock=<?php echo $id_stock; ?>&dataURL=" + file.upload.uuid;
          console.log(drop_defauts.options.url);
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
          drop_options.options.url = "php/traitement_upload.php?position=6&id_vendeur=<?php echo $id_vendeur; ?>&id_stock=<?php echo $id_stock; ?>&dataURL=" + file.upload.uuid;
          console.log(drop_options.options.url);
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

    // Verifications avant soumission du formulaire
    // Verifier le nombre de fichiers dans chacque bloc dropzone
    function valider(){
      var count_drop_avant = drop_avant.files.length;
      var count_drop_arriere = drop_arriere.files.length;
      var count_drop_cabine = drop_cabine.files.length;
      var count_drop_mecanique = drop_mecanique.files.length;
      if(count_drop_avant < 5) {
        alert('Veuillez uploader au minimum 5 photos avant de votre véhicule !');
        return false;
      }
      if(count_drop_arriere < 5) {
        alert('Veuillez uploader au minimum 5 photos arrière de votre véhicule !');
        return false;
      }
      if(count_drop_cabine < 5) {
        alert('Veuillez uploader au minimum 5 cabine avant de votre véhicule !');
        return false;
      }
      if(count_drop_mecanique < 5) {
        alert('Veuillez uploader au minimum 5 mécaniques avant de votre véhicule !');
        return false;
      }
      return true;
    }
  </script>

</body>
</html>
