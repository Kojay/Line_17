<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\QueryRqst;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
        ];
    }
    /**
     * Logs in a user using the provided username and password.
     * Following validations are being made:
     * ***model validation (user input into activeform) (->validate())
     * ***validation with application database (->validateLogin())
     * ***validation with Active Directory (->validateLogin())
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if($this->validate() && $this->validateLogin()) {
           Yii::$app->user->login((new UserDB())->getIdentityByID((new QueryRqst())->getLoginData($this->username)['userID']), $this->rememberMe ? 3600 * 30 * 24 : 0);
           return true;
        }
        return false;
    }
    /**
     * validates login credentials
     *
     * @return User|null
     */
    public function validateLogin()
    {
        if((new QueryRqst())->getLoginData($this->username)['personMail'] === $this->username){
            //TODO: AD Authentfication is always true now, while migrating into new environment this needs to be tested!
            return $this->username;
            //here's the ad authentification
            if((new ldap())->getAuthentication($this->username,$this->password)){
                return $this->username;
            }
            else{
                $this->addError('login', 'Falscher Benutzername oder Passwort (Active Directory Zugang)');
                return false;
            }
        }
        else{
            $this->addError('login', 'Falscher Benutzername oder Passwort (HWAusleihe Zugang)');
            return false;
        }
    }
}
