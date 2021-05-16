<?php
namespace app\models;

use mysqli;

class SensorsData {

	public function execute($query) {
		return Yii::app()->db->createCommand()->queryAll();
	}


// 'SELECT'
// . $SELECT_fields
// . '*'
// . ' FROM ('
// . (empty($form->type_call) ? self::queryDataRequest('src', $form) . ' UNION ALL ' . self::queryDataRequest('dst', $form) : NULL)
// . ($form->type_call == 1 ? self::queryDataRequest('dst', $form) : NULL)
// . ($form->type_call == 2 ? self::queryDataRequest('src', $form) : NULL)
// . ') as main'
// . ' GROUP BY' . $GROUP_fields . ' main.name'
// . ' ORDER BY main.name'



	public function getSensorsData() {
	        return
				' SELECT'
				.' sensor_id'
				.' value'
				.' esp_know'
				.' sensor_name'
				.' identity'
				.' FROM incubator_sensor_values sv'
				.' JOIN teplichka.user_identities ui ON sv.user_ident_id = ui.user_id'
				.' JOIN teplichka.user u ON u.id = ui.user_id'
				.' JOIN teplichka.sensors_names sn ON sn.id = sv.sensor_id'
				.' WHERE'
				.' esp_know = 0';
	}





}


$user_ident = "tPmAT5Ab3j7F9";

$get_ident= $sensor = $location = $value1 = $value2 = $value3 = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $get_ident = test_input($_GET["api_key"]);
    if($get_ident == $user_ident) {
        $irTempSensor = test_input($_GET["irTempSensor"]);
        $groundTempSensor = test_input($_GET["groundTempSensor"]);
        $humidity = test_input($_GET["humidity"]);

        // Create connection
        $conn = new mysqli('localhost', 'zolderix', '13213', 'teplichka');
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

		$user_ident = 1;//"tPmAT5Ab3j7F9";
// $sql = "INSERT INTO datafromsensors(irTempSensor, groundTempSensor, humidity) VALUES (".$irTempSensor.",".$groundTempSensor.",".$humidity.")";
$sql1 = 	'INSERT INTO incubator_sensor_values (id, sensor_id, value, user_ident_id, esp_know) VALUES (NULL, 1, '.$irTempSensor.', '.$user_ident.', 1);';
$sql2 = ' INSERT INTO incubator_sensor_values (id, sensor_id, value, user_ident_id, esp_know) VALUES (NULL, 2, '.$groundTempSensor.', '.$user_ident.', 1);';
$sql3 = ' INSERT INTO incubator_sensor_values (id, sensor_id, value, user_ident_id, esp_know) VALUES (NULL, 3, '.$humidity.', '.$user_ident.', 1);';

if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE && $conn->query($sql3) === TRUE) {
            echo "New record created successfully";
        }
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }

}
else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}