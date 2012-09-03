<?php

/**
 * This is the model class for table "claim_line_products".
 *
 * The followings are the available columns in table 'claim_line_products':
 * @property integer $id
 * @property integer $claim_line_id
 * @property integer $product_id
 */
class ClaimLineProduct extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ClaimLineProduct the static model class
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
		return 'claim_line_products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('claim_line_id', 'required'),
			array('claim_line_id, product_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, claim_line_id, product_id', 'safe', 'on'=>'search'),
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
                    'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'claim_line_id' => 'Claim Line',
			'product_id' => 'Product',
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
		$criteria->compare('claim_line_id',$this->claim_line_id);
		$criteria->compare('product_id',$this->product_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function findProductsByDirection($direction_id)
        {
            $criteria=new CDbCriteria;
            $criteria->condition="direction_id=".$direction_id;
            $claim_line_products = Product::model()->findAll($criteria);
            return CHtml::listData($claim_line_products,'id','name');
        }
}