<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class UserDB
 * @author Alexander Weinbeck
 * @package app\models
 */
class UserDB extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'lv_user';
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }
    /**
     * Finds an identity by the given ID.
     * @author Alexander Weinbeck
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    /**
     * Finds an identity by the given token.
     * @author Alexander Weinbeck
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }
    /**
     * Find username
     * @author Alexander Weinbeck
     * @param $username
     * @return static
     */
    public static function findByUsername($username){
        return self::findOne(['username'=>$username]);
    }
    /**
     * Gets an identity by ID
     * @author Alexander Weinbeck
     * @param $parID
     * @return static
     */
    public function getIdentityByID($parID){
        return self::findOne(['userID'=>$parID]);
    }
    /**
     * Returns id
     * @author Alexander Weinbeck
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->userID;
    }
    /**
     * @author Alexander Weinbeck
     * @return mixed
     */
    public function getEmail()
    {
        return $this->personMail;
    }
    /**
     * @author Alexander Weinbeck
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    /**
     * @author Alexander Weinbeck
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
