<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;
use yii\db\Query;
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
        $dataProvider = new SqlDataProvider([
            'sql' =>
                'SELECT  article.articleName, articletype.articleTypeName, ' .
                        'articleproducer.articleproducerName, article.serialNumber, ' .
                        'article.dateBought, article.dateWarranty, article.articlePrice, ' .
                'article.fhnwNumber, article.articleDescription, article.lv_producer_producerID, 
                 article.lv_articletype_articleTypeID, article.isArchive, article.articleStatus, article.statusComment' .
                ' FROM lv_article AS article' .
                ' LEFT JOIN lv_loanitems AS loanitems ON article.articleID = loanitems.lv_article_deviceID' .
                ' LEFT JOIN lv_articletype AS articletype ON article.lv_articletype_articleTypeID = articletype.articleTypeID' .
                ' LEFT JOIN lv_articleproducer AS articleproducer ON article.lv_producer_producerID = articleproducer.articleproducerID' .
                ' WHERE article.fhnwNumber = "' . $paramFhnwNumber . '" GROUP BY article.fhnwNumber',

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
        $dataProvider = new SqlDataProvider([
            'sql' =>
                'SELECT loanitems.lvLoanReturnDate, loanitems.lvLoanLendingDate, loanitems.loanAuthorityMail, 
                        loanprofile.loanLocation, loanprofile.loanDscription, loanprofile.loanPersonMail,
                        article.articleName, article.fhnwNumber,
                        articleproducer.articleTypeName'.

                ' FROM lv_loanprofile AS loanprofile' .

                ' LEFT JOIN lv_articletype AS articletype ON article.articleID = articletype.articleTypeID' .
                ' LEFT JOIN lv_articleproducer AS articleproducer ON article.articleID = articleproducer.articleproducerID' .
                ' LEFT JOIN lv_loanitems AS loanitems ON loanprofile.loanID = loanitems.lv_loan_loanID' .
                ' LEFT JOIN lv_article AS article ON loanitems.lv_article_deviceID = article.articleID' .

                ' WHERE article.fhnwNumber = "' . $paramFhnwNumber . '" GROUP BY article.fhnwNumber',
        ]);

        return ArrayHelper::getValue($dataProvider->getModels(), 0);
    }
    public function getDataProducerDetails($articleproducerID)
    {
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT articleproducerName, articleproducerDescription FROM lv_articleproducer'.
                ' WHERE articleproducerID = "' . $articleproducerID . '"'
        ]);

        return ArrayHelper::getValue($dataProvider->getModels(), 0);
        //ArrayHelper::map($dataProvider->getModels(), 'articleName', 'articleTypeName', 'class') TODO: Evaluate if this is a better data processing method
    }

    public function setDataArticle($paramArticleData)
    {
        $query = 'UPDATE  lv_article article, lv_articletype articletype, lv_articleproducer articleproducer 
                        
                SET     article.articleName="' . $paramArticleData['articleName'] . '",
                        article.serialNumber="' . $paramArticleData['serialNumber'] . '",
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
        //echo'<script>'.$query.'</script>';

        Yii::$app->db->createCommand($query)->execute();
    }

    public function createDataArticle($paramArticleData)
    {

        $queryArtikeltyp = 'INSERT IGNORE INTO lv_articletype (articleTypeName) VALUES ("' . $paramArticleData['articleTypeName'] . '");';
        $queryArtikelHersteller = 'INSERT IGNORE INTO lv_articleproducer (articleproducerName) VALUES ("' . $paramArticleData['articleproducerName'] . '");';

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

        $transaction = Yii::$app->db->beginTransaction();
        Yii::$app->db->createCommand($queryArtikeltyp)->execute();
        Yii::$app->db->createCommand($queryArtikelHersteller)->execute();
        Yii::$app->db->createCommand($queryArtikelsatz)->execute();
        $transaction->commit();
    }
    public function deleteDataArticle($paramArticleData)
    {
        $query = 'UPDATE lv_article SET isArchive = 1 WHERE fhnwNumber=' . $paramArticleData['fhnwNumber'];              //Artikel können nicht gelöscht werden, isArchive wird auf 1 gesetzt

        $transaction = Yii::$app->db->beginTransaction();
        Yii::$app->db->createCommand($query)->execute();
        $transaction->commit();
    }
    public function deleteDataUser($paramUserData)
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

    public function getDataArticletype()
    {
        $dataProvider = new SqlDataProvider([
            'sql' => ' SELECT articleTypeName FROM lv_articletype'
        ]);
        return ArrayHelper::getColumn($dataProvider->getModels(), 'articleTypeName');                               //TODO: Errorhandling einfügen
    }
    public function getDataUser()
    {
        $totalCount = Yii::$app->db->createCommand('SELECT FOUND_ROWS()')->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT persons.personFirstname, persons.personLastname, persons.personMail, users.isUserAdmin, users.userID' .
                ' FROM lv_user AS users' .
                ' LEFT JOIN lv_persons AS persons ON users.userID = persons.personsID' .
                ' WHERE persons.personsID = users.userID GROUP BY users.userID',
            'totalCount' => $totalCount,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => [
                    'personMail' => [
                        'asc' => ['personMail' => SORT_ASC],
                        'desc' => ['personMail' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'isUserAdmin' => [
                        'asc' => ['isUserAdmin' => SORT_ASC],
                        'desc' => ['isUserAdmin' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Post Title',
                    ],
                    'personFirstname' => [
                        'asc' => ['personFirstname' => SORT_ASC],
                        'desc' => ['personFirstname' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'personLastname' => [
                        'asc' => ['personLastname' => SORT_ASC],
                        'desc' => ['personLastname' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'Name',
                    ],
                    'created_on'
                ],
            ],
        ]);
        return $dataProvider;
    }
    public function getDataUserID($paramUserID)
    {
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT user.email, user.isUserAdmin, user.userID' .
                ' FROM lv_user AS user' .
                ' WHERE user.userID = "' . $paramUserID . '"'
        ]);
        return ArrayHelper::getValue($dataProvider->getModels(), 0);
    }
    public function setUpdateDataUser($paramUserModel, $paramUserPW)
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

    public function createDataUser($paramEmail, $paramIsUserAdmin)
    {
        $escEmail = \Yii::$app->db->quoteValue($paramEmail);
        $escIsUserAdmin = \Yii::$app->db->quoteValue($paramIsUserAdmin);

        $query = 'INSERT INTO lv_user (email,auth_key,isUserAdmin) 
                   VALUES ('.$escEmail.','.yii::$app->security->generateRandomString().','.$escIsUserAdmin.')';

        //$transaction = Yii::$app->db->beginTransaction();
        Yii::$app->db->createCommand($query)->execute();
        //$transaction->commit();
    }

    public function getLoginData($paramUserMail)
    {
        try{
            $dataProvider = new SqlDataProvider([
                'sql' => 'SELECT user.email, user.isUserAdmin, user.userID' .
                    ' FROM lv_user AS user' .
                    ' WHERE user.email = "' . $paramUserMail . '"'
            ]);
        }
        catch(exception $e){
           return [false, $e];
        }
        //TODO must be validated, if there is no result in index 0 an error occurs!
         return ArrayHelper::getValue($dataProvider->getModels(), 0);
    }
    public function getSuperuser($paramUserMail){
        try{
            $dataProvider = new SqlDataProvider([
                'sql' => 'SELECT superuser.superID, superuser.username, superuser.password, superuser.auth_key' .
                    ' FROM lv_superuser AS superuser' .
                    ' WHERE superuser.username = "' . $paramUserMail . '"'
            ]);
        }
        catch(exception $e){
            return [false, $e];
        }
        //TODO must be validated, if there is no result in index 0 an error occurs!
        return ArrayHelper::getValue($dataProvider->getModels(), 0);
    }
}

