<?php

/**
 * This is the model class for table "FIN.BUDGET_BUSINESS".
 *
 * The followings are the available columns in table 'FIN.BUDGET_BUSINESS':
 * @property integer $ID
 * @property integer $SR_BUSINESS_ID
 * @property string $CODE
 * @property string $NAME
 * @property integer $ORD
 */
class Business extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Business the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        public function getDbConnection(){
	        return Yii::app()->db1;
        }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'FIN.BUDGET_BUSINESS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('SR_BUSINESS_ID, CODE, NAME, ORD', 'required'),
			array('SR_BUSINESS_ID, ORD', 'numerical', 'integerOnly'=>true),
			array('CODE', 'length', 'max'=>4),
			array('NAME', 'length', 'max'=>127),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, SR_BUSINESS_ID, CODE, NAME, ORD', 'safe', 'on'=>'search'),
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
			'claimLines' => array(self::HAS_MANY, 'ClaimLine', 'business_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'SR_BUSINESS_ID' => 'Sr Business',
			'CODE' => 'Code',
			'NAME' => 'Name',
			'ORD' => 'Ord',
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
		$criteria->compare('SR_BUSINESS_ID',$this->SR_BUSINESS_ID);
		$criteria->compare('CODE',$this->CODE,true);
		$criteria->compare('NAME',$this->NAME,true);
		$criteria->compare('ORD',$this->ORD);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
       	public static function findBusinesses()
	{
            $sql = "select bb.ID as ID, sb.CODE||' => '||bb.NAME as NAME from FIN.budget_business bb
                    join fin.sr_busines sb on sb.ID=bb.SR_BUSINESS_ID order by ID";
            $businesses = Business::model()->findAllBySql($sql);
//		$businesses = Business::model()->findAll(array('order' => 'CODE'));
		return CHtml::listData($businesses,'ID','NAME');
	}

       	public static function findBusinessesOptionList()
	{
            $sql = "select bb.ID as ID, sb.CODE||' => '||bb.NAME as NAME from FIN.budget_business bb
                    join fin.sr_busines sb on sb.ID=bb.SR_BUSINESS_ID order by ID";
            return $businesses = Business::model()->findAllBySql($sql);
//		$businesses = Business::model()->findAll(array('order' => 'CODE'));
//		return CHtml::listData($businesses,'ID','NAME');
	}

}