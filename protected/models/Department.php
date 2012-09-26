<?php

/**
 * This is the model class for table "div2doc".
 *
 * The followings are the available columns in table 'div2doc':
 * @property integer $ID_DIVISION
 * @property integer $PARENT_ID
 * @property string $DIVISION
 * @property string $CODE_DIVISION
 */
class Department extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Department the static model class
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
		return 'div2doc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID_DIVISION, DIVISION', 'required'),
			array('ID_DIVISION, PARENT_ID', 'numerical', 'integerOnly'=>true),
			array('DIVISION', 'length', 'max'=>64),
			array('CODE_DIVISION', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID_DIVISION, PARENT_ID, DIVISION, CODE_DIVISION', 'safe', 'on'=>'search'),
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
//                    'claims' => array(self::HAS_MANY, 'Claim', 'department_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
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

		$criteria->compare('ID_DIVISION',$this->ID_DIVISION);
		$criteria->compare('PARENT_ID',$this->PARENT_ID);
		$criteria->compare('DIVISION',$this->DIVISION,true);
		$criteria->compare('CODE_DIVISION',$this->CODE_DIVISION,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public static function findDepartments()
	{
		$departmens = Department::model()->findAll(array('order' => 'CODE_DIVISION'));
//                return CHtml::listData($departmens,'ID_DIVISION','DIVISION');
                $data = array();
                foreach($departmens as $d){
                        $data[$d->ID_DIVISION] = $d->CODE_DIVISION." ".$d->DIVISION;
                }			
                return $data;
	}
       public static function findDepartmentsByDivision($division_id)
	{
            $division = DIVISION::model()->findByPk($division_id);
            $criteria=new CDbCriteria;
            $criteria->condition="CODE_DIVISION like '".$division->CODE."%'";
            $criteria->order='CODE_DIVISION';
            $departmens = Department::model()->findAll($criteria);
            $data = array();
            foreach($departmens as $d){
                    $data[$d->ID_DIVISION] = $d->CODE_DIVISION." ".$d->DIVISION;
            }			
            return $data;
	}

        public function findDepartment($departmen_id)
	{
            if ($departmen_id<1) return '';
            $sql = 'with Hierachy(ID_DIVISION, PARENT_ID, DIVISION, Level)
                as
                (
                select ID_DIVISION, PARENT_ID, DIVISION, 0 as Level
                    from div2doc c
                    where c.ID_DIVISION = '.$departmen_id.' 
                    union all
                    select c.ID_DIVISION, c.PARENT_ID, c.DIVISION, ch.Level + 1
                    from div2doc c
                    inner join Hierachy ch
                    on ch.parent_id = c.ID_DIVISION
                )
                select ID_DIVISION, PARENT_ID, DIVISION
                from Hierachy
                where Level >= 0 order by Level desc';
            $departments = Department::model()->findAllBySql($sql);
            $s = '';
            foreach ($departments as $d) {
                $s .= $d->DIVISION.'; ';
            }
            return $s;
	}

        public function primaryKey()
        {
            return 'ID_DIVISION';
        }
        
        public function findDepartmentHiLow($code_div)
	{
            if ($code_div<1) return '';
            $sql = "with Hierachy (ID_DIVISION, PARENT_ID, DIVISION, Level) 
            as 
            (
            	select
					ID_DIVISION, PARENT_ID, DIVISION, 0 as Level
					from div2doc c 
					where c.CODE_DIVISION='".$code_div."' 
					union all 
					select c.ID_DIVISION, c.PARENT_ID, c.DIVISION, ch.Level + 1
	            from div2doc c 
	            inner join Hierachy ch 
	            on ch.PARENT_ID = c.ID_DIVISION
            ) 
            select ID_DIVISION, PARENT_ID, DIVISION
            from Hierachy 
            where Level >= 0 order by Level desc";

            $departments = Department::model()->findAllBySql($sql);
            $s = '';
            foreach ($departments as $d) {
                $s .= $d->DIVISION.'; ';
            }
            return $s;
	}

}