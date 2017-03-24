<?php
/**
 * Created by PhpStorm.
 * User: kwlski
 * Date: 23.03.2017
 * Time: 23:25
 */

namespace app\commands;

use Adldap\Adldap;
use app\models\ldap;
use yii;
use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\ArrayHelper;


class AdmirrorController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
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

    public function actionMirror()
    {
        echo "Info: Database update from Active Directory... \n \n \n";

        //ini_set('memory_limit', '4096M');
        $arrayMails = array();
        //(displayName=*)
        //$filter = '(&(objectCategory=person)(objectClass=user)(mail=*gmx*))';
        $filter = '(&(objectCategory=user)(mail=alex*))';

        $adADM = (new \Adldap\Adldap($this->LDAPCFGADM));
        $adEDU = (new \Adldap\Adldap($this->LDAPCFGEDU));
        $adUsersADM = $adADM->search()->newQueryBuilder()->rawFilter($filter)->paginate('1000')->getResults();
        $adUsersEDU = $adEDU->search()->newQueryBuilder()->rawFilter($filter)->paginate('1000')->getResults();


        //$arrayNames = array();

        foreach ($adUsersADM as $adUser) {
            if (array_key_exists($adUser['mail']['0'])) {
                array_push($arrayMails,ArrayHelper::getValue($adUser['mail'],0));
                // array_push($arrayNames,$adUser['attributes']['name']);
            }
        }
        foreach ($adUsersEDU as $adUser) {
            if (array_key_exists($adUser['mail']['0'])) {
                array_push($arrayMails,ArrayHelper::getValue($adUser['mail'],0));
                // array_push($arrayNames,$adUser['attributes']['name']);
            }
        }

        $yolo = $this->stdout("Vorgang abgeschlossen\n", Console::BOLD, Console::FG_RED);

        //$arrayMails = (new ldap())->getDataADUsers();

        $arr_length = sizeof($arrayMails);
        $idy = "TESTVALUE";
        for ($ctr = 0;$ctr < $arr_length;$ctr++){

            //yii::$app->db->createCommand()->insert("lv_ad","mail")->bindValue("jk")->execute();
        }
        $query = 'INSERT INTO lv_ad (mail) VALUES ("'.$idy.'")';
        yii::$app->db->createCommand($query)->execute();
        echo var_dump($arrayMails);
        echo "$yolo\n";
        echo "$arr_length\n";
//        Console::startProgress(0, 1000);
//        for ($n = 1; $n <= 1000; $n++) {
//            usleep(1000);
//            Console::updateProgress($n, 1000);
//            Console::updateProgress($n, 1000);
//        }
//        Console::endProgress();

//        $tmp = VarDumper::dumpAsString(ArrayHelper::getValue($arrayMails,'0'),10);
//        $yolo2 = $this->stdout("$tmp\n", Console::BG_PURPLE, Console::FG_BLUE);

    }

}