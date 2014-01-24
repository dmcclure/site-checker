<?php
$this->pageTitle = Yii::app()->name;

$model->verifyCode = '';

if (!isset($model->siteOk)) {
    echo '<h1>Welcome to <i>' . CHtml::encode(Yii::app()->name) . '!</i></h1>';
}
else if ($model->siteOk) {
    echo '<div class="flash-success">' . $model->url . ' is online!</div>';
}
else {
    echo '<div class="flash-error">' . $model->url . ' is down!</div>';
}
?>

<p>Enter a URL below to check whether the site is working normally</p>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'site-check-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'url'); ?>
        <?php echo $form->textField($model, 'url', array('size'=>50)); ?>
        <?php echo $form->error($model, 'url'); ?>
    </div>

    <?php if(CCaptcha::checkRequirements()): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'verifyCode'); ?>
            <div>
                <?php $this->widget('CCaptcha'); ?>
                <?php echo $form->textField($model, 'verifyCode'); ?>
            </div>
            <div class="hint">Please enter the letters as they are shown in the image above.
                <br/>Letters are not case-sensitive.</div>
            <?php echo $form->error($model, 'verifyCode'); ?>
        </div>
    <?php endif; ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php
if (is_array($model->siteChecks)) {
    echo '<p><br><br>Five most recent site checks:</p><ul>';

    foreach ($model->siteChecks as $siteCheck) {
        echo '<li>&quot;' . $siteCheck->url . '&quot; - ';
        echo $siteCheck->site_ok ? 'ONLINE' : 'DOWN';
        echo ' (' . $siteCheck->check_date . ')</li>';
    }
}
?>