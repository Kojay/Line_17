<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;

/**
 * ContactForm is the model behind the contact form.
 */
class SearchForm extends Model
{
    private $dataProvider;

      
    public function getData()
    {
        $dataProvider = new SqlDataProvider([
        'sql' => 'SELECT * FROM country ',
            
        'sort' => [
        'attributes' => [
            'name' => [
                'asc' => ['name' => SORT_ASC],
                'desc' => ['name' => SORT_DESC],
                //'default' => SORT_DESC,
                'label' => 'Post Title',
            ],
            'population' => [
                'asc' => ['population' => SORT_ASC],
                'desc' => ['population' => SORT_DESC],
                'default' => SORT_DESC,
                'label' => 'Name',
            ],
			'created_on'
        ],
    ],
            'pagination' => [
	    'pagesize' => 80,
    ],

        ]);
        return $dataProvider;
    }
}



