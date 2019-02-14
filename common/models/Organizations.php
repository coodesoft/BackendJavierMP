<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "organizations".
 *
 * @property int $id
 * @property string $Code
 * @property string $Name
 * @property string $Type
 * @property string $Enrollment_code
 * @property string $Created
 * @property string $Updated
 */
class Organizations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Organizations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Created', 'Updated'], 'safe'],
            [['Code'], 'string', 'max' => 10],
            [['Name'], 'string', 'max' => 40],
            [['Type'], 'string', 'max' => 1],
            [['Enrollment_code'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Code' => 'Code',
            'Name' => 'Name',
            'Type' => 'Type',
            'Enrollment_code' => 'Enrollment Code',
            'Created' => 'Created',
            'Updated' => 'Updated',
        ];
    }
}
