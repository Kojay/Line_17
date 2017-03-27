<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * ADRqst is the interface to the Database Table lv_ad, which represents offline active directory
 * @author Alexander Weinbeck
 * @version 1.0
 * @param data to set to DB
 * @return data to get from DB
 */
class ADRqst extends Model
{
    public function getDataADUserMailsArray()
    {
        $dataProvider = new SqlDataProvider([
            'sql' => "SELECT ad.GUID,ad.mail FROM lv_ad AS ad"
        ]);
        return ArrayHelper::map($dataProvider->getModels(), 'GUID', 'mail');
    }
    public function getDataADUserGUIDs()
    {
        $dataProvider = new SqlDataProvider([
            'sql' => "SELECT ad.GUID FROM lv_ad AS ad"
        ]);
        return ArrayHelper::getColumn($dataProvider->getModels(), 'GUID');
    }
    public function getDataADUserMails()
    {
        try {
            $transaction = Yii::$app->db->beginTransaction();
            $dataProvider = new SqlDataProvider([
                'sql' => "SELECT ad.mail FROM lv_ad AS ad",
                'pagination' => [
                    'pageSize' => 999999999,
                ],

            ]);
            $transaction->commit();
        } catch(Exception $e){
            $transaction->rollBack();
            throw new \yii\db\Exception($e->getMessage());
        }

        return ArrayHelper::getColumn($dataProvider->getModels(),'mail');
    }
}