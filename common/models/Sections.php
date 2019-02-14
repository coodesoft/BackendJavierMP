<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Sections".
 *
 * @property int $id
 * @property string $Code
 * @property string $Name
 * @property string $Description
 *
 * @property OrganizationSection[] $organizationSections
 */
class Sections extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Sections';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Code', 'Name', 'Description'], 'required'],
            [['Code'], 'string', 'max' => 5],
            [['Name'], 'string', 'max' => 30],
            [['Description'], 'string', 'max' => 100],
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
            'Description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationSections()
    {
        return $this->hasMany(OrganizationSection::className(), ['SectionId' => 'id']);
    }
}
