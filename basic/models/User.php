<?php

namespace app\models;

use yii\base\Model;

/**
 * Benutzer is the model behind the actual user.
 * @author Alexander Weinbeck
 * @property User|null $user This property is read-only.
 *
 */
class User extends Model
{
    public $mail,
           $displayname,
           $isUserAdmin,
           $userID,
           $department,
           $company,
           $title;
    
    //TODO: Datenbanknamen überarbeiten, darauf basierend Rules setzen! 
    
    //Listing of predefined DB Input values, which are considered or defined as valid
    //Listing of maximum Lengths for Database input
    const USERNAME_MAXLENGTH             = 40;
    const USERSURNAME_MAXLENGTH          = 40;
    const USERPERMISSION_MAXLENGTH       = 40;
    
    //Listing of minimum Lengths for Database input
    //const ARTICLENAME_MINLENGTH             = 40;

    /**
     * Rules user
     * @author Alexander Weinbeck
     * @return array of the validation rules.
     */
    public function rules()
    {
        return 
        [  
            //RULES must be validated and set according to prj team !DB dependencies!
            'requiredRule' => [['mail', 'isUserAdmin','userID'], 'required'],

            [['isUserAdmin'], 'number', 'message' => 'Bitte wählen sie eine Berechtigung.'],
            [['userID'],'number'],
            [['mail'],'email'],
        ];
    }


}