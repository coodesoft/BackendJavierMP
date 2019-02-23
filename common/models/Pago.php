<?php
namespace common\models;

use Yii;

class Pago extends \yii\db\ActiveRecord{

  public $errors = '';

  public function create(){
    if ($this->amount      == ''){ $this->errors='Monto no ingresado'; return false; }
    if ($this->amount      <  0 ){ $this->errors='Monto tiene que ser mayor a cero'; return false; }
    if ($this->description == ''){ $this->errors='Descripción no ingresada'; return false; }
    if ($this->email       == ''){ $this->errors='E-Mail no ingresado'; return false; }

    $this->doc_type      = '-';
    $this->doc_number    = '-';
    $this->created       = date('Y-m-d H-i-s');
    $this->status        = '-';
    $this->preference_id = '-';

    return $this->save();
  }

  public static function tableName(){ return 'Pago'; }

  public function rules()
  {
      return [];
  }

  public function attributeLabels()
  {
      return [
          'id'            => 'ID',
          'id_creator'    => 'Creador del pago',
          'amount'        => 'Monto',
          'description'   => 'Descripcion',
          'email'         => 'E-Mail',
          'doc_type'      => 'Tipo Documento',
          'doc_number'    => 'Numero Documento',
          'created'       => 'Creado el',
          'status'        => 'Estado',
          'preference_id' => 'Id Preferencia Mercado Pago',
      ];
  }
}
