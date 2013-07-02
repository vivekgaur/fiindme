<?php

/**
 * This is the model class for table "tbl_zipcode".
 *
 * The followings are the available columns in table 'tbl_zipcode':
 * @property integer $zipcode_id
 * @property integer $zip_code
 * @property integer $city_id_fk
 * @property integer $state_id_fk
 * @property double $latitude
 * @property double $longitude
 *
 * The followings are the available model relations:
 * @property Address[] $addresses
 * @property User[] $users
 * @property City $cityIdFk
 * @property State $stateIdFk
 */
class Zipcode extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Zipcode the static model class
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
		return 'tbl_zipcode';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('zip_code, city_id_fk, state_id_fk, latitude, longitude', 'required'),
			array('zip_code, city_id_fk, state_id_fk', 'numerical', 'integerOnly'=>true),
			array('latitude, longitude', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('zipcode_id, zip_code, city_id_fk, state_id_fk, latitude, longitude', 'safe', 'on'=>'search'),
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
			'addresses' => array(self::HAS_MANY, 'Address', 'zip_code_id_fk'),
			'users' => array(self::HAS_MANY, 'User', 'default_zipcode_id_fk'),
			'cityIdFk' => array(self::BELONGS_TO, 'City', 'city_id_fk'),
			'stateIdFk' => array(self::BELONGS_TO, 'State', 'state_id_fk'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'zipcode_id' => 'Zipcode',
			'zip_code' => 'Zip Code',
			'city_id_fk' => 'City Name',
			'state_id_fk' => 'State Name',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
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

		$criteria->compare('zipcode_id',$this->zipcode_id);
		$criteria->compare('zip_code',$this->zip_code);
		$criteria->compare('city_id_fk',$this->city_id_fk);
		$criteria->compare('state_id_fk',$this->state_id_fk);
		$criteria->compare('latitude',$this->latitude);
		$criteria->compare('longitude',$this->longitude);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}