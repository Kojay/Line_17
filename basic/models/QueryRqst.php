<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * ContactForm is the model behind the contact form.
 */
class QueryRqst extends Model
{
    private $dataProvider;

    public function getData()
    {
        Yii::$app->db->createCommand('SELECT SQL_CALC_FOUND_ROWS * FROM {{%lv_article}} LIMIT 1')->queryScalar();
        $totalCount = Yii::$app->db->createCommand('SELECT FOUND_ROWS()')->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT articletype.articleTypeName, articleproducer.articleproducerName, article.articleName, article.fhnwNumber, loanitems.lvLoanReturnDate' .
                ' FROM lv_loanitems AS loanitems' .
                ' LEFT JOIN lv_article AS article ON loanitems.lv_article_deviceID = article.articleID' .
                ' LEFT JOIN lv_articletype AS articletype ON article.lv_articletype_articleTypeID = articletype.articleTypeID' .
                ' LEFT JOIN lv_articleproducer AS articleproducer ON article.lv_producer_producerID = articleproducer.articleproducerID' .
                ' GROUP BY article.fhnwNumber',

            'pagination' => [
                'pageSize' => 10,
            ],
            'totalCount' => $totalCount,


            'sort' => [

                'attributes' => [
                    'articleTypeName' => [
                        'asc' => ['articleTypeName' => SORT_ASC],
                        'desc' => ['articleTypeName' => SORT_DESC],
                        //'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'articleproducerName' => [
                        'asc' => ['articleproducerName' => SORT_ASC],
                        'desc' => ['articleproducerName' => SORT_DESC],
                        //'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'articleName' => [
                        'asc' => ['articleName' => SORT_ASC],
                        'desc' => ['articleName' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'fhnwNumber' => [
                        'asc' => ['fhnwNumber' => SORT_ASC],
                        'desc' => ['fhnwNumber' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'lvLoanReturnDate' => [
                        'asc' => ['lvLoanReturnDate' => SORT_ASC],
                        'desc' => ['lvLoanReturnDate' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'created_on'
                ],

            ],
        ]);
        //return $dataProvider;

        //return JSON Obj over Ajax
        return $dataProvider;
    }

    public function getDataAllfaelligeAusleihungen()
    {
        $dataProvider = new SqlDataProvider([
            //'sql' => 'SELECT * FROM lv_loanitems WHERE lvLoanReturnDate >= CURDATE()',
            'sql' => 'SELECT persons.personFirstname, persons.personLastname, loanitems.lvLoanReturnDate, loanprofile.loanLocation, article.articleName' .
                ' FROM lv_loanprofile AS loanprofile' .
                ' LEFT JOIN lv_persons AS persons ON loanprofile.loanPerson = persons.personsID' .
                ' LEFT JOIN lv_loanitems AS loanitems ON loanprofile.loanID = loanitems.lv_loan_loanID' .
                ' LEFT JOIN lv_article AS article ON loanitems.lv_article_deviceID = article.articleID' .
                ' WHERE loanitems.lvLoanReturnDate >= CURDATE() GROUP BY loanprofile.loanID;',

            'sort' => [
                'attributes' => [
                    'personFirstname' => [
                        'asc' => ['personFirstname' => SORT_ASC],
                        'desc' => ['personFirstname' => SORT_DESC],
                        //'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'personLastname' => [
                        'asc' => ['personLastname' => SORT_ASC],
                        'desc' => ['personLastname' => SORT_DESC],
                        //'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'loanLocation' => [
                        'asc' => ['loanLocation' => SORT_ASC],
                        'desc' => ['loanLocation' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'articleName' => [
                        'asc' => ['articleName' => SORT_ASC],
                        'desc' => ['articleName' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'lvLoanReturnDate' => [
                        'asc' => ['lvLoanReturnDate' => SORT_ASC],
                        'desc' => ['lvLoanReturnDate' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'created_on'
                ],
            ],
        ]);
        return $dataProvider;
    }

    public function getDataArtikellisteBearbeiten($paramFindRow)
    {
        $dataProvider = new SqlDataProvider([
            //'sql' => 'SELECT * FROM lv_loanitems WHERE lvLoanReturnDate >= CURDATE()',
            'sql' => 'SELECT article.articleName, article.fhnwNumber, article.serialNumber, article.articlePrice, article.articleDescription, articletype.articleTypeName, producer.articleproducerName' .
                ' FROM lv_loanprofile AS loanprofile' .
                ' LEFT JOIN lv_articleproducer AS producer ON producer.articleproducerID = article.articleID' .
                ' LEFT JOIN lv_articletype AS articletype ON articletype.articleID = articletype.articleTypeID' .
                ' LEFT JOIN lv_article AS article ON loanitems.lv_article_deviceID = article.articleID' .
                ' WHERE ' + $paramFindRow + ' GROUP BY article.articleID;',

            'sort' => [
                'attributes' => [
                    'personFirstname' => [
                        'asc' => ['personFirstname' => SORT_ASC],
                        'desc' => ['personFirstname' => SORT_DESC],
                        //'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'personLastname' => [
                        'asc' => ['personLastname' => SORT_ASC],
                        'desc' => ['personLastname' => SORT_DESC],
                        //'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'loanLocation' => [
                        'asc' => ['loanLocation' => SORT_ASC],
                        'desc' => ['loanLocation' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'articleName' => [
                        'asc' => ['articleName' => SORT_ASC],
                        'desc' => ['articleName' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'lvLoanReturnDate' => [
                        'asc' => ['lvLoanReturnDate' => SORT_ASC],
                        'desc' => ['lvLoanReturnDate' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'lvLoanReturnDate' => [
                        'asc' => ['lvLoanReturnDate' => SORT_ASC],
                        'desc' => ['lvLoanReturnDate' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'lvLoanReturnDate' => [
                        'asc' => ['lvLoanReturnDate' => SORT_ASC],
                        'desc' => ['lvLoanReturnDate' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],

                    'created_on'
                ],
            ],
            'pagination' => [
                'pagesize' => 80,
            ],

        ]);
        return $dataProvider;
    }

    public function getDataArtikel($fhnwNumber)
    {
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT article.articleName, articletype.articleTypeName, ' .
                'articleproducer.articleproducerName, article.serialNumber, ' .
                'article.dateBought, article.dateWarranty, article.articlePrice, ' .
                'article.fhnwNumber, article.articleDescription' .
                ' FROM lv_loanitems AS loanitems' .
                ' LEFT JOIN lv_article AS article ON loanitems.lv_article_deviceID = article.articleID' .
                ' LEFT JOIN lv_articletype AS articletype ON article.lv_articletype_articleTypeID = articletype.articleTypeID' .
                ' LEFT JOIN lv_articleproducer AS articleproducer ON article.lv_producer_producerID = articleproducer.articleproducerID' .
                ' WHERE article.fhnwNumber = "' . $fhnwNumber . '" GROUP BY article.fhnwNumber',

            'sort' => [
                'attributes' => [
                    'articleTypeName' => [
                        'asc' => ['articleTypeName' => SORT_ASC],
                        'desc' => ['articleTypeName' => SORT_DESC],
                        //'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'articleproducerName' => [
                        'asc' => ['articleproducerName' => SORT_ASC],
                        'desc' => ['articleproducerName' => SORT_DESC],
                        //'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'articleName' => [
                        'asc' => ['articleName' => SORT_ASC],
                        'desc' => ['articleName' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'fhnwNumber' => [
                        'asc' => ['fhnwNumber' => SORT_ASC],
                        'desc' => ['fhnwNumber' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'serialNumber' => [
                        'asc' => ['articleserialNumber' => SORT_ASC],
                        'desc' => ['articleserialNumber' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'articlePrice' => [
                        'asc' => ['articlePrice' => SORT_ASC],
                        'desc' => ['articlePrice' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'dateBought' => [
                        'asc' => ['dateBought' => SORT_ASC],
                        'desc' => ['dateBought' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'dateWarranty' => [
                        'asc' => ['dateWarranty' => SORT_ASC],
                        'desc' => ['dateWarranty' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'articleDescription' => [
                        'asc' => ['articleDescription' => SORT_ASC],
                        'desc' => ['articleDescription' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],

                    'created_on'
                ],
            ],
        ]);

        return ArrayHelper::getValue($dataProvider->getModels(), 0);
        //ArrayHelper::map($dataProvider->getModels(), 'articleName', 'articleTypeName', 'class') TODO: Evaluate if this is a better data processing method
    }

    public function setDataArtikel($paramArticleData)
    {

        $query = 'UPDATE  lv_article article, lv_articletype articletype, lv_articleproducer articleproducer 
                        
                SET     article.articleName="' . $paramArticleData['articleName'] . '",
                        article.serialNumber="' . $paramArticleData1['serialNumber'] . '",
                        article.dateBought="' . $paramArticleData['dateBought'] . '",
                        article.dateWarranty="' . $paramArticleData['dateWarranty'] . '",
                        article.articlePrice="' . $paramArticleData['articlePrice'] . '",
                        article.fhnwNumber="' . $paramArticleData['fhnwNumber'] . '",
                        article.articleDescription="' . $paramArticleData['articleDescription'] . '",
                        articletype.articleTypeName="' . $paramArticleData['articleTypeName'] . '", 
                        articleproducer.articleproducerName="' . $paramArticleData['articleproducerName'] . '" 
                            
                WHERE   article.fhnwNumber="' . $paramArticleData['fhnwNumber'] . '" AND
                        article.lv_articletype_articleTypeID=articletype.articleTypeID AND
                        article.lv_producer_producerID=articleproducer.articleproducerID';

        Yii::$app->db->createCommand($query)->execute();
    }

    public function createDataArtikel($paramArticleData)
    {
        $preConditionSQL = 'SET FOREIGN_KEY_CHECKS=0';
        $query1 = ' 

                    INSERT INTO     lv_article (articleName, fhnwNumber, serialNumber, articlePrice, dateBought, dateWarranty, articleDescription, lv_producer_producerID, lv_articletype_articleTypeID)

                    VALUES         (
                                   "' . $paramArticleData['articleName'] . '"," '
            . $paramArticleData['fhnwNumber'] . '"," '
            . $paramArticleData['serialNumber'] . '"," '
            . $paramArticleData['articlePrice'] . '"," '
            . $paramArticleData['dateBought'] . '"," '
            . $paramArticleData['dateWarranty'] . '"," '
            . $paramArticleData['articleDescription'] . '", 
                                    (SELECT AUTO_INCREMENT
                                        FROM INFORMATION_SCHEMA.TABLES
                                        WHERE TABLE_NAME="lv_article"),
                                    (SELECT AUTO_INCREMENT
                                        FROM INFORMATION_SCHEMA.TABLES
                                        WHERE TABLE_NAME="lv_article")                                
                                    );';
        $query2 = '    
                    INSERT INTO     lv_articletype (articleTypeName)

                    VALUES         ("' . $paramArticleData['articleTypeName'] . '");';
        $query3 = '         
                    INSERT INTO     lv_articleproducer (articleproducerName)

                    VALUES         ("' . $paramArticleData['articleproducerName'] . '");';
        $query4 = '         
                    INSERT INTO     lv_loanitems (lv_article_deviceID)

                    VALUES         ((SELECT AUTO_INCREMENT
                                        FROM INFORMATION_SCHEMA.TABLES
                                        WHERE TABLE_NAME="lv_article"));';

        $postConditionSQL = 'SET FOREIGN_KEY_CHECKS=1';

        $transaction = Yii::$app->db->beginTransaction();
        Yii::$app->db->createCommand($preConditionSQL)->execute();
        Yii::$app->db->createCommand($query1)->execute();
        Yii::$app->db->createCommand($query2)->execute();
        Yii::$app->db->createCommand($query3)->execute();
        Yii::$app->db->createCommand($query4)->execute();
        Yii::$app->db->createCommand($postConditionSQL)->execute();
        $transaction->commit();
    }

    public function deleteDataArtikel($paramArticleData)
    {
        //$preConditionSQL = 'SET FOREIGN_KEY_CHECKS=0';

        $qry1 = 'DELETE article, articletype, articleproducer, loanitems ' .
            'FROM lv_loanItems AS loanitems ' .
            'LEFT JOIN lv_article AS article ON loanitems.lv_article_deviceID = article.articleID ' .
            'LEFT JOIN lv_articletype AS articletype ON article.lv_articletype_articleTypeID = articletype.articleTypeID ' .
            'LEFT JOIN lv_articleproducer AS articleproducer ON article.lv_producer_producerID = articleproducer.articleproducerID ' .
            'WHERE  article.articleName="' . $paramArticleData['articleName'] . '" AND
                        article.fhnwNumber="' . $paramArticleData['fhnwNumber'] . '" AND
                        article.serialNumber="' . $paramArticleData['serialNumber'] . '" AND
                        article.articlePrice="' . $paramArticleData['articlePrice'] . '" AND
                        article.dateBought="' . $paramArticleData['dateBought'] . '" AND
                        article.dateWarranty="' . $paramArticleData['dateWarranty'] . '" AND
                        articletype.articleTypeName="' . $paramArticleData['articleTypeName'] . '" AND
                        articleproducer.articleproducerName="' . $paramArticleData['articleproducerName'] . '"';

        //$postConditionSQL = 'SET FOREIGN_KEY_CHECKS=1';

        // INSERT VALIDATION AND ERROR HANDLING

        $transaction = Yii::$app->db->beginTransaction();
        //Yii::$app->db->createCommand($preConditionSQL)->execute();
        Yii::$app->db->createCommand($qry1)->execute();
//        Yii::$app->db->createCommand($query2)->execute();
//        Yii::$app->db->createCommand($query3)->execute();
        //Yii::$app->db->createCommand($postConditionSQL)->execute();
        $transaction->commit();
    }

    public function deleteDataBenutzer($paramUserData)
    {
        $query1 = ' DELETE FROM lv_user ' .
            ' WHERE  lv_user.userID="' . $paramUserData['userID'] . '" AND
                           lv_user.isUserAdmin="' . $paramUserData['isUserAdmin'] . '" AND
                           lv_user.userPersonsID="' . $paramUserData['userPersonsID'].'"';
        $query2 = ' DELETE FROM lv_persons ' .
            ' WHERE  lv_persons.personsID="' . $paramUserData['articleTypeName'] . '" AND
                           lv_persons.personFirstname=lv_articletype.articleTypeID AND
                           lv_persons.personMail=lv_articletype.articleTypeID AND
                           lv_persons.personLastname=lv_articleproducer.articleproducerID';

        $transaction = Yii::$app->db->beginTransaction();
        Yii::$app->db->createCommand($query1)->execute();
        Yii::$app->db->createCommand($query2)->execute();
        $transaction->commit();
    }

    public function getDataProducer()
    {
        $dataProvider = new SqlDataProvider([
            'sql' => ' SELECT articleproducerName FROM  lv_articleproducer'
        ]);
        return ArrayHelper::getColumn($dataProvider->getModels(), 'articleproducerName');                               //TODO: Errorhandling einfügen
    }
    public function getDataBenutzer()
    {
        Yii::$app->db->createCommand('SELECT SQL_CALC_FOUND_ROWS * FROM {{%lv_user}} LIMIT 1')->queryScalar();
        $totalCount = Yii::$app->db->createCommand('SELECT FOUND_ROWS()')->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT persons.personFirstname, persons.personLastname, persons.personMail, users.isUserAdmin, users.userID' .
                ' FROM lv_user AS users' .
                ' LEFT JOIN lv_persons AS persons ON users.userID = persons.personsID' .
                ' WHERE persons.personsID = users.userID GROUP BY users.userID;',

            'totalCount' => $totalCount,
            'sort' => [
                'attributes' => [
                    'personMail' => [
                        'asc' => ['userID' => SORT_ASC],
                        'desc' => ['userID' => SORT_DESC],
                        //'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'isUserAdmin' => [
                        'asc' => ['isUserAdmin' => SORT_ASC],
                        'desc' => ['isUserAdmin' => SORT_DESC],
                        //'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'personFirstname' => [
                        'asc' => ['articleName' => SORT_ASC],
                        'desc' => ['articleName' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'personLastname' => [
                        'asc' => ['articleName' => SORT_ASC],
                        'desc' => ['articleName' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'created_on'
                ],
            ],
        ]);
        return $dataProvider;
    }

    public function getDataBenutzerID($paramUserID)
    {
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT persons.personFirstname, persons.personLastname, persons.personMail, users.isUserAdmin, users.userID' .
                ' FROM lv_user AS users' .
                ' LEFT JOIN lv_persons AS persons ON users.userID = persons.personsID' .
                ' WHERE persons.personsID = ' . $paramUserID,
            'sort' => [
                'attributes' => [
                    'personMail' => [
                        'asc' => ['userID' => SORT_ASC],
                        'desc' => ['userID' => SORT_DESC],
                        //'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'isUserAdmin' => [
                        'asc' => ['isUserAdmin' => SORT_ASC],
                        'desc' => ['isUserAdmin' => SORT_DESC],
                        //'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'personFirstname' => [
                        'asc' => ['articleName' => SORT_ASC],
                        'desc' => ['articleName' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'personLastname' => [
                        'asc' => ['articleName' => SORT_ASC],
                        'desc' => ['articleName' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'created_on'
                ],
            ],
        ]);
        return ArrayHelper::getValue($dataProvider->getModels(), 0);
    }

    public function updateDataBenutzer($paramUserModel, $paramUserPW)
    {
        $query = '
                UPDATE  lv_user user, lv_persons person 
                
                SET     person.personFirstname="' . $paramUserModel['personFirstname'] . '",
                        person.personLastname="' . $paramUserModel['personLastname'] . '",
                        person.personMail="' . $paramUserModel['personMail'] . '",
                        user.isUserAdmin="' . $paramUserModel['isUserAdmin'] . '",
                        user.userPassword="' . $paramUserPW . '"
                            
                WHERE   user.userID="' . $paramUserModel['userID'] . '" AND
                        person.personsID="' . $paramUserModel['userID'] . '"';

        Yii::$app->db->createCommand($query)->execute();
    }

    public function createDataBenutzer($paramUserModel, $paramUserPW)
    {
        $preConditionSQL = 'SET FOREIGN_KEY_CHECKS=0';
        $query1 = ' 
                    INSERT INTO     lv_users (isUserAdmin, userPassword, userPersonsID, userID)
                    
                    VALUES         (
                                   "' . $paramUserModel['isUserAdmin'] . '"," '
            . $paramUserPW . '"
                                    (SELECT AUTO_INCREMENT
                                        FROM INFORMATION_SCHEMA.TABLES
                                        WHERE TABLE_NAME="lv_user"),
                                    (SELECT AUTO_INCREMENT
                                        FROM INFORMATION_SCHEMA.TABLES
                                        WHERE TABLE_NAME="lv_user")                                
                                    );';
        $query2 = '    
                    INSERT INTO     lv_persons (personFirstname, personLastname, personMail)

                    VALUES         (
                                    "' . $paramUserModel['personFirstname'] . '","'
            . $paramUserModel['personLastname'] . '","'
            . $paramUserModel['isUserAdmin'] . '"
                                    );';

        $postConditionSQL = 'SET FOREIGN_KEY_CHECKS=1';

        $transaction = Yii::$app->db->beginTransaction();
        Yii::$app->db->createCommand($preConditionSQL)->execute();
        Yii::$app->db->createCommand($query1)->execute();
        Yii::$app->db->createCommand($query2)->execute();
        Yii::$app->db->createCommand($postConditionSQL)->execute();
        $transaction->commit();
    }


    public function getLoginData($paramUserMail)
    {
        try{
            $dataProvider = new SqlDataProvider([
                'sql' => 'SELECT persons.personMail, users.isUserAdmin, users.userID, users.userPassword' .
                    ' FROM lv_user AS users' .
                    ' LEFT JOIN lv_persons AS persons ON users.userID = persons.personsID' .
                    ' WHERE persons.personMail = "' . $paramUserMail . '"'
            ]);
        }
        catch(exception $e){
           return [false, $e];
        }
        //TODO must be validated, if there is no result in index 0 an error occurs!
         return ArrayHelper::getValue($dataProvider->getModels(), 0);
    }
}




