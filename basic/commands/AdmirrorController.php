<?php
/**
 * Created by PhpStorm.
 * User: kwlski
 * Date: 23.03.2017
 * Time: 23:25
 */

namespace app\commands;

use yii;
use Adldap\Adldap;
use app\models\ldap;
use yii\db\Query;
use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\ArrayHelper;

/**
 * This class is an executable script on command line.
 * It is stored in file "mirrorAD.sh" in folder "basic"
 * to execute it type following: "sudo sh ./mirrorAD.sh"
 * @author Alexander Weinbeck
 * @version 0.10
 * @return progress and information of AD and SQL usage and progress.
 */
class AdmirrorController extends Controller
{
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

    /**
     * This is the function executed by command line
     * 1. It gets all mails from the FHNW institutes
     * 2. It collects the users mails
     * 3. It writes in a DB transaction everythin to lv_ad,
     * while doing that its making a copy to keep locktime as low as possible
     * @author Alexander Weinbeck
     * @return Success,failure
     * @throws \Throwable
     * @throws yii\base\Exception
     */
    public function actionMirror()
    {
        echo "INFO: Database update from Active Directory \n";
        echo "INFO: Estimated processingtime is 30 seconds\n\n";
        echo "INFO: Starting Process...\n\n";
        Console::startProgress(0, 1000);

        //expand memory if needed:
        //ini_set('memory_limit', '4096M');
        //Useful filters: $filter = '(&(objectCategory=person)(objectClass=user)(mail=*gmx*))'; (displayName=*)
        //$filter = '(&(objectCategory=user)(mail=*))';
        //94076(uidnumber=94076)(displayName=*)(mail=*)

        $filter = '(&(objectCategory=user)(objectCategory=person))';
        echo "PROGRESS: Establishing AD-Connections...\n";
        Console::startProgress(100, 1000);
        $adADM = (new \Adldap\Adldap($this->LDAPCFGADM));
        $adEDU = (new \Adldap\Adldap($this->LDAPCFGEDU));
        echo "PROGRESS: Getting actual Users ADM Server...\n";
        $adUsersADM = $adADM->search()->newQueryBuilder()->rawFilter($filter)->paginate('1000')->getResults();
        Console::startProgress(200, 1000);
        echo "PROGRESS: Getting actual Users EDU Server...\n";
        $adUsersEDU = $adEDU->search()->newQueryBuilder()->rawFilter($filter)->paginate('1000')->getResults();
        echo "PROGRESS: Sort and filter Users...\n";
        Console::updateProgress(700, 1000);
        /*
        foreach ($adUsersADM as $adUser) {
            if ($adUser['mail']['0'] != NULL) {
                array_push($arrayMails,ArrayHelper::getValue($adUser['mail'],0));
                array_push($arrayAccountIDs,ArrayHelper::getValue($adUser['uidnumber'],0));
            }
        }
        foreach ($adUsersEDU as $adUser) {
            if ($adUser['mail']['0'] != NULL) {
                array_push($arrayMails,ArrayHelper::getValue($adUser['mail'],0));
                array_push($arrayAccountIDs,ArrayHelper::getValue($adUser['uidnumber'],0));
            }
        }*/
        echo "PROGRESS: Saving fetched Users in Database...\n";
        $entriesCount = 0;
        Console::updateProgress(800, 1000);
        $querySwapName1     = "RENAME TABLE lv_ad TO lv_ad_old,lv_ad_new to lv_ad";
        $querySwapName2     = "RENAME TABLE lv_ad_old TO lv_ad_new";
        //$queryDelTableOld   = "DELETE FROM lv_ad_new";
        //$queryResetAutoInc  = "ALTER TABLE lv_ad_new AUTO_INCREMENT = 0";
        $connection = yii::$app->db;
        $transaction = $connection->beginTransaction("SERIALIZABLE");
        try {
            foreach ($adUsersADM as $adUser) {
                if ($adUser['mail']['0'] != NULL) {
                    $tmpMail = $connection->quoteValue(ArrayHelper::getValue($adUser['mail'], 0, ''));
                    $tmpCompany = $connection->quoteValue(ArrayHelper::getValue($adUser['company'], 0, ''));
                    $tmpDepartment = $connection->quoteValue(ArrayHelper::getValue($adUser['department'], 0, ''));
                    $tmpDisplayName = $connection->quoteValue(ArrayHelper::getValue($adUser['displayname'], 0, ''));
                    $tmpObjectGUID = $connection->quoteValue(ArrayHelper::getValue($adUser['objectguid'], 0, ''));
                    $tmpSurname = $connection->quoteValue(ArrayHelper::getValue($adUser['sn'], 0, ''));
                    $tmpPrename = $connection->quoteValue(ArrayHelper::getValue($adUser['givenname'], 0, ''));
                    $tmpDivision = $connection->quoteValue(ArrayHelper::getValue($adUser['division'], 0, ''));
                    $tmpPhysicaldeliveryofficename = $connection->quoteValue(ArrayHelper::getValue($adUser['physicaldeliveryofficename'], 0, ''));
                    $tmpMobile = $connection->quoteValue(ArrayHelper::getValue($adUser['mobile'], 0, ''));
                    $tmpPersonaltitle = $connection->quoteValue(ArrayHelper::getValue($adUser['personaltitle'], 0, ''));

                    $queryInsert1 =
                        "INSERT INTO lv_ad_new (GUID,mail,department,displayname,company,surname,prename,division,mobile,personaltitle,physicaldeliveryofficename)
                         VALUES ($tmpObjectGUID,$tmpMail,$tmpDepartment,$tmpDisplayName,$tmpCompany,$tmpSurname,$tmpPrename,$tmpDivision,$tmpMobile,$tmpPersonaltitle,$tmpPhysicaldeliveryofficename)
                         ON DUPLICATE KEY UPDATE
                              GUID           =              VALUES(GUID),
                              mail           =              VALUES(mail),
                              department     =              VALUES(department),
                              displayname    =              VALUES(displayname),
                              company        =              VALUES(company),
                              surname        =              VALUES(surname),
                              prename        =              VALUES(prename),
                              mobile         =              VALUES(mobile),
                              personaltitle  =              VALUES(personaltitle),
                              division       =              VALUES(division),
                              physicaldeliveryofficename =  VALUES(physicaldeliveryofficename)";

                    $connection->createCommand($queryInsert1)->execute();
                    $entriesCount++;
                }
            }
            foreach ($adUsersEDU as $adUser) {
                if ($adUser['mail']['0'] != NULL) {
                    $tmpMail = $connection->quoteValue(ArrayHelper::getValue($adUser['mail'], 0, ''));
                    $tmpCompany = $connection->quoteValue(ArrayHelper::getValue($adUser['company'], 0, ''));
                    $tmpDepartment = $connection->quoteValue(ArrayHelper::getValue($adUser['department'], 0, ''));
                    $tmpDisplayName = $connection->quoteValue(ArrayHelper::getValue($adUser['displayname'], 0, ''));
                    $tmpObjectGUID = $connection->quoteValue(ArrayHelper::getValue($adUser['objectguid'], 0, ''));
                    $tmpSurname = $connection->quoteValue(ArrayHelper::getValue($adUser['sn'], 0, ''));
                    $tmpPrename = $connection->quoteValue(ArrayHelper::getValue($adUser['givenname'], 0, ''));
                    $tmpDivision = $connection->quoteValue(ArrayHelper::getValue($adUser['division'], 0, ''));
                    $tmpPhysicaldeliveryofficename = $connection->quoteValue(ArrayHelper::getValue($adUser['physicaldeliveryofficename'], 0, ''));
                    $tmpMobile = $connection->quoteValue(ArrayHelper::getValue($adUser['mobile'], 0, ''));
                    $tmpPersonaltitle = $connection->quoteValue(ArrayHelper::getValue($adUser['personaltitle'], 0, ''));

                    $queryInsert1 =
                        "INSERT INTO lv_ad_new (GUID,mail,department,displayname,company,surname,prename,division,mobile,personaltitle,physicaldeliveryofficename)
                         VALUES ($tmpObjectGUID,$tmpMail,$tmpDepartment,$tmpDisplayName,$tmpCompany,$tmpSurname,$tmpPrename,$tmpDivision,$tmpMobile,$tmpPersonaltitle,$tmpPhysicaldeliveryofficename)
                         ON DUPLICATE KEY UPDATE
                              GUID           =              VALUES(GUID),
                              mail           =              VALUES(mail),
                              department     =              VALUES(department),
                              displayname    =              VALUES(displayname),
                              company        =              VALUES(company),
                              surname        =              VALUES(surname),
                              prename        =              VALUES(prename),
                              mobile         =              VALUES(mobile),
                              personaltitle  =              VALUES(personaltitle),
                              division       =              VALUES(division),
                              physicaldeliveryofficename =  VALUES(physicaldeliveryofficename)";

                    $connection->createCommand($queryInsert1)->execute();
                    $entriesCount++;
                }
            }

            $connection->createCommand($querySwapName1)->execute();
            $connection->createCommand($querySwapName2)->execute();

            foreach ($adUsersADM as $adUser) {
                if ($adUser['mail']['0'] != NULL) {
                    $tmpMail = $connection->quoteValue(ArrayHelper::getValue($adUser['mail'], 0, ''));
                    $tmpCompany = $connection->quoteValue(ArrayHelper::getValue($adUser['company'], 0, ''));
                    $tmpDepartment = $connection->quoteValue(ArrayHelper::getValue($adUser['department'], 0, ''));
                    $tmpDisplayName = $connection->quoteValue(ArrayHelper::getValue($adUser['displayname'], 0, ''));
                    $tmpObjectGUID = $connection->quoteValue(ArrayHelper::getValue($adUser['objectguid'], 0, ''));
                    $tmpSurname = $connection->quoteValue(ArrayHelper::getValue($adUser['sn'], 0, ''));
                    $tmpPrename = $connection->quoteValue(ArrayHelper::getValue($adUser['givenname'], 0, ''));
                    $tmpDivision = $connection->quoteValue(ArrayHelper::getValue($adUser['division'], 0, ''));
                    $tmpPhysicaldeliveryofficename = $connection->quoteValue(ArrayHelper::getValue($adUser['physicaldeliveryofficename'], 0, ''));
                    $tmpMobile = $connection->quoteValue(ArrayHelper::getValue($adUser['mobile'], 0, ''));
                    $tmpPersonaltitle = $connection->quoteValue(ArrayHelper::getValue($adUser['personaltitle'], 0, ''));

                    $queryInsert1 =
                        "INSERT INTO lv_ad_new (GUID,mail,department,displayname,company,surname,prename,division,mobile,personaltitle,physicaldeliveryofficename)
                         VALUES ($tmpObjectGUID,$tmpMail,$tmpDepartment,$tmpDisplayName,$tmpCompany,$tmpSurname,$tmpPrename,$tmpDivision,$tmpMobile,$tmpPersonaltitle,$tmpPhysicaldeliveryofficename)
                         ON DUPLICATE KEY UPDATE
                              GUID           =              VALUES(GUID),
                              mail           =              VALUES(mail),
                              department     =              VALUES(department),
                              displayname    =              VALUES(displayname),
                              company        =              VALUES(company),
                              surname        =              VALUES(surname),
                              prename        =              VALUES(prename),
                              mobile         =              VALUES(mobile),
                              personaltitle  =              VALUES(personaltitle),
                              division       =              VALUES(division),
                              physicaldeliveryofficename =  VALUES(physicaldeliveryofficename)";

                    $connection->createCommand($queryInsert1)->execute();
                    $entriesCount++;
                }
            }
            foreach ($adUsersEDU as $adUser) {
                if ($adUser['mail']['0'] != NULL) {
                    $tmpMail = $connection->quoteValue(ArrayHelper::getValue($adUser['mail'], 0, ''));
                    $tmpCompany = $connection->quoteValue(ArrayHelper::getValue($adUser['company'], 0, ''));
                    $tmpDepartment = $connection->quoteValue(ArrayHelper::getValue($adUser['department'], 0, ''));
                    $tmpDisplayName = $connection->quoteValue(ArrayHelper::getValue($adUser['displayname'], 0, ''));
                    $tmpObjectGUID = $connection->quoteValue(ArrayHelper::getValue($adUser['objectguid'], 0, ''));
                    $tmpSurname = $connection->quoteValue(ArrayHelper::getValue($adUser['sn'], 0, ''));
                    $tmpPrename = $connection->quoteValue(ArrayHelper::getValue($adUser['givenname'], 0, ''));
                    $tmpDivision = $connection->quoteValue(ArrayHelper::getValue($adUser['division'], 0, ''));
                    $tmpPhysicaldeliveryofficename = $connection->quoteValue(ArrayHelper::getValue($adUser['physicaldeliveryofficename'], 0, ''));
                    $tmpMobile = $connection->quoteValue(ArrayHelper::getValue($adUser['mobile'], 0, ''));
                    $tmpPersonaltitle = $connection->quoteValue(ArrayHelper::getValue($adUser['personaltitle'], 0, ''));

                    $queryInsert1 =
                        "INSERT INTO lv_ad_new (GUID,mail,department,displayname,company,surname,prename,division,mobile,personaltitle,physicaldeliveryofficename)
                         VALUES ($tmpObjectGUID,$tmpMail,$tmpDepartment,$tmpDisplayName,$tmpCompany,$tmpSurname,$tmpPrename,$tmpDivision,$tmpMobile,$tmpPersonaltitle,$tmpPhysicaldeliveryofficename)
                         ON DUPLICATE KEY UPDATE
                              GUID           =              VALUES(GUID),
                              mail           =              VALUES(mail),
                              department     =              VALUES(department),
                              displayname    =              VALUES(displayname),
                              company        =              VALUES(company),
                              surname        =              VALUES(surname),
                              prename        =              VALUES(prename),
                              mobile         =              VALUES(mobile),
                              personaltitle  =              VALUES(personaltitle),
                              division       =              VALUES(division),
                              physicaldeliveryofficename =  VALUES(physicaldeliveryofficename)";

                    $connection->createCommand($queryInsert1)->execute();
                    $entriesCount++;
                }
            }
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
        //echo var_dump($arrayAccountIDs);
        $queryCtr = $entriesCount+4;
        $entriesCount = $entriesCount/2;
        $msg = $this->stdout("PROGRESS: DONE! $entriesCount entries -> $queryCtr queries executed -> No Errors\n",Console::BOLD, Console::FG_BLACK, Console::BG_GREEN);
        Console::updateProgress(1000, 1000);
        Console::endProgress();
        echo $msg;
    }
}