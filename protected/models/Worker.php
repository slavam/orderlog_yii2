<?php

/**
 * This is the model class for table "emp2doc".
 *
 * The followings are the available columns in table 'emp2doc':
 * @property integer $ID_EMP
 * @property string $TABN
 * @property string $LASTNAME
 * @property string $FIRSTNAME
 * @property string $SONAME
 * @property string $LASTNAME_u
 * @property string $FIRSTNAME_u
 * @property string $SONAME_u
 * @property string $NAL_NUM
 * @property integer $GENDER
 * @property string $PAS_SERIAL
 * @property string $PAS_NUM
 * @property string $PAS_DATE
 * @property string $PAS_FBI
 * @property string $ADATE
 * @property string $NATIONALITY
 * @property string $EMAIL
 * @property string $STAFF
 * @property string $STAFFNAME
 * @property integer $ID_DIVISION
 * @property integer $PARENT_ID
 * @property string $DIVISION
 * @property string $CODE_DIVISION
 */
class Worker extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Worker the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        public function getDbConnection(){
	        return Yii::app()->db4;
        }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'emp2doc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_EMP, GENDER, ADATE, STAFF, STAFFNAME, ID_DIVISION, DIVISION', 'required'),
			array('ID_EMP, GENDER, ID_DIVISION, PARENT_ID', 'numerical', 'integerOnly'=>true),
			array('TABN, PAS_SERIAL', 'length', 'max'=>8),
			array('LASTNAME, FIRSTNAME, SONAME, LASTNAME_u, FIRSTNAME_u, SONAME_u, NATIONALITY, CODE_DIVISION', 'length', 'max'=>32),
			array('NAL_NUM, PAS_NUM', 'length', 'max'=>16),
			array('PAS_FBI, EMAIL', 'length', 'max'=>255),
			array('STAFF, STAFFNAME, DIVISION', 'length', 'max'=>64),
			array('PAS_DATE', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID_EMP, TABN, LASTNAME, FIRSTNAME, SONAME, LASTNAME_u, FIRSTNAME_u, SONAME_u, NAL_NUM, GENDER, PAS_SERIAL, PAS_NUM, PAS_DATE, PAS_FBI, ADATE, NATIONALITY, EMAIL, STAFF, STAFFNAME, ID_DIVISION, PARENT_ID, DIVISION, CODE_DIVISION', 'safe', 'on'=>'search'),
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
			'claimLines' => array(self::HAS_MANY, 'ClaimLine', 'for_whom'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID_EMP' => 'Id Emp',
			'TABN' => 'Tabn',
			'LASTNAME' => 'Lastname',
			'FIRSTNAME' => 'Firstname',
			'SONAME' => 'Soname',
			'LASTNAME_u' => 'Lastname U',
			'FIRSTNAME_u' => 'Firstname U',
			'SONAME_u' => 'Soname U',
			'NAL_NUM' => 'Nal Num',
			'GENDER' => 'Gender',
			'PAS_SERIAL' => 'Pas Serial',
			'PAS_NUM' => 'Pas Num',
			'PAS_DATE' => 'Pas Date',
			'PAS_FBI' => 'Pas Fbi',
			'ADATE' => 'Adate',
			'NATIONALITY' => 'Nationality',
			'EMAIL' => 'Email',
			'STAFF' => 'Staff',
			'STAFFNAME' => 'Staffname',
			'ID_DIVISION' => 'Id Division',
			'PARENT_ID' => 'Parent',
			'DIVISION' => 'Division',
			'CODE_DIVISION' => 'Code Division',
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

		$criteria->compare('ID_EMP',$this->ID_EMP);
		$criteria->compare('TABN',$this->TABN,true);
		$criteria->compare('LASTNAME',$this->LASTNAME,true);
		$criteria->compare('FIRSTNAME',$this->FIRSTNAME,true);
		$criteria->compare('SONAME',$this->SONAME,true);
		$criteria->compare('LASTNAME_u',$this->LASTNAME_u,true);
		$criteria->compare('FIRSTNAME_u',$this->FIRSTNAME_u,true);
		$criteria->compare('SONAME_u',$this->SONAME_u,true);
		$criteria->compare('NAL_NUM',$this->NAL_NUM,true);
		$criteria->compare('GENDER',$this->GENDER);
		$criteria->compare('PAS_SERIAL',$this->PAS_SERIAL,true);
		$criteria->compare('PAS_NUM',$this->PAS_NUM,true);
		$criteria->compare('PAS_DATE',$this->PAS_DATE,true);
		$criteria->compare('PAS_FBI',$this->PAS_FBI,true);
		$criteria->compare('ADATE',$this->ADATE,true);
		$criteria->compare('NATIONALITY',$this->NATIONALITY,true);
		$criteria->compare('EMAIL',$this->EMAIL,true);
		$criteria->compare('STAFF',$this->STAFF,true);
		$criteria->compare('STAFFNAME',$this->STAFFNAME,true);
		$criteria->compare('ID_DIVISION',$this->ID_DIVISION);
		$criteria->compare('PARENT_ID',$this->PARENT_ID);
		$criteria->compare('DIVISION',$this->DIVISION,true);
		$criteria->compare('CODE_DIVISION',$this->CODE_DIVISION,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        	public static function findWorkers()
	{
		$workers = Worker::model()->findAll(array('order' => 'LASTNAME, FIRSTNAME, SONAME'));
                $data = array(''=>'Задайте сотрудника');
                foreach($workers as $employer){
                        $data[$employer->ID_EMP] = $employer->LASTNAME." ".$employer->FIRSTNAME." ".$employer->SONAME;
                }			
                return $data;
	}

        	public static function findWorkersWithStaff()
	{
		$workers = Worker::model()->findAll(array('order' => 'LASTNAME, FIRSTNAME, SONAME'));
//                $data = array(''=>'Задайте сотрудника');
                foreach($workers as $key => $value){
                        $workers[$key]->LASTNAME = $workers[$key]->LASTNAME." ".$workers[$key]->FIRSTNAME." ".$workers[$key]->SONAME.", ".$workers[$key]->STAFF;
                }			
                return $workers;
	}

}