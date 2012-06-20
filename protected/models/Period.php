<?php

/**
 * This is the model class for table "FIN.PERIODS".
 *
 * The followings are the available columns in table 'FIN.PERIODS':
 * @property integer $ID
 * @property string $DATE_FROM
 * @property string $DATE_TO
 * @property string $NAME
 * @property string $TYPE_PERIOD
 */
class Period extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Periods the static model class
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
		return 'FIN.PERIODS';
	}

	// отдаём соединение, описанное в компоненте db1
        public function getDbConnection(){

	        return Yii::app()->db1;

        }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('DATE_FROM, DATE_TO', 'required'),
			array('NAME', 'length', 'max'=>60),
			array('TYPE_PERIOD', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, DATE_FROM, DATE_TO, NAME, TYPE_PERIOD', 'safe', 'on'=>'search'),
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
			'claims' => array(self::HAS_MANY, 'Claim', 'claim_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'DATE_FROM' => 'Date From',
			'DATE_TO' => 'Date To',
			'NAME' => 'Name',
			'TYPE_PERIOD' => 'Type Period',
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

		$criteria->compare('ID',$this->ID);
		$criteria->compare('DATE_FROM',$this->DATE_FROM,true);
		$criteria->compare('DATE_TO',$this->DATE_TO,true);
		$criteria->compare('NAME',$this->NAME,true);
		$criteria->compare('TYPE_PERIOD',$this->TYPE_PERIOD,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPeriod()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

//		$criteria->compare('ID',$this->ID);
//		$criteria->compare('NAME',$this->NAME,true);
//		$criteria->compare('TYPE_PERIOD',$this->TYPE_PERIOD,true);

//		$criteria->select='ID, NAME';
		$criteria->condition='TYPE_PERIOD=:TYPE_PERIOD';
		$criteria->params=array(':TYPE_PERIOD'=> 'M');

//		$criteria->select = 'date_from > to_date("2011-12-31", "yyyy-mm-dd")';

//		$criteria->condition='DATE_FROM = :DATE_FROM';
//		$criteria->params=array(':DATE_FROM' > "TO_DATE('2011-12-31','dd.mm.yyyy')");

//		return new CActiveDataProvider($this, array(
//			'criteria'=>$criteria,
//		));
		return Periods::model()->findAll($criteria);
	}

// Period.where("type_period = 'M' and date_from > to_date('2011-12-31', 'yyyy-mm-dd')").collect {|d| [d.name, d.id]} 
}