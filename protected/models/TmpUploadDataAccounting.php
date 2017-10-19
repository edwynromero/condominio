<?php

/**
 * This is the model class for table "tmp_upload_data_accounting".
 *
 * The followings are the available columns in table 'tmp_upload_data_accounting':
 * @property integer $id_concept
 * @property string $date
 * @property integer $months
 * @property integer $account
 * @property string $credt
 * @property string $debt
 * @property string $journal
 * @property integer $id_journal
 * @property string $parc
 */
class TmpUploadDataAccounting extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tmp_upload_data_accounting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_concept, months, account, id_journal', 'numerical', 'integerOnly'=>true),
			array('date', 'length', 'max'=>10),
			array('credt, debt', 'length', 'max'=>8),
			array('journal', 'length', 'max'=>28),
			array('parc', 'length', 'max'=>22),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_concept, date, months, account, credt, debt, journal, id_journal, parc', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_concept' => 'Id Concept',
			'date' => 'Date',
			'months' => 'Months',
			'account' => 'Account',
			'credt' => 'Credt',
			'debt' => 'Debt',
			'journal' => 'Journal',
			'id_journal' => 'Id Journal',
			'parc' => 'Parc',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_concept',$this->id_concept);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('months',$this->months);
		$criteria->compare('account',$this->account);
		$criteria->compare('credt',$this->credt,true);
		$criteria->compare('debt',$this->debt,true);
		$criteria->compare('journal',$this->journal,true);
		$criteria->compare('id_journal',$this->id_journal);
		$criteria->compare('parc',$this->parc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TmpUploadDataAccounting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
