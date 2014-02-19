<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="//oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
	<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="/js/spin.min.js"></script>
	<script src="/js/ladda.min.js"></script>
	<link rel="stylesheet" href="/css/ladda-themeless.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
	<link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/site-checker.css">
</head>

<body>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">SiteChecker</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li <?php if ($this->action->id == 'index') echo 'class="active"'; ?>><a href="/">Home</a></li>
				<li <?php if ($this->action->id == 'about') echo 'class="active"'; ?>><a href="/about">About</a></li>
			</ul>
		</div><!--/.navbar-collapse -->
	</div>
</div>

<?php echo $content; ?>

<footer>
	<hr>
	<p>&copy; <a href="http://davemac.info" target="_blank">Dave J. McClure</a> <?php echo date("Y"); ?></p>
</footer>

<!-- Bootstrap core JavaScript. Placed at the end of the document so the page loads faster -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

</body>
</html>
