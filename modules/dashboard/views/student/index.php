<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\StudentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Students';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-index">

    <div class="student-group-form">
        <div class="row">
            <form method="get" action="<?= Url::to(['/dashboard/student/index']) ?>">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" name="StudentSearch[admission_no]" class="form-control" placeholder="Search by Admission No ..." value="<?= Html::encode($searchModel->admission_no) ?>">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" name="StudentSearch[first_name]" class="form-control" placeholder="Search by Name ..." value="<?= Html::encode($searchModel->first_name) ?>">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <input type="text" name="StudentSearch[phone]" class="form-control" placeholder="Search by Phone ..." value="<?= Html::encode($searchModel->phone) ?>">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="search-student-btn">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table comman-shadow">
                <div class="card-body">

                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title">Students</h3>
                            </div>
                            <div class="col-auto text-end float-end ms-auto download-grp">
                                <a href="<?= Url::to('/dashboard/student/create') ?>" class="btn btn-primary"><i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="student-thread">
                                <tr>
                                    <th>#</th>
                                    <th>Admission Number</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>DOB</th>
                                    <th>Email</th>
                                    <th>Mobile Number</th>
                                    <th>Admission Date</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($dataProvider->getCount() > 0): // Check if there are any models 
                                ?>
                                    <?php foreach ($dataProvider->getModels() as $index => $student): ?>
                                        <tr>
                                            <td><?= $dataProvider->pagination->page * $dataProvider->pagination->pageSize + $index + 1 ?></td>
                                            <td><?= $student->admission_no ?></td>
                                            <td><?= $student->first_name ?></td>
                                            <td><?= $student->last_name ?></td>
                                            <td><?= $student->date_of_birth ?></td>
                                            <td><?= $student->email ?></td>
                                            <td><?= $student->phone ?></td>
                                            <td><?= Yii::$app->formatter->asDatetime($student->created_at) ?></td>
                                            <td class="text-end">
                                                <div class="actions ">
                                                    <a href="<?= Url::to(['/dashboard/student/view', 'id' => $student->id]) ?>" class="btn btn-sm bg-success-light me-2 ">
                                                        <i class="feather-eye"></i>
                                                    </a>
                                                    <a href="<?= Url::to(['/dashboard/student/update', 'id' => $student->id]) ?>" class="btn btn-sm bg-danger-light">
                                                        <i class="feather-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm bg-danger-light delete-btn" data-url="<?= Url::to(['/dashboard/student/delete', 'id' => $student->id]) ?>">
                                                        <i class="feather-trash"></i>
                                                    </a>


                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: // If no models found 
                                ?>
                                    <tr>
                                        <td colspan="9" class="text-center">No data found</td> <!-- Adjust colspan based on your table -->
                                    </tr>
                                <?php endif; ?>
                            </tbody>

                        </table>
                    </div>

                    <!-- pagination -->
                    <div>
                        <ul class="pagination mb-4">
                            <?= LinkPager::widget([
                                'pagination' => $dataProvider->pagination,
                                'options' => ['class' => 'pagination mb-4'],
                                'linkOptions' => ['class' => 'page-link'],
                                'activePageCssClass' => 'active',
                                'disabledPageCssClass' => 'disabled',
                                'prevPageLabel' => '<span aria-hidden="true">«</span><span class="sr-only">Previous</span>',
                                'nextPageLabel' => '<span aria-hidden="true">»</span><span class="sr-only">Next</span>',
                                // 'firstPageLabel' => '1', // You can customize this if needed
                                // 'lastPageLabel' => 'Last', // You can customize this if needed
                            ]); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>