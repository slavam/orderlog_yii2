<?php

/**
 * This is the model class for table "FIN.BUDGET_DIRECTORY".
 *
 * The followings are the available columns in table 'FIN.BUDGET_DIRECTORY':
 * @property integer $ID
 * @property string $CODE
 * @property string $NAME
 * @property string $DESCRIPTION
 * @property integer $PARENT_ID
 * @property string $DATE_ADD
 * @property string $DATE_CLOSED
 * @property integer $BUDGET_GROUPS_ID
 * @property integer $SIGN
 */
class BudgetItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return BudgetItem the static model class
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
		return 'FIN.BUDGET_DIRECTORY';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CODE, NAME, DATE_ADD, BUDGET_GROUPS_ID', 'required'),
			array('PARENT_ID, BUDGET_GROUPS_ID, SIGN', 'numerical', 'integerOnly'=>true),
			array('CODE', 'length', 'max'=>20),
			array('NAME', 'length', 'max'=>255),
			array('DESCRIPTION', 'length', 'max'=>400),
			array('DATE_CLOSED', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, CODE, NAME, DESCRIPTION, PARENT_ID, DATE_ADD, DATE_CLOSED, BUDGET_GROUPS_ID, SIGN', 'safe', 'on'=>'search'),
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
                    'claimLines' => array(self::HAS_MANY, 'ClaimLine', 'budget_item_id'),
                    'assets' => array(self::HAS_MANY, 'Asset', 'budget_item_id'),
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
			'DESCRIPTION' => 'Description',
			'PARENT_ID' => 'Parent',
			'DATE_ADD' => 'Date Add',
			'DATE_CLOSED' => 'Date Closed',
			'BUDGET_GROUPS_ID' => 'Budget Groups',
			'SIGN' => 'Sign',
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
		$criteria->compare('DESCRIPTION',$this->DESCRIPTION,true);
		$criteria->compare('PARENT_ID',$this->PARENT_ID);
		$criteria->compare('DATE_ADD',$this->DATE_ADD,true);
		$criteria->compare('DATE_CLOSED',$this->DATE_CLOSED,true);
		$criteria->compare('BUDGET_GROUPS_ID',$this->BUDGET_GROUPS_ID);
		$criteria->compare('SIGN',$this->SIGN);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function findBudgetItems()
	{
            $criteria=new CDbCriteria;
            $criteria->select="ID, CONCAT('('||CODE||') ',NAME) as NAME";
            $criteria->condition='BUDGET_GROUPS_ID in (9,7)';
            $criteria->order='CODE';
            $budgetItems = BudgetItem::model()->findAll($criteria);
            return CHtml::listData($budgetItems,'ID','NAME');
	}

        public function get2LevelNameBudgetItem($id){
            $sql = "
                select p.name ||' => '||bd.name as name
                from FIN.budget_directory bd 
                join FIN.budget_directory p on bd.parent_id=p.id
                where bd.id=".$id;
            $bi = BudgetItem::model()->findBySql($sql);
            return $bi->NAME;
        }
        
        public function get3LevelAllNameBudgetItem(){
            
            $allBudgetItems = BudgetItem::model()->findBudgetItems();
            
            $data = array();
                
            foreach($allBudgetItems as $key => $value){              
                $article =BudgetItem::model()->findByPk($key);
                $art2name=$this->get2LevelNameBudgetItem($key);
                if ($art2name) {
                    $data[$key] = $art2name." => ".$article->CODE;
                }
            }			
                return $data;
        }

        //temporary - o.lysenko 7.sep.2012 10:27
        //WORKS!!!
        public function get3LevelAllNameBudgetItemOptionList(){

            $sql="
select bd.id as id, p.name ||' => '|| bd.name ||' ('||bd.code||')' as name 
from FIN.budget_directory bd 
join FIN.budget_directory p on bd.parent_id=p.id and bd.BUDGET_GROUPS_ID in (9,7)
order by name
";
//                
            
            //$sql =" select * from FIN.budget_directory";

            $budgetItems = BudgetItem::model()->findAllBySql($sql);

         
            
/*            foreach($budgetItems as $key => $value){              

                $article =BudgetItem::model()->findByPk($key);
                $art2name=$this->get2LevelNameBudgetItem($key);
 
                if ($art2name) {
                    $budgetItems[$key]->NAME = $art2name;//." (".$article->CODE.")";
                }
            }			
*/
                return $budgetItems;

        }

        public function getLimit($period_id, $budget_item_id, $division_id){
            $s = '';
            if ($division_id != '0')
                $s = ' and bv.division_id='.$division_id;
            $sql ='
                select sum(bv.value*bd.sign) as PARENT_ID
                from FIN.budget_value bv
                join FIN.budget_factor bf on bf.id=bv.budget_factor_id
                join FIN.budget_directory bd on bd.id=bf.budget_directory_id 
                    and bd.budget_groups_id in (7,9)       
                where bv.budget_flag_correction_id=41 
                    and bv.periods_id='.$period_id.'
                    and bd.id='.$budget_item_id.$s;
           return BudgetItem::model()->findBySql($sql)->PARENT_ID; 
        }
}