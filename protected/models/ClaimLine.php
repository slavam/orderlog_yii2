<?php

/**
 * This is the model class for table "claim_lines".
 *
 * The followings are the available columns in table 'claim_lines':
 * @property integer $id
 * @property integer $claim_id
 * @property integer $count
 * @property double $amount
 * @property string $description
 * @property integer $for_whom
 * @property integer $state_id
 * @property string $change_date
 * @property integer $budget_item_id
 * @property integer $asset_id
 * @property double $cost
 * @property integer $business_id
 *
 * The followings are the available model relations:
 * @property AccountLines[] $accountLines
 */
class ClaimLine extends CActiveRecord
{
    
    /**
	 * Returns the static model of the specified AR class.
	 * @return ClaimLine the static model class
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
            return 'claim_lines';
	}

       	public function findWorker($worker_id)
	{
            $worker = Worker::model()->find('ID_EMP=:ID_EMP', array(':ID_EMP'=>$worker_id));
            return CHtml::encode($worker->LASTNAME." ".$worker->FIRSTNAME." ".$worker->SONAME.", ".$worker->STAFF); 
	}

      	public function findWorkerDepartment2levels($worker_id)
	{
            $worker = Worker::model()->find('ID_EMP=:ID_EMP', array(':ID_EMP'=>$worker_id));
            
//            return CHtml::encode(Claim::model()->findDepartmentHiLow($worker->CODE_DIVISION)); 
            return Claim::model()->findDepartmentHiLow($worker->CODE_DIVISION); 

	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('claim_id', 'required'),
			array('claim_id, count, for_whom, state_id, budget_item_id, asset_id, business_id, position_id, payer_id, purpose_id', 'numerical', 'integerOnly'=>true),
			array('amount, cost', 'numerical'),
			array('description, change_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, claim_id, count, amount, description, for_whom, state_id, change_date, budget_item_id, asset_id, cost, business_id, position_id, payer_id, purpose_id', 'safe', 'on'=>'search'),
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
                    'accountLines' => array(self::HAS_MANY, 'AccountLines', 'clime_line_id'),
                    'asset' => array(self::BELONGS_TO, 'Asset', 'asset_id'),
                    'claim' => array(self::BELONGS_TO, 'Claim', 'claim_id'),
                    'claim_sum' => array(self::HAS_ONE, 'Claim', 'claim_id'),
                    'business' => array(self::BELONGS_TO, 'Business', 'business_id'),
                    'position' => array(self::BELONGS_TO, 'Place', 'position_id'),
                    'budgetItem' => array(self::BELONGS_TO, 'BudgetItem', 'budget_item_id'),
                    'worker' => array(self::BELONGS_TO, 'Worker', 'for_whom'),
                    'status' => array(self::BELONGS_TO, 'Status', 'status_id'),
                    'complect' => array(self::BELONGS_TO, 'Complect', 'complect_id'),
                    'payer' => array(self::BELONGS_TO, 'Division', 'payer_id'),
                    'purpose' => array(self::BELONGS_TO, 'Purpose', 'purpose_id')
//                    'claim_sum'=>array(self::HAS_MANY,'Claim','claime_id',)
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'claim_id' => 'Claim',
			'count' => 'Count',
			'amount' => 'Amount',
			'description' => 'Description',
			'for_whom' => 'For Whom',
			'state_id' => 'State',
			'change_date' => 'Change Date',
			'budget_item_id' => 'Budget Item',
			'asset_id' => 'Asset',
			'cost' => 'Cost',
			'business_id' => 'Business',
                        'position_id' => 'Position',
                        'payer_id' => 'Payer',
                        'purpose_id' => 'Purpose',
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
		$criteria->compare('claim_id',$this->claim_id);
		$criteria->compare('count',$this->count);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('for_whom',$this->for_whom);
		$criteria->compare('state_id',$this->state_id);
		$criteria->compare('change_date',$this->change_date,true);
		$criteria->compare('budget_item_id',$this->budget_item_id);
		$criteria->compare('asset_id',$this->asset_id);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('business_id',$this->business_id);
                $criteria->compare('position_id',$this->position_id);
                $criteria->compare('payer_id', $this->payer_id);
                $criteria->compare('purpose_id', $this->purpose_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function findConsolidatedClaimLines($period_id, $direction_id)
        {
            $lines = ClaimLine::model()->findAllBySql('select * from claim_lines c_l 
                join claims c on c.id=c_l.claim_id and c.period_id ='.$period_id.' and c.state_id=2 and c.direction_id='.$direction_id);
            return $lines;
        }
        
        public function findAddress($address_id)
	{
            $position = Place::model()->findAllBySql("
                WITH RECURSIVE temp1 ( id, parent_id, title, PATH, LEVEL ) AS (
                  SELECT T1.id, T1.parent_id, T1.title as name, CAST (T1.title AS VARCHAR(150)) as PATH, 1
                    FROM places T1 WHERE T1.parent_id IS NULL
                  union
                    select T2.id, T2.parent_id, T2.title, CAST( temp1.PATH ||', '|| T2.title AS VARCHAR(150)), LEVEL + 1
                      FROM places T2 INNER JOIN temp1 ON( temp1.id= T2.parent_id)      )
                  select path as title from temp1 where id=".$address_id);
            return CHtml::encode($position[0]->title); 
	}

        public function findProductsAsString($claim_line_id,$type='string')
        {
            if ($claim_line_id>'')
            {
                $criteria=new CDbCriteria;
                $criteria->condition="claim_line_id=".$claim_line_id;
                $claim_line_products = ClaimLineProduct::model()->findAll($criteria);
                 switch ($type)
                {
                    case 'string':
                    $res = '';
                    foreach ($claim_line_products as $e) {
                        $ress .= $e->product->name.'; ';
                    }
                    break;
                    case 'id':
                        $res=array();
                        foreach ($claim_line_products as $f)
                        {
                            $res[]=$f->id;
                        }
                        break;
                }
            } else {
                $res='';
            }
            return $res;
        }
        public function findFeaturesAsString($claim_line_id,$type='string')
        {
            if ($claim_line_id>'')
            {
                $criteria=new CDbCriteria;
                $criteria->condition="claim_line_id=".$claim_line_id;
                $claim_line_features = ClaimLineFeature::model()->findAll($criteria);
                
                switch ($type)
                {
                    case 'string':
                    $res = '';
                    foreach ($claim_line_features as $e) {
                        $res .= $e->feature->name.'; ';
                    }
                    break;
                    
                    case 'id':
                        $res=array();
                        foreach ($claim_line_features as $f)
                        {
                            $res[]=$f->id;
                        }
                        break;
                }
            } 
            else {$res='';}
            
            return $res;
        }

        public function getBusinessName($business_id)
        {
            $sql = "select sb.CODE||' => '||bb.NAME as NAME from FIN.budget_business bb
                    join fin.sr_busines sb on sb.id=bb.sr_business_id and bb.id=".$business_id;
            $business = Business::model()->findBySql($sql);
            return $business->NAME;
        }
        
        
        
//        public function $this.findConsolidatedClaimLines($period_id, $direction_id)
//        {
//            return nil;
            //$this->findAllBySql('select * from claim_lines c_l join claims c on c.id=c_l.claim_id and c.period_id =1844 and c.state_id=2 and c.direction_id=1');
//            return $this->with('claim')->findAll(array(
//                'condition'=>'claim.state_id=2 and claim.direction_id=1'
            //));
//            @period = Period.find params[:claim_params][:period_id]
//    @direction = Direction.find params[:claim_params][:direction_id]
//    claims = Claim.select("distinct(division_id)").where("state_id=2 and period_id=? and direction_id=?",@period.id, @direction.id)
//    division_ids = []
//    claims.each {|d| division_ids << d.division_id}
//    query = "select sum(cl.count) as quantity, sum(cl.amount) as amount, cl.budget_item_id, '' as article, 0 as limit from claims c
//      join claim_lines cl on cl.claim_id=c.id
//      where c.direction_id = "+@direction.id.to_s+" and period_id="+@period.id.to_s+" and c.state_id = 2
//      group by cl.budget_item_id"
//    @claim_lines = Claim.find_by_sql(query)
//    @claim_lines.each {|cl|
//      query = "select sum(bv.value*bd.sign) as limit from FIN.budget_value bv
//        join FIN.budget_factor bf on bf.id=bv.budget_factor_id
//        join FIN.budget_directory bd on bd.id=bf.budget_directory_id and bd.budget_groups_id in (7,9)
//        -- join FIN.budget_business bb on bb.id=bf.budget_business_id
//        where bv.budget_flag_correction_id=1 and bv.division_id in ("+division_ids.join(',')+") and bv.periods_id="+@period.id.to_s
//      budget_limit = BudgetItem.find_by_sql(query).first
//      b_i = BudgetItem.select("name, id").find cl.budget_item_id
//      cl.article = b_i.name
//      cl.budget_item_id = b_i.id
//      cl.limit = (budget_limit ? budget_limit.limit : 0)
//    }
//
            
            
//        }

}