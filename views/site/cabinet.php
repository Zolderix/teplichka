<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Личный кабинет';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="row buttonContainer container-fluid">
	<div class="row">
		<a class="btn nonReceipt btn-lg btn-success active" href="#">Без рецепта</a>
		<a class="btn byReceipt btn-lg btn-success" href="#">Сделать рецепт</a>
	</div>
</div>



<div class="graphs row graphContainer">

    <div class="temperature-graph col-md-4">
      <h2>Температура</h2>
      <div class="graphTemp"></div>
		<?php $form = ActiveForm::begin(); ?>

		    <?= $form->field($data['irTemp'], 'value') ?>

		    <div class="form-group">
		        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
		    </div>

		<?php ActiveForm::end(); ?>
    </div>

    <div class="humidity-graph col-md-4">
		<h2>Влажность</h2>
  		<div class="graphHumidity"></div>
		<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($data['groundTemp'], 'value') ?>

		    <div class="form-group">
		        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
		    </div>

		<?php ActiveForm::end(); ?>
    </div>

    <div class="airing-graph col-md-4">
		<h2>Проветриваемость</h2>
  		<div class="graphAiring"></div>
		<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($data['humidity'], 'value') ?>

		    <div class="form-group">
		        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
		    </div>

		<?php ActiveForm::end(); ?>
  </div>