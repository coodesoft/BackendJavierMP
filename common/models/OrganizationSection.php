<?php
namespace common\models;

use Yii;
use common\models\Sections;

class OrganizationSection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'OrganizationSection';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['OrganizationId', 'SectionId', 'MaxInsuredAmount', 'MaxBrokerFee', 'AgentEnrollmentCode', 'AgentFee'], 'required'],
            [['OrganizationId', 'SectionId', 'AgentEnrollmentCode'], 'integer'],
            [['MaxInsuredAmount', 'MaxBrokerFee', 'AgentFee'], 'number'],
            [['OrganizationId'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['OrganizationId' => 'id']],
            [['SectionId'], 'exist', 'skipOnError' => true, 'targetClass' => Sections::className(), 'targetAttribute' => ['SectionId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'OrganizationId' => 'Organization ID',
            'SectionId' => 'Section ID',
            'MaxInsuredAmount' => 'Max Insured Amount',
            'MaxBrokerFee' => 'Max Broker Fee',
            'AgentEnrollmentCode' => 'Agent Enrollment Code',
            'AgentFee' => 'Agent Fee',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(Organizations::className(), ['id' => 'OrganizationId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Sections::className(), ['id' => 'SectionId']);
    }
}
