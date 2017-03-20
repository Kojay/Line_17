<?php
namespace app\models;

use yii\base\Model;



/**
 * LoginForm is the model behind the login form.
 * @author Alexander Weinbeck
 * @property User|null $user This property is read-only.
 *
 */
class Ausleihe extends Model
{
    //db properties
    public
           $loanPersonMail,
           $articleName,
           $fhnwNumber,
           $articleTypeName,
           $lvLoanLendingDate,
           $lvLoanReturnDate,
           $loanAuthorityMail,
           $loanLocation,
           $loanDescription;
    //ldap properties
    public $loanInstitute,
           $loanLecturer,
           $loanName;

    public $loanArticles = array();
    
    //TODO: Datenbanknamen überarbeiten, darauf basierend Rules setzen! 
    
    //Listing of predefined DB Input values, which are valid
    //const LOANLENDINGDATE_DEFAULTVALUE       = 'Nicht ausgeliehen';
    
    //Listing of maximum Lengths for Database input
    //const SERIALNUMBER_MAX_LENGTH            = 40;
    //Listing of minimum Lengths for Database input
    //const ARTICLENAME_MINLENGTH             = 40;
    
    
    /**
     * @author Alexander Weinbeck
     * @return array of the validation rules.
     */
    public function rules()
    {
        return 
        [  
            //TODO RULES must be validated and set according to prj team !DB dependencies!
            'requiredRule' => [['articleName', 'fhnwNumber'], 'required'],
            
            'articleNameRule'   => [
                                    ['articleName'],
                                    'string',
                                    'max' => 10,
                                    'message' => 'Bitte geben Sie einen gültigen Namen ein, Sonderzeichen sind zu vermeiden sowie mehr als 10 Zeichen'],
            
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
