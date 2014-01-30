<?php
$this->pageTitle = Yii::app()->name;
?>
	<div class="jumbotron">
		<div class="container">
			<h2>Need to know if a site is up?</h2>
			<p>Just enter a URL below and we'll check whether the site is working</p>

			<form class="form-inline" method="post">
				<fieldset>

					<!-- URL input-->
					<div class="control-group">
						<input id="url" name="CheckSiteForm[url]" type="text" placeholder=" Enter a URL here" class="input-xlarge">
					</div>

					<!-- Multiple Radios (inline) -->
					<div class="control-group">
						<label class="radio inline" for="test-method-0">
							<input type="radio" name="CheckSiteForm[testMethod]" id="test-method-0" value="1" checked="checked">
							Use the cURL library
						</label>
						<label class="radio inline" for="test-method-1">
							<input type="radio" name="CheckSiteForm[testMethod]" id="test-method-1" value="2">
							Use a manual socket connection
						</label>
					</div>

					<!-- Submit Button -->
					<div class="form-actions">
						<div class="controls">
							<button type="submit" class="btn btn-primary btn-lg">Check the site &raquo;</button>
						</div>
					</div>

				</fieldset>
			</form>
		</div>
		<?php
			if ($model->isSiteOk() === true) {
				echo '<div class="container"><br><div class="alert alert-success"><strong>' . $model->url . '</strong> is online!</div></div>';
			}
			elseif ($model->isSiteOk() === false) {
				echo '<div class="container"><br><div class="alert alert-danger"><strong>' . $model->url . '</strong> appears to be offline</div></div>';
			}
		?>
	</div>

<?php
$siteChecks = $model->getSiteChecks();
if (is_array($siteChecks)):
?>
	<div class="container">
		<h3>Most recent site checks:</h3>
		<table class="table">
			<thead>
				<tr>
					<th>URL</th>
					<th>Status</th>
					<th>Date</th>
					<th>Location</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($model->siteChecks as $siteCheck) {
						echo '<tr class="' . ($siteCheck->site_ok ? 'success' : 'danger') . '"><td>' . $siteCheck->url . '</td>';
						echo '<td>' . ($siteCheck->site_ok ? 'ONLINE' : 'DOWN') . '</td>';
						echo '<td>' . $siteCheck->check_date . '</td>';
						echo '<td>' . "Location here" . '</td></tr>';
					}
				?>
			</tbody>
		</table>
	</div>
<?php endif; ?>