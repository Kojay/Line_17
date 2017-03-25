<?php

namespace app\models;

use Adldap\Adldap;
use Adldap\Exceptions\AdldapException;
use yii\base\Model;
use yii\base\Exception;
use yii\helpers\ArrayHelper;


/**
 * Ldap class for AD-Connection
 * @author Alexander Weinbeck
 *
 */
class ldap extends Model
{
    //389 ldap port default
    //TODO: config array needs to be updated with all domain controllers!

    //Timeout
    public $counterTimeout = 50;

    public $LDAPCFGEDU = [
        'domain_controllers' => ['edu.ds.fhnw.ch'],
        'base_dn' => 'ou=edu, ou=prod, dc=edu, dc=ds, dc=fhnw, dc=ch', // ou=edu,ou=prod,dc=edu,
        'admin_username' => 'u_18.39_lagerverwaltung02',
        'admin_password' => 'FHNW@2016',
        'follow_referrals' => true,
        'use_ssl' => false,
        'use_tls' => false,
        'use_sso' => false,
    ];

    public $LDAPCFGADM = [
        'domain_controllers' => ['adm.ds.fhnw.ch'],
        'base_dn' => 'ou=adm, ou=prod, dc=adm, dc=ds, dc=fhnw, dc=ch',
        'admin_username' => 'u_18.39_lagerverwaltung02',
        'admin_password' => 'FHNW@2016',
        'follow_referrals' => true,
        'use_ssl' => false,
        'use_tls' => false,
        'use_sso' => false,
    ];

    public function getAuthentication($username, $password){
        //establish AD connection
        if((new Adldap($this->LDAPCFGEDU))->authenticate($username, $password)){
            // User passed authentication
            return true;
        }
        elseif((new Adldap($this->LDAPCFGADM))->authenticate($username, $password)){
            // Username or password is incorrect
            return true;
        }else{
            return false;
        }
    }
    public function getDataLoan($paramMail){
        try {
            if ($adUser = (new Adldap($this->LDAPCFGEDU))->users()->search()->find($paramMail)) {
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
    public function getDataADUser($paramMail,$paramUserID)
    {
        $adEDU = (new Adldap($this->LDAPCFGEDU));
        $adADM = (new Adldap($this->LDAPCFGADM));
        //$filter = '(&(objectCategory=user)(mail=*'.$paramMail.'*))';
        //$adUserEDU = $adEDU->search()->newQueryBuilder()->rawFilter($filter)->paginate('1')->getResults();

        $adUserEDU = $adEDU->users()->search()->findBy('mail',$paramMail);
        $adUserADM = $adADM->users()->search()->findBy('mail',$paramMail);
        //TODO insert paramMail into find when server is migrated
        if ($adUserEDU != NULL) {
            return [
                'name' => ArrayHelper::getValue($adUserEDU->name,0,'N/A'),
                'department' => ArrayHelper::getValue($adUserEDU->department,0,'N/A'),
                'title' => ArrayHelper::getValue($adUserEDU->title,0,'N/A'),
                'company' => ArrayHelper::getValue($adUserEDU->company,0,'N/A'),
                'mail' => $paramMail,
                'userID' => $paramUserID
            ];
        }
        elseif ($adUserADM != NULL){
            return [
                'name' => ArrayHelper::getValue($adUserADM->name,0,'N/A'),
                'department' => ArrayHelper::getValue($adUserADM->department,0,'N/A'),
                'title' => ArrayHelper::getValue($adUserADM->title,0,'N/A'),
                'company' => ArrayHelper::getValue($adUserADM->company,0,'N/A'),
                'mail' => $paramMail,
                'userID' => $paramUserID
            ];
        }
        else {
            throw new AdldapException("Benutzer nicht im Active Directory vorhanden.");
        }
    }
    public function getDataADUsers(){
        ini_set('memory_limit', '4096M');

        //(displayName=*)
        //$filter = '(&(objectCategory=person)(objectClass=user)(mail=*gmx*))';
        $filter = '(&(objectCategory=user)(mail=alex*))';

        $adADM = (new Adldap($this->LDAPCFGADM));
        $adEDU = (new Adldap($this->LDAPCFGEDU));
        $adUsersADM = $adADM->search()->newQueryBuilder()->rawFilter($filter)->paginate('1000')->getResults();
        $adUsersEDU = $adEDU->search()->newQueryBuilder()->rawFilter($filter)->paginate('1000')->getResults();

        $arrayMails = array();
        //$arrayNames = array();

        foreach ($adUsersADM as $adUser) {
            if (isset($adUser['mail']['0'])) {
                array_push($arrayMails,ArrayHelper::getValue($adUser['mail'],0));
                // array_push($arrayNames,$adUser['attributes']['name']);
            }
        }
        foreach ($adUsersEDU as $adUser) {
            if (isset($adUser['mail']['0'])) {
                array_push($arrayMails,ArrayHelper::getValue($adUser['mail'],0));
                // array_push($arrayNames,$adUser['attributes']['name']);
            }
        }
        return $arrayMails;
    }
}
?>