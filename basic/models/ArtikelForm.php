<?php

namespace app\models;

use Yii;
use yii\base\Model;



/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ArtikelForm extends Model
{
    public $articleNumber, $articleName, $articleWorkstation, 
           $articleType, $articleManufacturer, $articleSerialnumber, 
           $articleInstitute, $articlePurchased, $articleGuarantee, 
           $articlePrice, $articleFHNW, $articleDescription, $articleID;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [   
        ];
    }

}
