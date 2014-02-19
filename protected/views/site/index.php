<?php
$this->pageTitle = Yii::app()->name;
?>
	<div class="jumbotron">
		<div class="row">
			<div class="col-sm-8">
				<h2>Need to know if a site's up?</h2>
				<p>Just enter a URL below and I'll see if the site's working</p>

				<form id="site-check-form" class="form-horizontal" onsubmit="$('#submit-button').click(); return false">
					<fieldset>

						<!-- URL input-->
						<div class="form-group">
							<input id="url" name="CheckSiteForm[url]" type="text" placeholder=" Enter a URL here" size="50">
						</div>

						<!-- Multiple Radios (inline) -->
						<div class="form-group">
							<label class="radio-inline">
								<input type="radio" name="CheckSiteForm[testMethod]" value="1" checked="checked">
								Use the cURL library
							</label>
							<label class="radio-inline">
								<input type="radio" name="CheckSiteForm[testMethod]" value="2">
								Use a manual socket connection
							</label>
						</div>

						<!-- Submit Button -->
						<div class="form-actions">
							<div class="controls">
								<button type="button" id="submit-button" class="btn btn-primary btn-lg ladda-button" data-style="expand-right" data-size="l">Check the site &raquo;</button>
							</div>
						</div>

					</fieldset>
				</form>
				<div class="container" id="result"></div>
			</div>

			<div class="col-sm-4">
				<img class="img-responsive" src="/images/ipad-hand.png" alt>
			</div>
		</div>
	</div>

	<div class="container">
		<h3>Most recent site checks:</h3>
		<div id="recent-site-checks">
			<p>Loading...</p>
		</div>
	</div>

<script type="text/javascript">
	var ladda;

	$(document).ready(function() {
		ladda = Ladda.create(document.querySelector('#submit-button'));
		loadRecentSiteChecks();
	});

	$('#submit-button').click(function() {
		if (jQuery.trim($('#url').val()).length == 0) {
			renderError('Please enter a URL');
			return;
		}

		ladda.start();
		$('#submit-button').prop('disabled', true);
		$.getJSON('/sitecheck', $('#site-check-form').serialize(),
			function(data) {
				ladda.stop();
				$('#submit-button').prop('disabled', false);
				if (data.validation_error) {
					renderError(data.validation_error);
				}
				else if (data.ok) {
					renderSuccess(data.url + ' is online!');
				}
				else {
					renderError(data.url + ' appears to be offline');
				}
				loadRecentSiteChecks();
			}).fail(function(jqXHR, textStatus, errorThrown) {
				ladda.stop();
				$('#submit-button').prop('disabled', false);
				renderError(errorThrown);
			});
	});

	function renderSuccess(message) {
		$('#result').html('<div class="alert alert-success"><strong>' + message + '</div>')
	}

	function renderError(message) {
		$('#result').html('<div class="alert alert-danger"><strong>' + message + '</div>')
	}

	function loadRecentSiteChecks() {
		$.getJSON('/recentsitechecks',
			function(data) {
				var recentChecksTable = '<table class="table"><thead><tr><th>URL</th><th>Status</th><th>Date (PST)</th></tr></thead><tbody>';

				for (var i = 0; i < data.length; i++) {
					recentChecksTable += '<tr class="' + (data[i].site_ok == 1 ? 'success' : 'danger') + '"><td>' + data[i].url + '</td>';
					recentChecksTable += '<td>' + (data[i].site_ok == 1 ? 'ONLINE' : 'DOWN') + '</td>';
					recentChecksTable += '<td>' + data[i].check_date + '</td>';
				}

				recentChecksTable += '</tbody></table>';
				$('#recent-site-checks').html(recentChecksTable);
			}).fail(function(jqXHR, textStatus, errorThrown) {
				$('#recent-site-checks').html('<p>Loading failed</p>');
			});
	}
</script>