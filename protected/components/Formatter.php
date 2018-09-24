<?php
class Formatter extends CFormatter {
	public $booleanState;
	public function formatBooleanState($value){
		return $value ? Yii::t('app', $this->booleanState[1]) : Yii::t('app',$this->booleanState[0]);
	}
	public function formatBoolean($value){
		return $value ? Yii::t('app', $this->booleanFormat[1]) : Yii::t('app',$this->booleanFormat[0]);
	}
}