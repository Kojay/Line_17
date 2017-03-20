<?php
namespace app\models;

use yii\base\Model;



/**
 *
 *
 */
class Hersteller extends Model
{
    public $articleproducerName, $articleproducerDescription;
    
        
    //Listing of maximum Lengths for Database input
    const ARTICLEPRODUCERNAME_MAX_LENGTH            = 128;
    const ARTICLEPRODUCERDESCRIPTION_MAX_LENGTH     = 512;
    
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return 
        [  
            //RULES must be validated and set according to prj team !DB dependencies!
            'requiredRule' => [['articleproducerName', 'articleproducerDescription'], 'required'],
            
            'articleproducerNameRule'   => 
            [
                ['articleproducerName'],
                'string',
                'max' => self::ARTICLEPRODUCERNAME_MAX_LENGTH,
                'message' => 'Bitte geben Sie einen gültigen Namen ein, Sonderzeichen sind zu vermeiden sowie mehr als '.self::ARTICLEPRODUCERNAME_MAX_LENGTH.' Zeichen'
            ],      
            [
                ['articleproducerDescription'], 
                'string', 
                'max' => self::ARTICLEPRODUCERDESCRIPTION_MAX_LENGTH,
                'message' => 'Bitte geben Sie eine gültige Beschreibung ein, Sonderzeichen sind zu vermeiden sowie mehr als '.self::ARTICLEPRODUCERDESCRIPTION_MAX_LENGTH.' Zeichen'
            ],
            [
                [
                    'articleproducerName', 
                    'articleproducerDescription'
                ], 
                'safe'
            ],
        ];
    }

}
