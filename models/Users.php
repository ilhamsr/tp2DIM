<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id_user
 * @property string $nama_user
 * @property string $email
 * @property string $password
 * @property string $birthdate
 * @property string $alamat
 * @property int $id_role
 *
 * @property Role $role
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_user', 'email', 'password', 'birthdate', 'alamat', 'id_role'], 'required'],
            [['birthdate'], 'safe'],
            [['id_role'], 'integer'],
            [['nama_user', 'email'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 16],
            [['alamat'], 'string', 'max' => 200],
            [['id_role'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['id_role' => 'id_role']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'nama_user' => 'Nama User',
            'email' => 'Email',
            'password' => 'Password',
            'birthdate' => 'Birthdate',
            'alamat' => 'Alamat',
            'id_role' => 'Id Role',
        ];
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id_role' => 'id_role']);
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
    }
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    // Implement the getId method
    public function getId()
    {
        return $this->id_user;
    }

    // Implement the getAuthKey method
    public function getAuthKey()
    {
        return "test101key";
    }

    // Implement the validateAuthKey method
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
}

