<?php

/**
 * This is the model class for table "tbl_city".
 *
 * The followings are the available columns in table 'tbl_city':
 * @property integer $city_id
 * @property string $name
 * @property integer $state_id_fk
 * @property integer $country_id_fk
 *
 * The followings are the available model relations:
 * @property Address[] $addresses
 * @property State $stateIdFk
 * @property Country $countryIdFk
 * @property Zipcode[] $zipcodes
 */
class City extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return City the static model class
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
		return 'tbl_city';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, state_id_fk, country_id_fk', 'required'),
			array('state_id_fk, country_id_fk', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('city_id, name, state_id_fk, country_id_fk', 'safe', 'on'=>'search'),
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
			'addresses' => array(self::HAS_MANY, 'Address', 'city_id_fk'),
			'stateIdFk' => array(self::BELONGS_TO, 'State', 'state_id_fk'),
			'countryIdFk' => array(self::BELONGS_TO, 'Country', 'country_id_fk'),
			'zipcodes' => array(self::HAS_MANY, 'Zipcode', 'city_id_fk'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'city_id' => 'City',
			'name' => 'Name',
			'state_id_fk' => 'State',
			'country_id_fk' => 'Country',
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

		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('state_id_fk',$this->state_id_fk);
		$criteria->compare('country_id_fk',$this->country_id_fk);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}