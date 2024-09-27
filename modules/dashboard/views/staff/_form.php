<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\Staff $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="staff-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter First Name'])->label('First Name <span class="login-danger">*</span>', ['class' => 'control-label']) ?>
                        </div>
                        <div class="col-12 col-sm-6">
                            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Last Name'])->label('Last Name <span class="login-danger">*</span>', ['class' => 'control-label']) ?>
                        </div>
                        <div class="col-12 col-sm-6">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Enter Email'])->label('Email <span class="login-danger">*</span>', ['class' => 'control-label']) ?>
                        </div>
                        <div class="col-12 col-sm-6">
                            <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => 'Enter Phone'])->label('Phone <span class="login-danger">*</span>', ['class' => 'control-label']) ?>
                        </div>
                        <div class="col-12">
                            <?= $form->field($model, 'address')->textarea(['rows' => 6, 'placeholder' => 'Enter Address'])->label('Address <span class="login-danger">*</span>', ['class' => 'control-label']) ?>
                        </div>
                        <div class="col-12 col-sm-6">
                            <?= $form->field($model, 'position')->textInput(['maxlength' => true, 'placeholder' => 'Enter Position'])->label('Position <span class="login-danger">*</span>', ['class' => 'control-label']) ?>
                        </div>
                        <div class="col-12 col-sm-6">
                            <?= $form->field($model, 'status')->dropDownList([
                                10 => 'Active',
                                9 => 'Inactive',
                            ], ['prompt' => 'Select Status'])->label('Status <span class="login-danger">*</span>', ['class' => 'control-label']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>