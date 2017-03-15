<?php

namespace app\models;

use yii\base\Model;
/**
 * Ldap class for AD-Connection
 * @author Alexander Weinbeck
 *
 */
class ldap extends Model
{
    //TODO: config array needs to be updated with all domain controllers!
    public $config = [
                        'domain_controllers' => ['edu.ds.fhnw.ch'/*,'adm.ds.fhnw.ch'*/], //only working on Testserver
                        'base_dn' => 'ou=edu,ou=prod,dc=edu,dc=ds,dc=fhnw,dc=ch', // ou=edu,ou=prod,dc=edu,
                        'admin_username' => 'u_18.39_lagerverwaltung02',
                        'admin_password' => 'FHNW@2016',
                        'follow_referrals' => true,
                        'use_ssl' => false,
                        'use_tls' => false,
                        'use_sso' => false,
                        ];
    public $configTwo = [                                           //only working on Testserver
                        'domain_controllers' => ['adm.ds.fhnw.ch'],
                        'base_dn' => 'ou=adm,ou=prod,dc=adm,dc=ds,dc=fhnw,dc=ch',
                        'admin_username' => 'u_18.39_lagerverwaltung02',
                        'admin_password' => 'FHNW@2016',
                        'follow_referrals' => true,
                        'use_ssl' => false,
                        'use_tls' => false,
                        'use_sso' => false,
    ];
    //389 Port default


    public function getAuthentication($username, $password){
        //establish AD connection
        if((new \Adldap\Adldap($this->config))->authenticate($username, $password)){
            // User passed authentication
            return true;
        }
        else{
            // Looks like the username or password is incorrect
            return false;
        }
    }
    /*
    public function getUserDataArray($username){
        //$ad = (new \Adldap\Adldap((new ldap)->config));
        //$user = $ad->users()->find('sukey.adam@students.fhnw.ch');
        //$record = $ad->search()->find('Adam Sukey');
        //$adUser = (new \Adldap\Adldap((new ldap)->config))->users()->search()->find('alexander.weinbeck@students.fhnw.ch');
        if((new \Adldap\Adldap($this->config))) {

            $adUser = (new \Adldap\Adldap($this->config))->users()->search()->find($username);
            if($adUser) {

                $userDataArray = [
                    'username' => $username,
                    'department' => $adUser->department,
                    'title' => $adUser->title,
                    'company' => $adUser->company,
                ];
                return $userDataArray;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
        //$y->get
        //$users = $ad->users()->all();
        //echo var_dump($y->getDistinguishedName());
        //echo var_dump($y->getAccountType());
        //echo var_dump($y->getAttributes());
        //echo var_dump($y->title);
        //echo var_dump($y->department);
        //echo var_dump($y->company);
        //echo var_dump($users[392]);
    }*/

}
?>