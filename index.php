<?php

// retrieve images
// $dir = "img/$dirname/vr";
$logementID = 1234;
$dir = "images/$logementID/vr";
$ImagesArray = [];
$file_display = [ 'JPG' ];

if (file_exists($dir) == false) {
    echo ["Directory \'', $dir, '\' not found!"];
}
else {
    $dir_contents = scandir($dir);
    foreach ($dir_contents as $file) {
        $file_type = pathinfo($file, PATHINFO_EXTENSION);
        $file_link = $dir."/".pathinfo($file, PATHINFO_BASENAME);
        if (in_array($file_type, $file_display) == true) {
            $ImagesArray[] = $file_link;
        }
    }
    
}
?>
<!DOCTYPE html>
<html>
    <head>
	<meta charset="latin1" />
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet"/>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script charset="UTF-8" src="js/jquery-2.1.0.min.js"></script>
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
	<!-- <script src="https://aframe.io/releases/0.7.0/aframe.min.js"></script> -->
	<script src="js/aframe.min.js"></script>
	<script src="js/something.js"></script>

	<link rel="stylesheet" href="css/vr-style.css"/>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>

	<title> &agrave; Compiegne - ALESC</title>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	
    </head>
    <body>
	<div class="navbar navbar-default"  id="autocollapse" ng-controller="navBar">
	    <div class="container-fluid">
		<div class="navbar-header">
        <a href="index.php"
          style="margin:0; padding:0"
          class="navbar-brand">
        <img src="images/logo.png" 
          style="padding-right:30px;height:79px;" 
          alt="Logo de l'ALESC, l'Association pour le Logement Etudiant &agrave; Compi&eacute;gne"></a>
        <a 
          href="index.php" 
          ng-class="locAsClass('index')" 
          class="navbar-brand" style="font-weight:bold;">
          ACCUEIL
        </a>
        <button 
          type="button" 
          data-toggle="collapse" 
          data-target="#MainMenuCollapse" 
          class="navbar-toggle">

          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>

        </button>
        <button type="button"
        class="btn btn-default btn-primary navbar-btn searchToggleButton navbar-toggle"
        onclick="$('#heightWrapper').toggleClass('mobileShow');"
        ng-class="locAsClass('carte')+' '+locAsClass('liste')">
          Filter <i class="fa fa-filter"></i>
        </button>
      </div>
      <div id="MainMenuCollapse" class="navbar-collapse collapse">
    
	      <ul class="nav navbar-nav">   
	   	 <li><a href="liste.php" ng-class="locAsClass('liste')" >Logements priv&eacute;s<br/>disponibles</a></li>
       <li><a href="carte.php" ng-class="locAsClass('carte')" >Carte interactive <br/>des logements priv&eacute;s</a></li>
    	 <li><a href="residences.php" ng-class="locAsClass('residence')" >Notre parc de <br/>r&eacute;sidences</a></li>
       	  
       <li><a href="fonctionnement.php" ng-class="locAsClass('inscription_logeur')" >Fonctionnement</a></li>
	     <li><a href="http://pia.test.utc.fr/index.php/login" ng-class="locAsClass('inscription_logeur')" >Publier et g&eacute;rer <br/>une annonce</a></li>
	   
       <li><a href="faq.php" ng-class="locAsClass('faq')">FAQ</a></li>
	     <li><a href="contact.php" ng-class="locAsClass('contact')">Contact</a></li>	   
	
	</ul>
        <ul class="nav navbar-nav navbar-right"  ng-class="locAsClass('connexion_')" >
       <ul class="nav navbar-nav navbar-right"  ng-class="locAsClass('connexion_')" >
                      
                          
                

                  	       
        </ul>
      </div>
    </div>
  </div>

<h1 class="col-md-10 col-md-offset-1">
   &agrave; Compiegne</h1>

