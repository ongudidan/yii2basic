<?php

namespace app\modules\dashboard\controllers;

use app\components\IdGenerator;
use app\models\User;
use app\modules\dashboard\models\Staff;
use app\modules\dashboard\models\StaffSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StaffController implements the CRUD actions for Staff model.
 */
class StaffController extends Controller
{
    public $layout = 'DashboardLayout';

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Staff models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new StaffSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Staff model.
     * @param string $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Staff model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Staff();
        $user = new User();

        if ($this->request->isPost) {
            // Load the data into the Staff model
            if ($model->load($this->request->post())) {

                // Generate and set the admission number
                $model->staff_no = Staff::generateStaffNo();
                $model->id = IdGenerator::generateUniqueId();
                // $model->date_of_birth = strtotime($model->date_of_birth);

                // Set User attributes
                $user->id = IdGenerator::generateUniqueId();
                $user->username = $model->staff_no;  // Set username to staff_no
                $user->password_hash = Yii::$app->security->generatePasswordHash($user->username);  // Set password to hashed staff_no
                $user->auth_key = Yii::$app->security->generateRandomString();
                $user->status = 10; // Default status

                // Use a transaction to ensure both models are saved successfully
                $transaction = Yii::$app->db->beginTransaction();

                try {
                    // Save the User model first
                    if ($user->save()) {
                        // Set the user_id for the staff model
                        $model->user_id = $user->id; // Assuming user_id is the primary key of the Users model

                        // Save the Staff model
                        if ($model->save()) {
                            $transaction->commit();
                            Yii::$app->session->setFlash('success', 'staff and user created successfully.');
                            return $this->redirect(['view', 'id' => $model->id]);
                        } else {
                            // Rollback the transaction and set flash with error details
                            $transaction->rollBack();
                            $staffErrors = implode('<br>', $model->getFirstErrors());
                            Yii::$app->session->setFlash('error', 'Failed to save staff: ' . $staffErrors);
                        }
                    } else {
                        // Rollback the transaction and set flash with error details
                        $transaction->rollBack();
                        $userErrors = implode('<br>', $user->getFirstErrors());
                        Yii::$app->session->setFlash('error', 'Failed to save user: ' . $userErrors);
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'An error occurred: ' . $e->getMessage());
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Staff model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Staff model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $staff = $this->findModel($id);
        $userId = $staff->user_id; // Assuming there's a user_id field

        $staff->delete(); // Delete the staff
        if ($userId) User::findOne($userId)?->delete(); // Delete the user if exists

        return $this->redirect(['index']);
    }

    /**
     * Finds the Staff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return Staff the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Staff::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
