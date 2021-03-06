<?php

/**
 * This is the model class for table "tbl_merchant".
 *
 * The followings are the available columns in table 'tbl_merchant':
 * @property integer $merchant_id
 * @property integer $contact_id_fk
 * @property integer $deals_list_id_fk
 * @property integer $category_id_fk
 * @property integer $user_analytics_id_fk
 * @property string $last_update
 *
 * The followings are the available model relations:
 * @property Deal[] $deals
 * @property Contact $contactIdFk
 * @property Category $categoryIdFk
 * @property UserAnalytic $userAnalyticsIdFk
 */
class Merchant extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Merchant the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_merchant';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contact_id_fk, category_id_fk', 'required'),
			array('contact_id_fk, deals_list_id_fk, category_id_fk, user_analytics_id_fk', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('merchant_id, contact_id_fk, deals_list_id_fk, category_id_fk, user_analytics_id_fk, last_update', 'safe', 'on'=>'search'),
			array('last_update','default',
			      'value'=>new CDbExpression('NOW()'),
			      'setOnEmpty'=>false,'on'=>'update'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'deals' => array(self::HAS_MANY, 'Deal', 'merchant_id_fk'),
			'contactIdFk' => array(self::BELONGS_TO, 'Contact', 'contact_id_fk'),
			'categoryIdFk' => array(self::BELONGS_TO, 'Category', 'category_id_fk'),
			'userAnalyticsIdFk' => array(self::BELONGS_TO, 'UserAnalytic', 'user_analytics_id_fk'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'merchant_id' => 'Merchant',
			'contact_id_fk' => 'Contact',
			'deals_list_id_fk' => 'Deals List',
			'category_id_fk' => 'Category',
			'user_analytics_id_fk' => 'User Analytics',
			'last_update' => 'Last Update',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('merchant_id',$this->merchant_id);
		$criteria->compare('contact_id_fk',$this->contact_id_fk);
		$criteria->compare('deals_list_id_fk',$this->deals_list_id_fk);
		$criteria->compare('category_id_fk',$this->category_id_fk);
		$criteria->compare('user_analytics_id_fk',$this->user_analytics_id_fk);
		$criteria->compare('last_update',$this->last_update,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	

}