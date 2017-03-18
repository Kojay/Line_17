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
    //389 ldap port default
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



    public function getAuthentication($username, $password){
        //establish AD connection
        if((new \Adldap\Adldap($this->config))->authenticate($username, $password)){
            // User passed authentication
            return true;
        }
        else{
            // Username or password is incorrect
            return false;
        }
    }
}
?>