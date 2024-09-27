<?php

namespace app\modules\dashboard\models;

use app\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "student".
 *
 * @property int $id
 * @property int $user_id
 * @property int $admission_no
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string|null $gender
 * @property string|null $religion
 * @property int|null $date_of_birth
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Attendance[] $attendances
 * @property FeeInvoice[] $feeInvoices
 * @property Guardian[] $guardians
 * @property StudentClass[] $studentClasses
 * @property User $user
 */
class Student extends \yii\db\ActiveRecord
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
        return 'student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'admission_no', 'first_name', 'middle_name', 'last_name', 'date_of_birth', 'last_name'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['address'], 'string'],
            [['first_name', 'middle_name', 'last_name', 'gender', 'religion', 'email', 'phone'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 20],
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
            'admission_no' => 'Admission No',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'gender' => 'Gender',
            'religion' => 'Religion',
            'date_of_birth' => 'Date Of Birth',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    public static function generateAdmissionNo()
    {
        $year = date('Y');
        $prefix = 'STD/';
        $yearPrefix = '/' . $year;

        // Get the maximum admission number from the database
        $lastRecord = self::find()
            ->select(['admission_no'])
            ->orderBy(['admission_no' => SORT_DESC])
            ->limit(1)
            ->one();

        // Extract the last number from the highest admission number
        if ($lastRecord && preg_match('/(\d{5})\/' . $year . '$/', $lastRecord->admission_no, $matches)) {
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
        return $this->hasMany(Attendance::class, ['student_id' => 'id']);
    }

    /**
     * Gets query for [[FeeInvoices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeeInvoices()
    {
        return $this->hasMany(FeeInvoice::class, ['student_id' => 'id']);
    }

    /**
     * Gets query for [[Guardians]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGuardians()
    {
        return $this->hasMany(Guardian::class, ['student_id' => 'id']);
    }

    /**
     * Gets query for [[StudentClasses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentClasses()
    {
        return $this->hasMany(StudentClass::class, ['student_id' => 'id']);
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
