<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;

/**
 * ContactForm is the model behind the contact form.
 */
class QueryForm extends Model
{
    private $dataProvider;

      
    public function getData()
    {
        Yii::$app->db->createCommand('SELECT SQL_CALC_FOUND_ROWS * FROM {{%lv_article}} LIMIT 1')->queryScalar();
        $totalCount = Yii::$app->db->createCommand('SELECT FOUND_ROWS()')->queryScalar();
        

        $dataProvider = new SqlDataProvider([
        'sql' => 'SELECT articletype.articleTypeName, articleproducer.articleproducerName, article.articleName, article.fhnwNumber, loanitems.lvLoanReturnDate'.
        ' FROM lv_loanitems AS loanitems'.
        ' LEFT JOIN lv_article AS article ON loanitems.lv_article_deviceID = article.articleID'.
        ' LEFT JOIN lv_articletype AS articletype ON article.lv_articletype_articleTypeID = articletype.articleTypeID'.
        ' LEFT JOIN lv_articleproducer AS articleproducer ON article.lv_producer_producerID = articleproducer.articleproducerID'.
        ' GROUP BY article.fhnwNumber',
          'pagination' => [
                'pageSize' => 3,
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
        'sql' => 'SELECT persons.personFirstname, persons.personLastname, loanitems.lvLoanReturnDate, loanprofile.loanLocation, article.articleName'.
        ' FROM lv_loanprofile AS loanprofile'.
        ' LEFT JOIN lv_persons AS persons ON loanprofile.loanPerson = persons.personsID'.
        ' LEFT JOIN lv_loanitems AS loanitems ON loanprofile.loanID = loanitems.lv_loan_loanID'.
        ' LEFT JOIN lv_article AS article ON loanitems.lv_article_deviceID = article.articleID'.
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
        'sql' => 'SELECT article.articleName, article.fhnwNumber, article.serialNumber, article.articlePrice, article.articleDescription, articletype.articleTypeName, producer.articleproducerName'.
        ' FROM lv_loanprofile AS loanprofile'.
        ' LEFT JOIN lv_articleproducer AS producer ON producer.articleproducerID = article.articleID'.
        ' LEFT JOIN lv_articletype AS articletype ON articletype.articleID = articletype.articleTypeID'.
        ' LEFT JOIN lv_article AS article ON loanitems.lv_article_deviceID = article.articleID'.
        ' WHERE '+ $paramFindRow +' GROUP BY article.articleID;',
            
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
        'sql' => 'SELECT articletype.articleTypeName, articleproducer.articleproducerName, '.
                        'article.articleName, article.fhnwNumber, '.
                        'article.serialNumber, article.articlePrice, article.dateBought, '.
                        'article.dateWarranty, article.articleDescription'.
                ' FROM lv_loanitems AS loanitems'.           
                ' LEFT JOIN lv_article AS article ON loanitems.lv_article_deviceID = article.articleID'.
                ' LEFT JOIN lv_articletype AS articletype ON article.lv_articletype_articleTypeID = articletype.articleTypeID'.
                ' LEFT JOIN lv_articleproducer AS articleproducer ON article.lv_producer_producerID = articleproducer.articleproducerID'. 
                ' WHERE article.fhnwNumber = '.$fhnwNumber.' GROUP BY article.fhnwNumber',
            
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
                'asc' => ['articlefhnwNumber' => SORT_ASC],
                'desc' => ['articlefhnwNumber' => SORT_DESC],
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
                'asc' => ['articleserialNumber' => SORT_ASC],
                'desc' => ['articleserialNumber' => SORT_DESC],
                'default' => SORT_DESC,
                'label' => 'Name',
            ],
            'dateBought' => [
                'asc' => ['articleserialNumber' => SORT_ASC],
                'desc' => ['articleserialNumber' => SORT_DESC],
                'default' => SORT_DESC,
                'label' => 'Name',
            ],
            'dateWarranty' => [
                'asc' => ['articleserialNumber' => SORT_ASC],
                'desc' => ['articleserialNumber' => SORT_DESC],
                'default' => SORT_DESC,
                'label' => 'Name',
            ],
            'articleDescription' => [
                'asc' => ['articleserialNumber' => SORT_ASC],
                'desc' => ['articleserialNumber' => SORT_DESC],
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
}



