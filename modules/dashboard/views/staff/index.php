<?php

use app\modules\dashboard\models\Staff;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var app\modules\dashboard\models\StaffSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Staff';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-index">

    <div class="staff-group-form">
        <div class="row">
            <form method="get" action="<?= Url::to(['/dashboard/staff/index']) ?>">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" name="StaffSearch[staff_no]" class="form-control" placeholder="Search by Staff No ..." value="<?= Html::encode($searchModel->staff_no) ?>">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" name="StaffSearch[first_name]" class="form-control" placeholder="Search by First Name ..." value="<?= Html::encode($searchModel->first_name) ?>">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <input type="text" name="StaffSearch[phone]" class="form-control" placeholder="Search by Phone ..." value="<?= Html::encode($searchModel->phone) ?>">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="search-staff-btn">
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
                                <h3 class="page-title">Staff Members</h3>
                            </div>
                            <div class="col-auto text-end float-end ms-auto download-grp">
                                <a href="<?= Url::to('/dashboard/staff/create') ?>" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="staff-thread">
                                <tr>
                                    <th>#</th>
                                    <th>Staff Number</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Position</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($dataProvider->getCount() > 0): ?>
                                    <?php foreach ($dataProvider->getModels() as $index => $staff): ?>
                                        <tr>
                                            <td><?= $dataProvider->pagination->page * $dataProvider->pagination->pageSize + $index + 1 ?></td>
                                            <td><?= Html::encode($staff->staff_no) ?></td>
                                            <td><?= Html::encode($staff->first_name) ?></td>
                                            <td><?= Html::encode($staff->last_name) ?></td>
                                            <td><?= Html::encode($staff->email) ?></td>
                                            <td><?= Html::encode($staff->phone) ?></td>
                                            <td><?= Html::encode($staff->position) ?></td>
                                            <td class="text-end">
                                                <div class="actions ">
                                                    <a href="<?= Url::to(['/dashboard/staff/view', 'id' => $staff->id]) ?>" class="btn btn-sm bg-success-light me-2 ">
                                                        <i class="feather-eye"></i>
                                                    </a>
                                                    <a href="<?= Url::to(['/dashboard/staff/update', 'id' => $staff->id]) ?>" class="btn btn-sm bg-danger-light">
                                                        <i class="feather-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm bg-danger-light delete-btn" data-url="<?= Url::to(['/dashboard/staff/delete', 'id' => $staff->id]) ?>">
                                                        <i class="feather-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">No data found</td>
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
                            ]); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>