<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class PlaceForm extends CFormModel
{
	public $town;
	public $place;
	public $add_record;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// town and place are required
			array('town, place', 'required'),
//			array('town', 'MyDataValidator'),
			array('add_record', 'safe'),
		);
	}
/*
        public function MyDataValidator()
        {
        $result = true;
        if (!(isset($_POST['PlaseForm']['town'])) && 
            !(isset($_POST['PlaseForm']['place']))) {      
                $this->addError('News date','Incorrect date.');                 
                $result = false;
            }
        return $result;

        }
*/
        
        /**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
                	'town' => 'Город',
                        'place' => 'Место расположения',

		);
	}
}