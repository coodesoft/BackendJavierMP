<?php
namespace common\models;

use Yii;
use common\models\Organizations;
use common\models\Users;
/**
 * This is the model class for table "usersinorganization".
 *
 * @property int $id
 * @property int $OrganizationId
 * @property int $UserId
 *
 * @property Organizations $organization
 * @property Users $user
 */
class Usersinorganization extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'UsersInOrganization';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['OrganizationId', 'UserId'], 'required'],
            [['OrganizationId', 'UserId'], 'integer'],
            [['OrganizationId'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['OrganizationId' => 'id']],
            [['UserId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['UserId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => Yii::t('app', 'ID'),
            'OrganizationId' => Yii::t('app', 'Organization ID'),
            'UserId'         => Yii::t('app', 'User ID'),
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
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'UserId']);
    }
}
