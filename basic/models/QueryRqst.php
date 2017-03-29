<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * QueryRqst is the interface to the Database
 * @author Rilind Gashi, Alexander Weinbeck
 * @version 1.0
 * @param data to set to DB
 * @return data to get from DB
 */
class QueryRqst extends Model
{
    public function getDataArticlelist()
    {
        $totalCount = Yii::$app->db->createCommand('SELECT COUNT(fhnwNumber) FROM lv_article LIMIT 1')->queryScalar();

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
                        'label' => 'Post Title',
                    ],
                    'fhnwNumber' => [
                        'asc' => ['fhnwNumber' => SORT_ASC],
                        'desc' => ['fhnwNumber' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'lvLoanReturnDate' => [
                        'asc' => ['lvLoanReturnDate' => SORT_ASC],
                        'desc' => ['lvLoanReturnDate' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'created_on'
                ],

            ],
        ]);
        return $dataProvider;
    }
    public function getDataActualLoans()
    {
        Yii::$app->db->createCommand('SELECT SQL_CALC_FOUND_ROWS * FROM {{%lv_article}} LIMIT 1')->queryScalar();
        $totalCount = Yii::$app->db->createCommand('SELECT FOUND_ROWS()')->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' =>
                ' SELECT persons.personFirstname, persons.personLastname, loanitems.lvLoanReturnDate, loanprofile.loanLocation, article.articleName, article.fhnwNumber' .
                ' FROM lv_loanprofile AS loanprofile' .
                ' LEFT JOIN lv_persons AS persons ON loanprofile.loanPerson = persons.personsID' .
                ' LEFT JOIN lv_loanitems AS loanitems ON loanprofile.loanID = loanitems.lv_loan_loanID' .
                ' LEFT JOIN lv_article AS article ON loanitems.lv_article_deviceID = article.articleID' .
                ' WHERE loanitems.lvLoanReturnDate >= CURDATE() GROUP BY loanprofile.loanID;',
            'pagination' => [
                'pageSize' => 10,
            ],
            'totalCount' => $totalCount,
            'sort' => [
                'attributes' => [
                    'personFirstname' => [
                        'asc' => ['personFirstname' => SORT_ASC],
                        'desc' => ['personFirstname' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'personLastname' => [
                        'asc' => ['personLastname' => SORT_ASC],
                        'desc' => ['personLastname' => SORT_DESC],
                        'default' => SORT_DESC,
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
                    'fhnwNumber' => [
                        'asc' => ['fhnwNumber' => SORT_ASC],
                        'desc' => ['fhnwNumber' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'created_on'
                ],
            ],
        ]);
        return $dataProvider;
    }
    public function getProducerList()
    {
         Yii::$app->db->createCommand('SELECT COUNT(fhnwNumber) FROM lv_article LIMIT 1')->queryScalar();
        $totalCount = Yii::$app->db->createCommand('SELECT COUNT(fhnwNumber) FROM lv_article LIMIT 1')->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT articleproducerID, articleproducerName, articleproducerDescription FROM lv_articleproducer',

            'pagination' => [
                'pageSize' => 10,
            ],
            'totalCount' => $totalCount,

            'sort' => [
                'attributes' => [
                    'articleproducerID' => [
                        'asc' => ['articleproducerID' => SORT_ASC],
                        'desc' => ['articleproducerID' => SORT_DESC],
                        //'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'articleproducerName' => [
                        'asc' => ['articleproducerName' => SORT_ASC],
                        'desc' => ['articleproducerName' => SORT_DESC],
                        //'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'articleproducerDescription' => [
                        'asc' => ['articleproducerDescription' => SORT_ASC],
                        'desc' => ['articleproducerDescription' => SORT_DESC],
                        //'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'created_on'
                ],

            ],
        ]);
        return $dataProvider;
        
    }
    public function getArticleHistory($paramFhnwNumber)                                                        //TODO: Wenn Datenbank gefüllt wurde, Query anpassen
    {
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT persons.personFirstname, persons.personLastname, loanitems.lvLoanReturnDate, loanitems.lvLoanLendingDate' .
                ' FROM lv_loanprofile AS loanprofile' .
                ' LEFT JOIN lv_persons AS persons ON loanprofile.loanPerson = persons.personsID' .
                ' LEFT JOIN lv_loanitems AS loanitems ON loanprofile.loanID = loanitems.lv_loan_loanID' .
                ' LEFT JOIN lv_article AS article ON loanitems.lv_article_deviceID = article.articleID' .
                ' WHERE article.fhnwNumber = "' . $paramFhnwNumber . '"',

            'pagination' => [
                'pageSize' => 10,
            ],
            //'totalCount' => $totalCount,
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
                    'lvLoanReturnDate' => [
                        'asc' => ['lvLoanReturnDate' => SORT_ASC],
                        'desc' => ['lvLoanReturnDate' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'lvLoanLendingDate' => [
                        'asc' => ['lvLoanLendingDate' => SORT_ASC],
                        'desc' => ['lvLoanLendingDate' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'created_on'
                ],

            ],
        ]);
        return $dataProvider;
    }

 /*
    public function getDataArticlelistEdit($paramFindRow)
    {
        $dataProvider = new SqlDataProvider([
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
 */
    public function getDataArticle($paramFhnwNumber)
    {
        $escFhnwnumber = \Yii::$app->db->quoteValue($paramFhnwNumber);
        $dataProvider = new SqlDataProvider([
            'sql' =>
                "SELECT  article.articleName, articletype.articleTypeName, 
                         articleproducer.articleproducerName, article.serialNumber,
                         article.dateBought, article.dateWarranty, article.articlePrice,
                         article.fhnwNumber, article.articleDescription, article.lv_producer_producerID, 
                         article.lv_articletype_articleTypeID, article.isArchive, article.articleStatus, 
                         article.statusComment
                 FROM lv_article AS article 
                 LEFT JOIN lv_loanitems AS loanitems ON article.articleID = loanitems.lv_article_deviceID
                 LEFT JOIN lv_articletype AS articletype ON article.lv_articletype_articleTypeID = articletype.articleTypeID
                 LEFT JOIN lv_articleproducer AS articleproducer ON article.lv_producer_producerID = articleproducer.articleproducerID 
                 WHERE article.fhnwNumber = $escFhnwnumber GROUP BY article.fhnwNumber"
        ]);
        return ArrayHelper::getValue($dataProvider->getModels(), 0);                //TODO Evaluate if this is a better data processing method
    }
    /**
     * Get required data for a rental
     * @author Alexander Weinbeck
     * @param $paramFhnwNumber
     * @return mixed -> SQLDataProvider value
     */
    public function getDataLoan($paramFhnwNumber)
    {
        $escFhnwnumber = \Yii::$app->db->quoteValue($paramFhnwNumber);
        $dataProvider = new SqlDataProvider([
            'sql' =>
                "SELECT loanitems.lvLoanReturnDate, loanitems.lvLoanLendingDate, 
                        loanprofile.loanLocation, loanprofile.loanDescription,
                        persons.personMail, persons.personFirstname, persons.personLastname, persons.department,
                        article.articleName, article.fhnwNumber,
                        articleproducer.articleproducerName

                FROM lv_loanprofile AS loanprofile
                
                LEFT JOIN lv_loanitems AS loanitems ON loanprofile.loanID = loanitems.lv_loan_loanID
                LEFT JOIN lv_article AS article ON loanitems.lv_article_deviceID = article.articleID
                LEFT JOIN lv_articletype AS articletype ON article.lv_articletype_articleTypeID = articletype.articleTypeID
                LEFT JOIN lv_persons AS persons ON persons.personsID = loanprofile.loanPerson
                LEFT JOIN lv_articleproducer AS articleproducer ON article.articleID = articleproducer.articleproducerID
                
                WHERE article.fhnwNumber =  $escFhnwnumber  GROUP BY article.fhnwNumber",
        ]);

        return ArrayHelper::getValue($dataProvider->getModels(), 0);
    }
    public function setDataArticle($paramArticleData)
    {
        $escArticleName = Yii::$app->db->quoteValue($paramArticleData['articleName'],'');
        $escSerialNumber = Yii::$app->db->quoteValue($paramArticleData['serialNumber'],'');
        $escDateBought = Yii::$app->db->quoteValue($paramArticleData['dateBought'],'');
        $escDateWarranty = Yii::$app->db->quoteValue($paramArticleData['dateWarranty'],'');
        $escArticlePrice = Yii::$app->db->quoteValue($paramArticleData['articlePrice'],'');
        $escFhnwNumber = Yii::$app->db->quoteValue($paramArticleData['fhnwNumber'],'');
        $escArticleDescription = Yii::$app->db->quoteValue($paramArticleData['articleDescription'],'');
        $escArticleTypeName = Yii::$app->db->quoteValue($paramArticleData['articleTypeName'],'');
        $escArticleproducerName = Yii::$app->db->quoteValue($paramArticleData['articleproducerName'],'');
        $query = "UPDATE  lv_article AS article, lv_articletype AS articletype, lv_articleproducer AS articleproducer 
                        
                  SET     article.articleName = $escArticleName,
                          article.serialNumber = $escSerialNumber,
                          article.dateBought = $escDateBought,
                          article.dateWarranty = $escDateWarranty,
                          article.articlePrice = $escArticlePrice,
                          article.fhnwNumber = $escFhnwNumber,
                          article.articleDescription = $escArticleDescription,
                          articletype.articleTypeName = $escArticleTypeName, 
                          articleproducer.articleproducerName = $escArticleproducerName
                           
                            
                  WHERE   article.fhnwNumber = $escFhnwNumber AND
                          article.lv_articletype_articleTypeID = articletype.articleTypeID AND
                          article.lv_producer_producerID = articleproducer.articleproducerID";

        Yii::$app->db->createCommand($query)->execute();
    }

    public function createDataArticle($paramArticleData)
    {
        $queryArticleType = 'INSERT IGNORE INTO lv_articletype (articleTypeName) VALUES ("' . $paramArticleData['articleTypeName'] . '");';
        $queryArticleProducer = 'INSERT IGNORE INTO lv_articleproducer (articleproducerName) VALUES ("' . $paramArticleData['articleproducerName'] . '");';

        $fhnwNumberPartOne = $paramArticleData['fhnwNumber'];
        $fhnwNumberPartTwo = $paramArticleData['serialNumber'];
        $fhnwNumberPartThree = str_replace('.', '', $paramArticleData['dateBought']);
        $generatedFHNWNumber = $fhnwNumberPartOne.'_'.$fhnwNumberPartTwo.'_'.$fhnwNumberPartThree;

        Yii::$app->db->createCommand("SELECT COUNT(fhnwNumber) FROM lv_article WHERE fhnwNumber = '$generatedFHNWNumber'")->queryScalar();
        $checkIfFHNWNumberExist = Yii::$app->db->createCommand("SELECT COUNT(fhnwNumber) FROM lv_article WHERE fhnwNumber = '$generatedFHNWNumber'")->queryScalar();

        if($checkIfFHNWNumberExist > 0)
        {
            $counterVarForFHNWNumber = $checkIfFHNWNumberExist + 1;
            $generatedFHNWNumber = $generatedFHNWNumber.'_'.$counterVarForFHNWNumber;
        }
        $dateBoughtNew = date("Y-m-d", strtotime($paramArticleData['dateBought']));
        $dateWarrantyNew = date("Y-m-d", strtotime($paramArticleData['dateWarranty']));
        $queryArtikelsatz = 'INSERT INTO lv_article (
                            articleName, 
                            fhnwNumber, 
                            serialNumber,
                            articlePrice, 
                            dateBought, 
                            dateWarranty, 
                            articleDescription, 
                            lv_articletype_articleTypeID, 
                            lv_producer_producerID 
                        ) 
                        SELECT 
                        "' . $paramArticleData['articleName'] . '"," '
                        . $generatedFHNWNumber . '"," '
                        . $paramArticleData['serialNumber'] . '"," '
                        . $paramArticleData['articlePrice'] . '"," '
                        . $dateBoughtNew . '"," '
                        . $dateWarrantyNew . '"," '
                        . $paramArticleData['articleDescription'] . '", 
                        (SELECT articletypeID FROM lv_articletype WHERE articleTypeName = "' . $paramArticleData['articleTypeName'] . ' "), 
                        articleproducerID FROM lv_articleproducer WHERE articleproducerName = "' . $paramArticleData['articleproducerName'] . ' "';
        //TODO Try Catch Block
        $transaction = Yii::$app->db->beginTransaction();
        Yii::$app->db->createCommand($queryArticleType)->execute();
        Yii::$app->db->createCommand($queryArticleProducer)->execute();
        Yii::$app->db->createCommand($queryArtikelsatz)->execute();
        $transaction->commit();
    }
    public function deleteDataArticle($paramFhnwNumber)
    {
        $escArticleData = Yii::$app->db->quoteValue($paramFhnwNumber);
        $query = Yii::$app->db->quoteSql("UPDATE lv_article SET isArchive = 1 WHERE fhnwNumber = $escArticleData");              //Artikel können nicht gelöscht werden, isArchive wird auf 1 gesetzt
        try {
            $transaction = Yii::$app->db->beginTransaction();
            Yii::$app->db->createCommand($query)->execute();
            $transaction->commit();
        } catch(Exception $e){
            $transaction->rollBack();
            throw new \yii\db\Exception($e->getMessage());
        }
    }

    public function getDataProducerDetails($articleproducerID)
    {
        $escarticleproducerID = Yii::$app->db->quoteValue($articleproducerID);

        $dataProvider = new SqlDataProvider([
            'sql' =>  "SELECT articleproducerName, articleproducerDescription, articleproducerID 
                       FROM lv_articleproducer
                       WHERE articleproducerID = $escarticleproducerID"
        ]);

        return ArrayHelper::getValue($dataProvider->getModels(), 0);
        //ArrayHelper::map($dataProvider->getModels(), 'articleName', 'articleTypeName', 'class') TODO: Evaluate if this is a better data processing method
    }
    public function getDataProducer()
    {
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT articleproducerName FROM  lv_articleproducer'
        ]);
        return ArrayHelper::getColumn($dataProvider->getModels(), 'articleproducerName');                               //TODO: Errorhandling einfügen
    }
    public function setDataProducer($model)
    {
            $escArticleproducerName          = Yii::$app->db->quoteValue($model->articleproducerName);
            $escArticleproducerDescription   = Yii::$app->db->quoteValue($model->articleproducerDescription);
            $escArticleproducerID            = Yii::$app->db->quoteValue($model->articleproducerID);
            $query = "  UPDATE  lv_articleproducer
                        SET     articleproducerName	        =: $escArticleproducerName,
                                articleproducerDescription  =: $escArticleproducerDescription        
                        WHERE   articleproducerID           =: $escArticleproducerID";
        try {
            $transaction = Yii::$app->db->beginTransaction();
            Yii::$app->db->createCommand($query)->execute();
            $transaction->commit();
        } catch(Exception $e){
            $transaction->rollBack();
            throw new \yii\db\Exception($e->getMessage());
        }
    }
    public function deleteDataProducer($model)
    {
        try {
        $escArticleProducerID = Yii::$app->db->quoteValue($model['articleproducerID']);
            $query =  "DELETE
                       FROM lv_articleproducer
                       WHERE  articleproducerID = $escArticleProducerID ";
            $transaction = Yii::$app->db->beginTransaction();
        /*Yii::$app->db
            ->createCommand()
            ->delete('lv_articleproducer', ['articleproducerID' => $escArticleProducerID])
            ->execute();*/
        Yii::$app->db->createCommand($query)->execute();
        $transaction->commit();
        } catch(Exception $e){
            $transaction->rollBack();
            throw new \yii\db\Exception($e->getMessage());
        }
    }
    public function getDataArticletype()
    {
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT articleTypeName FROM lv_articletype'
        ]);
        return ArrayHelper::getColumn($dataProvider->getModels(), 'articleTypeName');                               //TODO: Errorhandling einfügen
    }
    public function getDataUsers()
    {
        $totalCount = Yii::$app->db->createCommand('SELECT COUNT(userID) FROM lv_user LIMIT 1')->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT users.mail, users.isUserAdmin, users.userID ' .
                     'FROM lv_user AS users '.
                     'GROUP BY users.userID',
            'totalCount' => $totalCount,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => [
                    'isUserAdmin' => [
                        'asc' => ['isUserAdmin' => SORT_ASC],
                        'desc' => ['isUserAdmin' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'mail' => [
                        'asc' => ['mail' => SORT_ASC],
                        'desc' => ['mail' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'userID' => [
                        'asc' => ['userID' => SORT_ASC],
                        'desc' => ['userID' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'created_on'
                ],
            ],
        ]);
        return $dataProvider;
    }
    /**
     * Get Data user id
     * @version 0.1
     * @author Alexander Weinbeck
     */
    public function getDataUserID($paramUserID)
    {
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT user.mail, user.isUserAdmin, user.userID ' .
                     'FROM lv_user AS user ' .
                     'WHERE user.userID = "' . $paramUserID . '"'
        ]);
        return ArrayHelper::getValue($dataProvider->getModels(), 0,false);
    }
    /**
     * Get Data users
     * @version 0.1
     * @author Alexander Weinbeck
     */
    public function setUpdateDataUser($paramUserModel)
    {
        $escIsUserAdmin = \Yii::$app->db->quoteValue($paramUserModel['isUserAdmin']);
        $escUserID = \Yii::$app->db->quoteValue($paramUserModel['userID']);
        $query = "  UPDATE  lv_user user, lv_persons person 
                    SET     user.isUserAdmin = $escIsUserAdmin                 
                    WHERE   user.userID = $escUserID ";

        Yii::$app->db->createCommand($query)->execute();
    }
    /**
     * Create Data user id
     * @version 0.1
     * @author Alexander Weinbeck
     */
    public function createDataUser($paramEmail, $paramIsUserAdmin)
    {
        $escEmail = \Yii::$app->db->quoteValue($paramEmail);
        $escIsUserAdmin = \Yii::$app->db->quoteValue($paramIsUserAdmin);
        $escRndString = \Yii::$app->db->quoteValue(yii::$app->security->generateRandomString());

        $query = "INSERT INTO lv_user (mail,auth_key,isUserAdmin) 
                  VALUES ($escEmail,$escRndString,$escIsUserAdmin)";

        Yii::$app->db->createCommand($query)->execute();
    }
    public function deleteDataUser($paramUserData)
    {
        $escUserID = Yii::$app->db->quoteValue($paramUserData->userID);
        $query1 =  "DELETE FROM lv_user
                    WHERE  userID = $escUserID ";
        try {
            $transaction = Yii::$app->db->beginTransaction();
            Yii::$app->db->createCommand($query1)->execute();
            $transaction->commit();
        } catch(Exception $e){
            $transaction->rollBack();
            throw new \yii\db\Exception($e->getMessage());
        }
    }
    /**
     * Get login Data user id
     * @version 0.1
     * @author Alexander Weinbeck
     */
    public function getLoginData($paramUserMail)
    {
        $escParamMail = \Yii::$app->db->quoteValue($paramUserMail);
        $dataProvider = new SqlDataProvider([
            'sql' => "SELECT user.mail, user.isUserAdmin, user.userID
                      FROM lv_user AS user
                      WHERE user.mail = $escParamMail "
        ]);

        return ArrayHelper::getValue($dataProvider->getModels(), 0);
    }
    /**
     * Get login Data Superuser
     * @version 0.1
     * @author Alexander Weinbeck
     */
    public function getSuperuser($paramUserMail){

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT superuser.userID, superuser.mail, superuser.password, superuser.auth_key, superuser.isUserAdmin' .
                ' FROM lv_superuser AS superuser' .
                ' WHERE superuser.mail = "' . $paramUserMail . '"'
        ]);

        return ArrayHelper::getValue($dataProvider->getModels(), 0,NULL);
    }
    /**
     * Set Superuser, actually only called once manually!
     * @version 0.1
     * @author Alexander Weinbeck
     */
    public function setSuperuser(){
        $superuserMail = "supervisor@hwa.fhnw.ch";
        $superuserPassword = "admin";
        $superuserisUserAdmin = "1";
        $superuserUserID = "10";
        $superuserPersonsID = "1000000";

        $escUserID = Yii::$app->db->quoteValue($superuserUserID);
        $escMail = Yii::$app->db->quoteValue($superuserMail);
        $escIsUserAdmin = Yii::$app->db->quoteValue($superuserisUserAdmin);
        $escAuthKey =  Yii::$app->db->quoteValue(Yii::$app->security->generateRandomString());
        $escPassword =  Yii::$app->db->quoteValue(Yii::$app->getSecurity()->generatePasswordHash($superuserPassword));
        $escPersonsID = Yii::$app->db->quoteValue($superuserPersonsID);

        $query1 = "INSERT INTO lv_superuser (userID,mail,auth_key,isUserAdmin,password) 
                   VALUES ($escUserID,$escMail,$escAuthKey,$escIsUserAdmin,$escPassword)";
        $query2 = "INSERT INTO lv_user (userID,mail,auth_key,isUserAdmin,userPersonsID) 
                   VALUES ($escUserID,$escMail,$escAuthKey,$escIsUserAdmin,$escPersonsID)";

        try {
            $transaction = Yii::$app->db->beginTransaction();
            Yii::$app->db->createCommand($query1)->execute();
            Yii::$app->db->createCommand($query2)->execute();
            $transaction->commit();
        } catch(Exception $e){
            $transaction->rollBack();
            throw new \yii\db\Exception($e->getMessage());
        }
    }
}

