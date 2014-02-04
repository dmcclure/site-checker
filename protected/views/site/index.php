<?php
$this->pageTitle = Yii::app()->name;
?>
	<div class="jumbotron">
		<div class="container">
			<h2>Need to know if a site is up?</h2>
			<p>Just enter a URL below and we'll check whether the site is working</p>

			<form class="form-horizontal" method="post">
				<fieldset>

					<!-- URL input-->
					<div class="form-group<?php if ($model->getError('url')) echo ' has-error'; ?>">
						<input id="url" name="CheckSiteForm[url]" type="text" placeholder=" Enter a URL here" value="<?= $model->url ?>" size="25">
						<?php
							if ($model->getError('url')) {
								echo '<span class="help-block">' . $model->getError('url') . '</span>';
							}
						?>
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
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($model->siteChecks as $siteCheck) {
						echo '<tr class="' . ($siteCheck->site_ok ? 'success' : 'danger') . '"><td>' . $siteCheck->url . '</td>';
						echo '<td>' . ($siteCheck->site_ok ? 'ONLINE' : 'DOWN') . '</td>';
						echo '<td>' . $siteCheck->check_date . '</td>';
					}
				?>
			</tbody>
		</table>
	</div>
<?php endif; ?>