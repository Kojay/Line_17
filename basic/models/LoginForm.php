<?php

namespace app\models;

use Adldap\Adldap;
use Adldap\Models\User;
use Yii;
use yii\base\Model;
use app\models\QueryRqst;

/**
 * LoginForm is the model behind the login form.
 * @author Alexander Weinbeck
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $mail;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    /**
     * @author Alexander Weinbeck
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['mail', 'password'], 'required'],
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
     * @author Alexander Weinbeck
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if($this->validate() && $this->validateLogin()) {
           Yii::$app->user->login((new UserDB())->getIdentityByID((new QueryRqst())->getLoginData($this->mail)['userID']), $this->rememberMe ? 3600 * 30 * 24 : 0);
            //assigns RBAC role to user if isUserAdmin is set to true
           if((new QueryRqst())->getLoginData($this->mail)['isUserAdmin'] && !Yii::$app->user->can('usercontrol')) {
               Yii::$app->authManager->assign(Yii::$app->authManager->getRole('admin'), Yii::$app->user->getId());
           }
           return true;
        }
        return false;
    }
    /**
     * Validates login credentials
     * @author Alexander Weinbeck
     * @return User|null
     */
    public function validateLogin()
    {
        if((new QueryRqst())->getLoginData($this->mail)['email'] === $this->mail){
            //TODO: AD Authentfication is always true now, while migrating into new environment this needs to be tested!
            return $this->mail;
            //here's the ad authentification
            if((new Adldap((new ldap)->LDAPCFGEDU))->getAuthentication($this->email,$this->password)){
                return $this->mail;
            }
            //here's the superuser authentication
            else{
                $user = (new QueryRqst())->getSuperuser($this->mail);
                if($user && $user->password === $this->password){
                    return $this->mail;
                }
            }
            $this->addError('login', 'Falscher Benutzername oder Passwort (Active Directory Zugang)');
            return false;
        }
        else{
            $this->addError('login', 'Falscher Benutzername oder Passwort (HWAusleihe Zugang)');
            return false;
        }
    }
}
