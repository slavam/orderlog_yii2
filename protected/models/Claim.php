<?php

/**
 * This is the model class for table "claims".
 *
 * The followings are the available columns in table 'claims':
 * @property integer $id
 * @property string $claim_number
 * @property integer $division_id
 * @property string $create_date
 * @property boolean $budgetary
 * @property integer $direction_id
 * @property integer $state_id
 * @property integer $period_id
 * @property string $comment
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Accounts[] $accounts
 * @property Directions $direction
 * @property States $state
 */
class Claim extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Claim the static model class
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
		return 'claims';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('claim_number, division_id, create_date', 'required'),
			array('division_id, direction_id, state_id, period_id, department_id', 'numerical', 'integerOnly'=>true),
			array('budgetary, comment, description, department_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, claim_number, division_id, create_date, budgetary, direction_id, state_id, period_id, comment, description, department_id', 'safe', 'on'=>'search'),
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
                    'accounts' => array(self::HAS_MANY, 'Accounts', 'claim_id'),
                    'direction' => array(self::BELONGS_TO, 'Direction', 'direction_id'),
                    'division' => array(self::BELONGS_TO, 'Division', 'division_id'),
                    'period' => array(self::BELONGS_TO, 'Period', 'period_id'),
                    'state' => array(self::BELONGS_TO, 'State', 'state_id'),
                    'claimLines' => array(self::HAS_MANY, 'ClaimLine', 'claim_id'),
                    'department' => array(self::BELONGS_TO, 'Department', 'department_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                    'id' => 'ID',
                    'claim_number' => 'Claim Number',
                    'division_id' => 'Division',
                    'create_date' => 'Create Date',
                    'budgetary' => 'Budgetary',
                    'direction_id' => 'Direction',
                    'state_id' => 'State',
                    'period_id' => 'Period',
                    'comment' => 'Comment',
                    'description' => 'Description',
                    'department_id' => 'Department',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('claim_number',$this->claim_number,true);
		$criteria->compare('division_id',$this->division_id);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('budgetary',$this->budgetary);
		$criteria->compare('direction_id',$this->direction_id);
		$criteria->compare('state_id',$this->state_id);
		$criteria->compare('period_id',$this->period_id);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('description',$this->description,true);
                $criteria->compare('department_id',  $this->department_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
        
        public function reportGroup()
        {
//            $sql="Select a.name as aname, cl.amount as clamount, cl.count as clcount, ag.name as agname FROM claims c INNER JOIN claim_lines cl ON cl.claim_id = c.id 
//                INNER JOIN assets a ON cl.asset_id=a.id 
//                INNER JOIN asset_groups ag ON a.asset_group_id = ag.id 
//                WHERE c.direction_id=1 AND c.period_id=1841";
            
            $criteria = new CDbCriteria;
            $criteria->addCondition('c.direction_id=1');
            $criteria->addCondition('c.period_id=1841');
            $criteria->alias='c';
            $criteria->group='agname, aname, aid';
            $criteria->select='a.name as aname, SUM(cl.amount) as clamount, SUM(cl.count) as clcount, ag.name as agname, a.id as aid';
            $criteria->join="INNER JOIN claim_lines cl ON cl.claim_id = c.id INNER JOIN assets a ON cl.asset_id=a.id INNER JOIN asset_groups ag ON a.asset_group_id = ag.id" ;
//            $criteria->with=array('claim_sum','asset','asset.assetgroup'=>array('alias'=>'ag'));
            
            $reportDataSet = findAll($criteria);
            return $reportDataSet;
        }
        
        public function afterDelete() {
            parent::afterDelete();

            $lines = ClaimLine::model()->deleteAllByAttributes(array('claim_id'=>$this->id));
        }
}