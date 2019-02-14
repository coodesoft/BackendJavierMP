<?php
namespace common\models;

use Yii;
use common\models\Roles;
use common\models\Users;
/**
 * This is the model class for table "usersinrole".
 *
 * @property int $id
 * @property int $RoleId
 * @property int $UserId
 *
 * @property Roles $role
 * @property Users $user
 */
class UsersInRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'UsersInRole';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['RoleId', 'UserId'], 'required'],
            [['RoleId', 'UserId'], 'integer'],
            [['RoleId'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::className(), 'targetAttribute' => ['RoleId' => 'id']],
            [['UserId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['UserId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'RoleId' => 'Role ID',
            'UserId' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Roles::className(), ['id' => 'RoleId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'UserId']);
    }
}
