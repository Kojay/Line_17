<?php

namespace app\models;

use yii\base\Model;

class ldap extends Model
{
    //TODO: config array needs to be updated with all domain controllers!
    public $config = [
                        'domain_controllers' => ['dsera111.edu.ds.fhnw.ch'],
                        'base_dn' => 'ou=edu,ou=prod,dc=edu,dc=ds,dc=fhnw,dc=ch',
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
}
?>