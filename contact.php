<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Nous contacter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	
<!-- Bootstrap style --> 
    <link id="callCss" rel="stylesheet" href="themes/bootshop/bootstrap.min.css" media="screen"/>
    <link href="themes/css/base.css" rel="stylesheet" media="screen"/>
<!-- Bootstrap style responsive -->	
	<link href="themes/css/bootstrap-responsive.min.css" rel="stylesheet"/>
	<link href="themes/css/font-awesome.css" rel="stylesheet" type="text/css">
<!-- Google-code-prettify -->	
	<link href="themes/js/google-code-prettify/prettify.css" rel="stylesheet"/>
<!-- fav and touch icons -->
    <link rel="shortcut icon" href="themes/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="themes/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="themes/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="themes/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="themes/images/ico/apple-touch-icon-57-precomposed.png">
	<style type="text/css" id="enject"></style>
  </head>
<body>
<div id="header">
<div class="container">
<div id="welcomeLine" class="row">
	
</div>
<!-- Navbar ================================================== -->
<div id="logoArea" class="navbar">
<a id="smallScreen" data-target="#topMenu" data-toggle="collapse" class="btn btn-navbar">
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</a>
  <div class="navbar-inner">
    <a class="brand" href="index.php"><img src="themes/images/logo.png" alt="Bootsshop"/></a>
		
    <ul id="topMenu" class="nav pull-right">
	 <li class=""><a href="themes/loi/leganetContrat.pdf">Mention Legale</a></li>
	 <li class="">
		<a href="#login" role="button" data-toggle="modal" style="padding-right:0"><span class="btn btn-medium btn-info">Connexion</span></a>
		<!-- Bloc de connexion -->
	<div id="login" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h3>Connexion</h3>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal loginFrm" method="POST" action="index.php">
			  <div class="control-group">								
				<input type="email" id="inputEmail" name="email" placeholder="Email" required>
			  </div>
			  <div class="control-group">
				<input type="password" id="inputPassword" name="password" placeholder="Password" required>
			  </div>
			  <div class="control-group">
				<label class="checkbox">
				<input type="checkbox"> Se souvenir de moi
				</label>
			  </div>
			  <div class="control-group">
			  	<input type="submit" name="connexion" class="btn btn-medium btn-info" value="Se Connecter"> 
			  	<button class="btn" data-dismiss="modal" aria-hidden="true">Fermer</button>
			  	<label> Vous n'avez pas un compte ? <a href="register.php">Creer maintenant</a></label>
			  	
			  </div>
			</form>		
		  </div>
		</div>
	</li>
    </ul>
  </div>
</div>
</div>
</div>
<!-- Header End====================================================================== -->
<div id="mainBody">
<div class="container">
	<hr class="soften">
	<h1>Nous Visiter</h1>
	<hr class="soften"/>	
	<div class="row">
		<div class="span4">
		<h4>Détail contact</h4>
		<p>	Commune Ibanda,<br/> Av E.P Lumumba, 009A
			<br/><br/>
			info@allocationhouse.com<br/>
			﻿Tel +243 978-334-8900<br/>
			
			web:allocationhouse.com<br/>
			blog:wwwnossavoirs.blogspot.com<br/>
		</p>		
		</div>
			
		<div class="span4">
		<h4>Heur d'ouverture</h4>
			<h5> Lundi - Jeudi</h5>
			<p>08:00h - 16:00h<br/><br/></p>
			<h5>Vendredi</h5>
			<p>08:00h - 15:00h<br/><br/></p>
			<h5>Samedi</h5>
			<p>08:00h - 12:00h<br/><br/></p>
		</div>
		<div class="span4">
		<h4>Nous envoyer l'Email</h4>
		<form class="form-horizontal">
        <fieldset>
          <div class="control-group">
           
              <input type="text" placeholder="Nom" class="input-xlarge"/>
           
          </div>
		   <div class="control-group">
           
              <input type="text" placeholder="Email" class="input-xlarge"/>
           
          </div>
		   <div class="control-group">
           
              <input type="text" placeholder="Object" class="input-xlarge"/>
          
          </div>
          <div class="control-group">
              <textarea rows="3" id="textarea" class="input-xlarge"></textarea>
           
          </div>

            <button class="btn btn-large" type="submit">Envoyer</button>

        </fieldset>
      </form>
		</div>
	</div>
	
</div>
</div>
<!-- MainBody End ============================= -->
<!-- Footer -->
<?php include('include/footer.php'); ?>

</body>
</html>