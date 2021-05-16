<?php

namespace app\controllers;

use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\String_;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Graph;
use mysqli;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

	/**
	     * Displays cabinet page.
	     *
	     * @return string
	 */
	public function actionCabinet()
	{
		// Create connection
		$conn = new mysqli('localhost', 'zolderix', '13213', 'teplichka');
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		if(null!==Yii::$app->request->post('params')){

			$sql1 = 'INSERT INTO 
			incubator_sensor_values
			 (id, sensor_id, value, user_ident_id, esp_know) 
			 VALUES
			 (NULL, 1, '.$_POST['params']['ikTemp'].', 1, 1)';
			$conn->query($sql1);
			$sql2 = 'INSERT INTO 
			incubator_sensor_values
			 (id, sensor_id, value, user_ident_id, esp_know) 
			 VALUES
			 (NULL, 2, '.$_POST['params']['groundTemp'].', 1, 1)';
			$conn->query($sql2);
			$sql3 = 'INSERT INTO 
			incubator_sensor_values
			 (id, sensor_id, value, user_ident_id, esp_know) 
			 VALUES
			 (NULL, 3, '.$_POST['params']['humidity'].', 1, 1)';
			$conn->query($sql3);
		}



		$model = new Graph();
		$model->name = 'Temp';
		$model->value = 22;
		if ($model->validate()) {
		    // Good!
		} else {
		    // Failure!
		    // Use $model->getErrors()
		}

		$user_ident = 1;//"tPmAT5Ab3j7F9";
		// $sql = "INSERT INTO datafromsensors(irTempSensor, groundTempSensor, humidity) VALUES (".$irTempSensor.",".$groundTempSensor.",".$humidity.")";
		$sql1 = 'SELECT
						value
					 FROM incubator_sensor_values sv
					 JOIN teplichka.user_identities ui ON sv.user_ident_id = ui.user_id
					 JOIN teplichka.user u ON u.id = ui.user_id
					 JOIN teplichka.sensors_names sn ON sn.id = sv.sensor_id
					 WHERE
					 identity = "tPmAT5Ab3j7F9" AND sensor_id = 1
					 ORDER BY sv.id DESC LIMIT 1';
		$sql2 = 'SELECT
						value
					 FROM incubator_sensor_values sv
					 JOIN teplichka.user_identities ui ON sv.user_ident_id = ui.user_id
					 JOIN teplichka.user u ON u.id = ui.user_id
					 JOIN teplichka.sensors_names sn ON sn.id = sv.sensor_id
					 WHERE
					 identity = "tPmAT5Ab3j7F9" AND sensor_id = 2
					 ORDER BY sv.id DESC LIMIT 1';
		$sql3 = 'SELECT
						value
					 FROM incubator_sensor_values sv
					 JOIN teplichka.user_identities ui ON sv.user_ident_id = ui.user_id
					 JOIN teplichka.user u ON u.id = ui.user_id
					 JOIN teplichka.sensors_names sn ON sn.id = sv.sensor_id
					 WHERE
					 identity = "tPmAT5Ab3j7F9" AND sensor_id = 3
					 ORDER BY sv.id DESC LIMIT 1';
		$data = array();
		$data['irTemp'] = $conn->query($sql1)->fetch_assoc()['value'];
		$data['groundTemp'] = $conn->query($sql2)->fetch_assoc()['value'];
		$data['humidity'] = $conn->query($sql3)->fetch_assoc()['value'];

		return $this->render('cabinet', [
		            'model' => $model,
					'data' => $data,
		        ]);
	}

    public function actionGetData(){
		echo 'hello, boss, can I habe tha data?';
	}
}
