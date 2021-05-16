<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Личный кабинет';
$changeValueScript = '
let value = this.closest("#graph-value").value;

let humidity = elem.getElementsByClassName(".graphHumidity").closest("#graph-value").value;
let groundTemp = elem.getElementsByClassName(".graphGroundTemp").closest("#graph-value").value;
let ikTemp = elem.getElementsByClassName(".graphIkTemp").closest("#graph-value").value;

elem.getElementsByClassName(".humidity").value(humidity);
elem.getElementsByClassName(".groundTemp").value(groundTemp);
elem.getElementsByClassName(".irTemp").value(ikTemp);



// Создаем экземпляр класса XMLHttpRequest
const request = new XMLHttpRequest();

// Указываем путь до файла на сервере, который будет обрабатывать наш запрос 
const url = "http://тепличка22.рф/index.php?r=site%2Fcabinet";
 
// Так же как и в GET составляем строку с данными, но уже без пути к файлу 
const params = "humidity=" + humidity + "groundTemp" + groundTemp + "ikTemp" + ikTemp;
 
/* Указываем что соединение	у нас будет POST, говорим что путь к файлу в переменной url, и что запрос у нас
асинхронный, по умолчанию так и есть не стоит его указывать, еще есть 4-й параметр пароль авторизации, но этот
	параметр тоже необязателен.*/ 
request.open("POST", url, true);
 
//В заголовке говорим что тип передаваемых данных закодирован. 
request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 
request.addEventListener("readystatechange", () => {

    if(request.readyState === 4 && request.status === 200) {       
		console.log(request.responseText);
    }
});
 
//	Вот здесь мы и передаем строку с данными, которую формировали выше. И собственно выполняем запрос. 
request.send(params);
';

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
      <h2>Температура ИК</h2>
      <div class="graphIkTemp"></div>

		<?php
		$irTemp = '';
		echo Html::input('text', 'Актуальное значение', $irTemp .= $data['irTemp'], ['class'=>'irTemp', 'id' => 'value', 'readOnly'=>true]);
		?>
		<?php $form = ActiveForm::begin(); ?>

		    <?= $form->field($model, 'value') ?>

		    <div class="form-group">
		        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'onclick'=>$changeValueScript]) ?>
		    </div>

		<?php ActiveForm::end(); ?>
    </div>

    <div class="humidity-graph col-md-4">
		<h2>Температура земли</h2>
  		<div class="graphGroundTemp"></div>
		<?php
		$irTemp = '';
		echo Html::input('text', 'Актуальное значение', $irTemp .= $data['groundTemp'], ['class'=>'groundTemp', 'id' => 'value', 'readOnly'=>true]);
		?>

		<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'value') ?>

		    <div class="form-group">
		        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'onclick'=>$changeValueScript]) ?>
		    </div>

		<?php ActiveForm::end(); ?>
    </div>

    <div class="airing-graph col-md-4">
		<h2>Влажность</h2>
  		<div class="graphHumidity"></div>
		<?php
		$irTemp = '';
		echo Html::input('text', 'Актуальное значение', $irTemp .= $data['humidity'], ['class'=>'humidity', 'id' => 'value', 'readOnly'=>true]);
		?>
		<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'value') ?>

		    <div class="form-group">
		        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'onclick'=>$changeValueScript]) ?>
		    </div>

		<?php ActiveForm::end(); ?>
  </div>