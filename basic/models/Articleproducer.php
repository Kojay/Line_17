<?php
namespace app\models;

use yii\base\Model;



/**
 * 
 *
 */
class Articleproducer extends Model
{
    public $articleName, $dateBought, $articleTypeName, $articleproducerName, $serialNumber, 
           $dateWarranty, $articlePrice, $fhnwNumber, $articleDescription, $lv_producer_producerID, $lv_articletype_articleTypeID;
    
    //TODO: Datenbanknamen überarbeiten, darauf basierend Rules setzen! 
    
    //Listing of predefined DB Input values, which are valid
    //const LOANLENDINGDATE_DEFAULTVALUE       = 'Nicht ausgeliehen';
    
    //Listing of maximum Lengths for Database input
    const ARTICLENAME_MAX_LENGTH             = 40;
    const FHNWNUMBER_MAX_LENGTH              = 40;
    const ARTICLEPRODUCERNAME_MAX_LENGTH     = 40;
    const DATEBOUGHT_MAX_LENGTH              = 40;
    const ARTICLETYPENAME_MAX_LENGTH         = 40;
    const ARTICLEPRICE_MAX_LENGTH            = 40;
    const ARTICLEDESCRIPTION_MAX_LENGTH      = 40;
    const DATEWARRANTY_MAX_LENGTH            = 40;
    const SERIALNUMBER_MAX_LENGTH            = 40;
    //Listing of minimum Lengths for Database input
    //const ARTICLENAME_MINLENGTH             = 40;
    
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return 
        [  
            //RULES must be validated and set according to prj team !DB dependencies!
            'requiredRule' => [['articleName', 'fhnwNumber'], 'required'],
            
            'articleNameRule'   => 
            [
                ['articleName'],
                'string',
                'max' => self::ARTICLENAME_MAX_LENGTH,
                'message' => 'Bitte geben Sie einen gültigen Namen ein, Sonderzeichen sind zu vermeiden sowie mehr als '.self::ARTICLENAME_MAX_LENGTH.' Zeichen'
            ],      
            [
                ['fhnwNumber'], 
                'string', 
                'max' => 4, 
                'message' => 'Bitte geben Sie ein FHNW Institut ein'
            ],
            //[['articleproducerName'],'required'],
            [
                ['dateBought'],
                'date' ,
                'max' => 40 ,
                'message' => 'Bitte geben Sie ein gültiges Kaufdatum ein'
            ],
            [
                ['articleTypeName'],
                'string' ,
                'max' => 40 ,
                'message' => 'Bitte geben Sie einen gültigen Artikelnamen ein'
            ],
            [
                ['articlePrice'],
                'number' ,
                'message' => 'Bitte geben Sie einen gültigen Preis ein'
            ],
            [
                ['articleDescription'], 
                'string', 
                'max' => 90 ,
                'message' => 'Bitte geben Sie eine Beschreibung ein'
            ],
            [
                ['dateWarranty'], 
                'date',
                'message' => 'Bitte geben Sie ein gültiges Garantiedatum ein'
            ],
            [
                ['serialNumber'],
                'number' ,
                'message' => 'Bitte geben Sie eine gültige Seriennummer ein'
            ],
            [
                ['lv_articletype_articleTypeID']
                ,'number'
            ],
            [
                ['lv_producer_producerID'],
                'number'
            ],
            [
                [
                    'articleName', 
                    'articleproducerName', 
                    'fhnwNumber', 
                    'dateBought', 
                    'articleTypeName', 
                    'articlePrice', 
                    'articleDescription', 
                    'dateWarranty', 
                    'serialNumber', 
                    'lv_articletype_articleTypeID', 
                    'lv_producer_producerID'
                ], 
                'safe'
            ],
           // ['rentedUntil', 'default', 'value' => self::DEFAULTVALUE_RENTED_UNTIL],
        ];
    }

}
