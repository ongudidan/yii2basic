<?php

namespace app\modules\dashboard\controllers;

use app\components\IdGenerator;
use app\components\UserIdGenerator;
use app\models\User;
use app\modules\dashboard\models\Student;
use app\modules\dashboard\models\StudentSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends Controller
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
     * Lists all Student models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Student model.
     * @param int $id ID
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
     * Creates a new Student model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Student();
        $user = new User();

        if ($this->request->isPost) {
            // Load the data into the Students model
            if ($model->load($this->request->post())) {

                // Generate and set the admission number
                $model->admission_no = Student::generateAdmissionNo();
                $model->id = IdGenerator::generateUniqueId();

                // Set User attributes
                $user->id = IdGenerator::generateUniqueId();
                $user->username = $model->admission_no;  // Set username to admission_no
                $user->password_hash = Yii::$app->security->generatePasswordHash($user->username);  // Set password to hashed admission_no
                $user->auth_key = Yii::$app->security->generateRandomString();
                $user->status = 10; // Default status

                // Use a transaction to ensure both models are saved successfully
                $transaction = Yii::$app->db->beginTransaction();

                try {
                    // Save the User model first
                    if ($user->save()) {
                        // Set the user_id for the Student model
                        $model->user_id = $user->id; // Assuming user_id is the primary key of the Users model

                        // Save the Students model
                        if ($model->save()) {
                            $transaction->commit();
                            Yii::$app->session->setFlash('success', 'Student and user created successfully.');
                            return $this->redirect(['view', 'id' => $model->id]);
                        } else {
                            // Rollback the transaction and set flash with error details
                            $transaction->rollBack();
                            $studentErrors = implode('<br>', $model->getFirstErrors());
                            Yii::$app->session->setFlash('error', 'Failed to save student: ' . $studentErrors);
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
     * Updates an existing Student model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
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
     * Deletes an existing Student model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
