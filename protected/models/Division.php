<?php

/**
 * This is the model class for table "FIN.DIVISION".
 *
 * The followings are the available columns in table 'FIN.DIVISION':
 * @property integer $ID
 * @property string $CODE
 * @property string $NAME
 * @property integer $PARENT_ID
 * @property string $OPEN_DATE
 * @property string $CLOSE_DATE
 * @property string $FACT
 * @property string $PLAN
 * @property integer $CITY_FACTOR_ID
 * @property integer $DIVISION_BRANCH_ID
 * @property integer $ORD
 */
class DIVISION extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DIVISION the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	// отдаём соединение, описанное в компоненте db1
        public function getDbConnection(){

	        return Yii::app()->db1;

        }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'FIN.DIVISION';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('PARENT_ID, CITY_FACTOR_ID, DIVISION_BRANCH_ID, ORD', 'numerical', 'integerOnly'=>true),
			array('CODE', 'length', 'max'=>30),
			array('NAME', 'length', 'max'=>255),
			array('FACT, PLAN', 'length', 'max'=>2),
			array('OPEN_DATE, CLOSE_DATE', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, CODE, NAME, PARENT_ID, OPEN_DATE, CLOSE_DATE, FACT, PLAN, CITY_FACTOR_ID, DIVISION_BRANCH_ID, ORD', 'safe', 'on'=>'search'),
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
			'CODE' => 'Code',
			'NAME' => 'Name',
			'PARENT_ID' => 'Parent',
			'OPEN_DATE' => 'Open Date',
			'CLOSE_DATE' => 'Close Date',
			'FACT' => 'Fact',
			'PLAN' => 'Plan',
			'CITY_FACTOR_ID' => 'City Factor',
			'DIVISION_BRANCH_ID' => 'Division Branch',
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
		$criteria->compare('CODE',$this->CODE,true);
		$criteria->compare('NAME',$this->NAME,true);
		$criteria->compare('PARENT_ID',$this->PARENT_ID);
		$criteria->compare('OPEN_DATE',$this->OPEN_DATE,true);
		$criteria->compare('CLOSE_DATE',$this->CLOSE_DATE,true);
		$criteria->compare('FACT',$this->FACT,true);
		$criteria->compare('PLAN',$this->PLAN,true);
		$criteria->compare('CITY_FACTOR_ID',$this->CITY_FACTOR_ID);
		$criteria->compare('DIVISION_BRANCH_ID',$this->DIVISION_BRANCH_ID);
		$criteria->compare('ORD',$this->ORD);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function All()
	{
		$models = Division::model()->findAll(array('order' => 'CODE'));
		return CHtml::listData($models,'ID','NAME');
	}

	public static function findDivisionById($id)
	{
                return Division::model()->findByPk($id)->NAME;
	}
        public static function findDivisionsWithPrompt()
	{
		$models = Division::model()->findAll(array('order' => 'CODE'));
                $data = array('0'=>'Весь банк');
                foreach($models as $div){
                        $data[$div->ID] = $div->NAME;
                }			
                return $data;
	}

}