<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
?>
<div class="container">
	<h1>About</h1>

	<p>This site makes use of a number of modern web technologies including the following:</p>

	<div class="row">
		<div class="col-md-4">
			<h3>Bootstrap</h3>
			<p>This site uses the Bootstrap front-end framework. This allows a responsive design (try narrowing the browser window!) and a consistent experience across browsers.</p>
			<p><a class="btn btn-default" href="http://getbootstrap.com/" role="button" target="_blank">Check out Bootstrap &raquo;</a></p>
		</div>
		<div class="col-md-4">
			<h3>jQuery</h3>
			<p>This site uses the jQuery JavaScript library for UI elements, event handling and the AJAX functionality.</p>
			<p><a class="btn btn-default" href="http://jquery.com/" role="button" target="_blank">Check out jQuery &raquo;</a></p>
		</div>
		<div class="col-md-4">
			<h3>Yii</h3>
			<p>The Yii PHP MVC web application framework is used on the back end. Use of the framework includes the MVC architecture, web service request handling and DB interaction with Active Record.</p>
			<p><a class="btn btn-default" href="http://yiiframework.com/" role="button" target="_blank">Check out Yii &raquo;</a></p>
		</div>
	</div>

</div> <!-- /container -->
