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
use yii\db\Query;
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
        echo "INFO: Database update from Active Directory \n";
        echo "INFO: Estimated processingtime is 30 seconds\n\n";
        echo "INFO: Starting Process...\n\n";
        Console::startProgress(0, 1000);
        //ini_set('memory_limit', '4096M');
        $arrayMails = array();
        //(displayName=*)
        //$filter = '(&(objectCategory=person)(objectClass=user)(mail=*gmx*))';
        $filter = '(&(objectCategory=user)(mail=alex*))';
        echo "PROGRESS: Establishing AD-Connections...\n";
        Console::startProgress(100, 1000);
        $adADM = (new \Adldap\Adldap($this->LDAPCFGADM));
        $adEDU = (new \Adldap\Adldap($this->LDAPCFGEDU));
        echo "PROGRESS: Getting actual Users...\n";
        $adUsersADM = $adADM->search()->newQueryBuilder()->rawFilter($filter)->paginate('1000')->getResults();
        $adUsersEDU = $adEDU->search()->newQueryBuilder()->rawFilter($filter)->paginate('1000')->getResults();
        echo "PROGRESS: Sort and filter Users...\n";
        Console::updateProgress(600, 1000);
        foreach ($adUsersADM as $adUser) {
            if ($adUser['mail']['0']  != NULL) {
                array_push($arrayMails,ArrayHelper::getValue($adUser['mail'],0));
                // array_push($arrayNames,$adUser['attributes']['name']);
            }
        }
        foreach ($adUsersEDU as $adUser) {
            if ($adUser['mail']['0'] != NULL) {
                array_push($arrayMails,ArrayHelper::getValue($adUser['mail'],0));
                // array_push($arrayNames,$adUser['attributes']['name']);
            }
        }
        echo "PROGRESS: Saving fetched Users in Database...\n";


        Console::updateProgress(800, 1000);
        $querySwapName1     = "RENAME TABLE lv_ad TO lv_ad_old,lv_ad_new to lv_ad";
        $querySwapName2     = "RENAME TABLE lv_ad_old TO lv_ad_new";
        $queryDelTableOld   = "DELETE FROM lv_ad_new";
        $queryResetAutoInc  = "ALTER TABLE lv_ad_new AUTO_INCREMENT = 0";
        $connection = yii::$app->db;
        $transaction = $connection->beginTransaction("SERIALIZABLE");
        try {
            foreach ($arrayMails as $mail) {
                $query = 'INSERT INTO lv_ad_new (mail) VALUES ("'.$mail.'")';
                $connection->createCommand($query)->execute();
            }
            $connection->createCommand($querySwapName1)->execute();
            $connection->createCommand($querySwapName2)->execute();
            $connection->createCommand($queryDelTableOld)->execute();
            $connection->createCommand($queryResetAutoInc)->execute();
            $transaction->commit();
        }
        catch (yii\base\Exception $e) {
            $transaction->rollBack();
            throw $e;
            echo "ERROR: A problem occurred: ".$e->getMessage()."\n";
            return 1;
        }
        catch (\Throwable $e) {
            $transaction->rollBack();
            echo "ERROR: A problem occurred: ".$e->getMessage()."\n";
            throw $e;
            return 1;
        }

        //$yolo = $this->stdout("Vorgang abgeschlossen\n", Console::BOLD, Console::FG_RED);

        //$arrayMails = (new ldap())->getDataADUsers();

        $arr_length = sizeof($arrayMails);

        //echo var_dump($arrayMails);
        //echo "$yolo\n";
        //echo "$arr_length\n";
        echo "PROGRESS: DONE! No Errors\n";
        Console::updateProgress(1000, 1000);
        Console::endProgress();
//        $tmp = VarDumper::dumpAsString(ArrayHelper::getValue($arrayMails,'0'),10);
//        $yolo2 = $this->stdout("$tmp\n", Console::BG_PURPLE, Console::FG_BLUE);

    }

}