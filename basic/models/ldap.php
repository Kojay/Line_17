<?php

namespace app\models;

use Adldap\Adldap;
use Adldap\Exceptions\AdldapException;
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
    const LDAPCFG = [
        'domain_controllers' => ['edu.ds.fhnw.ch'/*,'adm.ds.fhnw.ch'*/], //only working on Testserver
        'base_dn' => 'ou=edu,ou=prod,dc=edu,dc=ds,dc=fhnw,dc=ch', // ou=edu,ou=prod,dc=edu,
        'admin_username' => 'u_18.39_lagerverwaltung02',
        'admin_password' => 'FHNW@2016',
        'follow_referrals' => true,
        'use_ssl' => false,
        'use_tls' => false,
        'use_sso' => false,
    ];
    /*
    const CONFIGTWO = [                                           //only working on Testserver
        'domain_controllers' => ['adm.ds.fhnw.ch'],
        'base_dn' => 'ou=adm,ou=prod,dc=adm,dc=ds,dc=fhnw,dc=ch',
        'admin_username' => 'u_18.39_lagerverwaltung02',
        'admin_password' => 'FHNW@2016',
        'follow_referrals' => true,
        'use_ssl' => false,
        'use_tls' => false,
        'use_sso' => false,
    ];
    */
    public function getAuthentication($username, $password){
        //establish AD connection
        if((new Adldap(self::LDAPCFG))->authenticate($username, $password)){
            // User passed authentication
            return true;
        }
        else{
            // Username or password is incorrect
            return false;
        }
    }
    public function getDataLoan($paramMail){
        try {
            if ($adUser = (new Adldap(self::LDAPCFG))->users()->search()->find($paramMail)) {
                return array
                (
                    'loanInstitute' => $adUser->institute,
                    'loanName' => $adUser->name,
                    'loanDepartment' => $adUser->department,
                    'loanTitle' => $adUser->title
                );
            }
        }
        catch(AdldapException $exLdap) {
            throw new AdldapException($exLdap->getMessage());
        }
    }
    public function getDataADUser($paramMail){
        try {
            //TODO insert paramMail into find when server is migrated
            if ($adUser = (new Adldap(self::LDAPCFG))->users()->search()->find($paramMail)) {
                return array
                (
                    'name' => $adUser->institute,
                    'department' => $adUser->name,
                    'title' => $adUser->department,
                    'company' => $adUser->title
                );
            } else {
                throw new AdldapException("Benutzer nicht im Active Directory vorhanden.");
            }
        }
        catch(AdldapException $exLdap) {
            throw new AdldapException($exLdap->getMessage());
        }
    }
    public function getDataADUsers(){
        try {
            //TODO insert paramMail into find when server is migrated
            if ($adUsers = (new Adldap(self::LDAPCFG))->users()->all(['mail','name'])) {
                $arrayMails = array();
                //$arrayNames = array();
                foreach ($adUsers as $adUser){
                    array_push($arrayMails,$adUser['attributes']['mail']);
                   // array_push($arrayNames,$adUser['attributes']['name']);
                }
                return $arrayMails;
            } else {
                throw new AdldapException("Benutzer nicht im Active Directory vorhanden.");
            }
        }
        catch(AdldapException $exLdap) {
            throw new AdldapException($exLdap->getMessage());
        }
    }
}
?>