<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Graph extends Model
{
    public $name;
    public $value;

    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
        ];
    }

    public function attributeLabels()
	{
		return array(
			'name' => 'Название',
			'value' => 'Значение'
		);
	}

	public function get
}