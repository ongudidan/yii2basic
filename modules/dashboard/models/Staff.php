<?php

namespace app\modules\dashboard\models;

use app\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "staff".
 *
 * @property string $id
 * @property string $user_id
 * @property string $staff_no
 * @property string $first_name
 * @property string $last_name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $position
 * @property int|null $date_hired
 * @property string|null $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Attendance[] $attendances
 * @property User $user
 */
class Staff extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'staff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'staff_no', 'first_name', 'email', 'phone', 'position', 'last_name'], 'required'],
            [['address'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['id', 'user_id', 'staff_no', 'first_name', 'last_name', 'email', 'phone', 'position'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 20],
            [['id'], 'unique'],
            [['email'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'staff_no' => 'Staff No',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'position' => 'Position',
            'date_hired' => 'Date Hired',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    public static function generateStaffNo()
    {
        $year = date('Y');
        $prefix = 'STAFF/';
        $yearPrefix = '/' . $year;

        // Get the maximum admission number from the database
        $lastRecord = self::find()
            ->select(['staff_no'])
            ->orderBy(['staff_no' => SORT_DESC])
            ->limit(1)
            ->one();

        // Extract the last number from the highest admission number
        if ($lastRecord && preg_match('/(\d{5})\/' . $year . '$/', $lastRecord->staff_no, $matches)) {
            $lastNumber = intval($matches[1]);
        } else {
            $lastNumber = 0; // Default to 0 if no records found
        }

        // Increment the last number to create a new number
        $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

        return $prefix . $newNumber . $yearPrefix;
    }

    /**
     * Gets query for [[Attendances]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttendances()
    {
        return $this->hasMany(Attendance::class, ['staff_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
