<?php
namespace app\models;

use yii\base\Model;



/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Artikel extends Model
{
    public $articleName, $dateBought, $articleTypeName, $articleproducerName, $serialNumber, 
           $dateWarranty, $articlePrice, $fhnwNumber, $articleDescription;
    
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
            
            'articleNameRule'   => [
                                    ['articleName'],
                                    'string',
                                    'max' => self::ARTICLENAME_MAX_LENGTH,
                                    'message' => 'Bitte geben Sie einen gültigen Namen ein, Sonderzeichen sind zu vermeiden sowie mehr als '.self::ARTICLENAME_MAX_LENGTH.' Zeichen'],      
            
            [['fhnwNumber'], 'number', 'message' => 'Bitte geben Sie eine gültige FHNWNummer ein, bestehend aus Zahlen.'],
            //[['articleproducerName'],'required'],
            [['dateBought'],'date' ,'max' => 40 ,'message' => 'Bitte geben Sie einen gültigen Namen ein'],
            [['articleTypeName'],'string' ,'max' => 40],
            [['articlePrice'], 'string', 'max' => 40],
            [['articleDescription'], 'string', 'max' => 90],
            [['dateWarranty'], 'string', 'max' => 40],
            [['serialNumber'],'number'],
            [['articleName', 'articleproducerName', 'fhnwNumber', 'dateBought', 'articleTypeName', 'articlePrice', 'articleDescription', 'dateWarranty', 'serialNumber'], 'safe'],
           // ['rentedUntil', 'default', 'value' => self::DEFAULTVALUE_RENTED_UNTIL],
        ];
    }

}