<div class="col-md-7 col-md-offset-1 images" style="background-color:#EEE;">
  
  <div id="container">
    <a-scene id="mainScene" do-something-once-loaded=""  embedded>


       <?php
	 $linksList = $ImagesArray;
	 echo $ImagesArray;
	 if (isset($linksList)) {
	 foreach ($linksList as $key => $link) {
       echo "<img id=\"r$key\" src=\"$link \" >";
       }
       }
       ?>
      <!-- <a-assets> -->
      <!-- 	<img id="r0" src="/init/img/1234/vr/r0.JPG"> -->
      <!-- 	<img id="r1" src="/init/img/1234/vr/r1.JPG"> -->
      <!-- 	<img id="r2" src="/init/img/1234/vr/r2.JPG"> -->
      <!-- 	<img id="r3" src="/init/img/1234/vr/r3.JPG"> -->
      <!-- 	<img id="r4" src="/init/img/1234/vr/r4.JPG"> -->
      <!-- 	<img id="r5" src="/init/img/1234/vr/r5.JPG"> -->
      <!-- 	<img id="r6" src="/init/img/1234/vr/r6.JPG"> -->
      <!-- </a-assets> -->
      
      <a-sky src="#r0" radius="2000" > </a-sky>
      
      <a-entity id="camera" camera="userHeight: 0" look-controls>
	<a-entity id="cursor" cursor="fuse:true;fuseTimeout: 1000"
		  position="0 0 -1"
		  geometry="primitive: sphere; radius: 0.01"
		  material="color: green; shader: flat"
		  >
	  <a-animation begin="mouseenter" attribute="material.color" repeat="indefinite" direction="alternate" fill="both" dur="250" from="green" to="red" end="mouseleave"></a-animation>
	  <a-animation begin="mouseleave" attribute="material.color" repeat="1" dur="10" from="green" to="green"></a-animation>
	</a-entity>
	<a-animation id="camAnim" attribute="rotation" begin="showcase" end="endShowcase" repeat="indefinite" dur="150000" to="0 360 0"  easing="linear"></a-animation>
      </a-entity>
      
    </a-scene>
  </div>
  <div style="text-align:center;">
    <a href="http://www.utc.fr/alesc/images/logements/21/grand_format/chambre 2.jpg" onclick="return setPict(0);">
      <img style="height:70px;" src="http://www.utc.fr/alesc/images/logements/21/grand_format/chambre 2.jpg">
    </a>
    <a href="http://www.utc.fr/alesc/images/logements/21/grand_format/cuisine - 1.jpg" onclick="return setPict(1);">
      <img style="height:70px;" src="http://www.utc.fr/alesc/images/logements/21/grand_format/cuisine - 1.jpg">
    </a>
    <a href="http://www.utc.fr/alesc/images/logements/21/grand_format/cuisine.jpg" onclick="return setPict(2);">
      <img style="height:70px;" src="http://www.utc.fr/alesc/images/logements/21/grand_format/cuisine.jpg">
    </a>    
    
  </div>
</div>
<div class="col-md-3">
    <h3 style="margin-top:0; padding-top:0;">Coordonn&eacute;es du Logeur</h3>
    <p>
   

        </p>
    <h3>Adresse exacte du logement</h3>
    
        <p>
      L'acc&egrave;s aux coordonn&eacute;es des logeurs est r&eacute;serv&eacute; aux adh&eacute;rents de l'ALESC.  
    </p>
    
       <a class="btn btn-primary btn-block" href="connexion_etu.php">Obtenir l'adresse pr&eacute;cise et <br/>le t&eacute;l&eacute;phone du propri&eacute;taire</a>
      </div>

<div class="container">
<div class="col-md-3 col-md-offset-1" >
  <h3>D&eacute;tail du logement</h3>
    <table class="table">
        <tbody>
                           <tr>
                <th>
                  R&eacute;ference                </th>
                <td>
                    21                </td>
              </tr>
                           <tr>
                <th>
                  Type                </th>
                <td>
                    Chambre                </td>
              </tr>
                           <tr>
                <th>
                  Superficie                </th>
                <td>
                    12 m&sup2;                </td>
              </tr>
                           <tr>
                <th>
                  Label attribu&eacute; par l'ALESC                </th>
                <td>
                    Non encore labellis&eacute;                </td>
              </tr>
                           <tr>
                <th>
                  Date de disponibilit&eacute;                </th>
                <td>
                    01/07/2017                </td>
              </tr>
                           <tr>
                <th>
                  Loyer mensuel                </th>
                <td>
                    220.00 &euro;                </td>
              </tr>
                           <tr>
                <th>
                  Charges mensuel                </th>
                <td>
                    70.00 &euro;                </td>
              </tr>
                           <tr>
                <th>
                  Meubl&eacute;                </th>
                <td>
                    oui                </td>
              </tr>
                           <tr>
                <th>
                  Ville                </th>
                <td>
                    Compiegne                </td>
              </tr>
                           <tr>
                <th>
                  Sanitaires                </th>
                <td>
                    Salle d'eau                </td>
              </tr>
                           <tr>
                <th>
                  Cuisine                </th>
                <td>
                    Cuisine commune                </td>
              </tr>
                                </tbody>
    </table>
</div>

<div class="col-md-4  commentaire">
  <h3>Description du logement</h3>
          3 Chambres pour étudiants dans un bâtiment annexe de la maison du logeur. 1 cuisine,  1 salle de bain et 1 séjour communs aux 3 étudiants. Les charges sont calculées en fonction de la consommation électrique et d'eau sur compteur visible. abris pour velo</div>  
</div>

 </body>
</html>

