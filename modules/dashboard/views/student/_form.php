<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\Student $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="student-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card comman-shadow">
                <div class="card-body">

                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="form-group local-forms">
                                <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter First Name'])->label('First Name <span class="login-danger">*</span>') ?>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4">
                            <div class="form-group local-forms">
                                <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Middle Name'])->label('Middle Name') ?>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4">
                            <div class="form-group local-forms">
                                <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Last Name'])->label('Last Name <span class="login-danger">*</span>') ?>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4">
                            <div class="form-group local-forms">
                                <?= $form->field($model, 'gender')->dropDownList([
                                    'Male' => 'Male',
                                    'Female' => 'Female',
                                    'Other' => 'Other',
                                ], ['prompt' => 'Select Gender'])->label('Gender <span class="login-danger">*</span>') ?>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4">
                            <div class="form-group local-forms calendar-icon">
                                <?= $form->field($model, 'date_of_birth')->widget(DatePicker::classname(), [
                                    'options' => ['placeholder' => 'Enter birth date ...'],
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'dd-M-yyyy',
                                    ],
                                ])->label('Date Of Birth <span class="login-danger">*</span>') ?>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4">
                            <div class="form-group local-forms">
                                <?= $form->field($model, 'religion')->dropDownList([
                                    'Christianity' => 'Christianity',
                                    'Islam' => 'Islam',
                                    'Hinduism' => 'Hinduism',
                                    'Buddhism' => 'Buddhism',
                                    'Judaism' => 'Judaism',
                                    'Other' => 'Other',
                                ], ['prompt' => 'Select Religion'])->label('Religion <span class="login-danger">*</span>') ?>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4">
                            <div class="form-group local-forms">
                                <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Enter Email Address'])->label('E-Mail <span class="login-danger">*</span>') ?>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4">
                            <div class="form-group local-forms">
                                <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => 'Enter Phone Number'])->label('Phone') ?>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4">
                            <div class="form-group local-forms">
                                <?= $form->field($model, 'address')->textInput(['rows' => 6])->label('Address') ?>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4">
                            <div class="form-group local-forms">
                                <?= $form->field($model, 'status')->dropDownList([
                                    '10' => 'Active',
                                    '9' => 'Inactive',
                                ], ['prompt' => 'Select Status'])->label('Status') ?>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="student-submit">
                                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                            </div>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>