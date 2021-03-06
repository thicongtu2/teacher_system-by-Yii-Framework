<?php

class KindController extends Controller
{
/**
* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
* using two-column layout. See 'protected/views/layouts/column2.php'.
*/

/**
* @return array action filters
*/
public function filters()
{
	return array(
'accessControl', // perform access control for CRUD operations
);
}

/**
* Specifies the access control rules.
* This method is used by the 'accessControl' filter.
* @return array access control rules
*/
public function accessRules()
{
	return array(

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','view','succcess'),
				'roles'=>array('member'),
				),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','index','create','succcess','view'),
				'roles' => array('admin'),
				),
			array('deny',  // deny all users
				'users'=>array('*'),
				),
			);
}

/**
* Displays a particular model.
* @param integer $id the ID of the model to be displayed
*/
public function actionView($id)
{
	$this->render('view',array(
		'model'=>$this->loadModel($id),
		));
}
/**
* Creates a new model.
* If creation is successful, the browser will be redirected to the 'view' page.
*/
public function actionCreate()
{
	$model=new Kind;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

	if(isset($_POST['Kind']))
	{
		$model->attributes=$_POST['Kind'];
		$img = CUploadedFile::getInstance($model, 'img_src');
 			if (!empty($img)) { //Kiểm tra xem người nhập có upload ảnh hay không, nếu có thực hiện các bước bên dưới, không thì $model->image = null
 				$fileSource = Yii::getPathOfAlias('webroot') . '/img/';
			 $rnd = rand(0, 9999);//tạo ngẫu nhiên 1 số để tránh trường hợp 2 ảnh khác nhau nhưng cùng tên
			 $nameImg = "{$rnd}-" . $img->name;
			 $model->img_src = "img/" . $nameImg;
			 $img->saveAs($fileSource . $nameImg);}
			 if($model->save())
			 	$this->redirect(Yii::app()->homeUrl);
			}

			$this->render('create',array(
				'model'=>$model,
				));
		}

/**
* Updates a particular model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $id the ID of the model to be updated
*/
/*
public function actionUpdate($id)
{
$model=$this->loadModel($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

if(isset($_POST['Kind']))
{
$model->attributes=$_POST['Kind'];
if($model->save())
$this->redirect(array('view','id'=>$model->id_kind));
}

$this->render('update',array(
'model'=>$model,
));
}

/**
* Deletes a particular model.
* If deletion is successful, the browser will be redirected to the 'admin' page.
* @param integer $id the ID of the model to be deleted
*/
/*
public function actionDelete($id)
{
if(Yii::app()->request->isPostRequest)
{
// we only allow deletion via POST request
$this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
if(!isset($_GET['ajax']))
$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
}
else
throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
}

/**
* Lists all models.
*/
public function actionIndex()
{
	$dataProvider=new CActiveDataProvider('Kind');
	$this->render('index',array(
		'dataProvider'=>$dataProvider,
		));
}

public function getimgfromid($id){
	$img = Kind::model()->findByAttributes(array('id_kind'=>$id))->img_src;
	return $img;
}

/**
* Manages all models.
*/

public function actionAdmin()
{
	$model=new Kind('search');
$model->unsetAttributes();  // clear any default values
if(isset($_GET['Kind']))
	$model->attributes=$_GET['Kind'];

$this->render('admin',array(
	'model'=>$model,
	));
}

/**
* Returns the data model based on the primary key given in the GET variable.
* If the data model is not found, an HTTP exception will be raised.
* @param integer the ID of the model to be loaded
*/
public function loadModel($id)
{
	$model=Kind::model()->findByPk($id);
	if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
	return $model;
}

/**
* Performs the AJAX validation.
* @param CModel the model to be validated
*/
protected function performAjaxValidation($model)
{
	if(isset($_POST['ajax']) && $_POST['ajax']==='kind-form')
	{
		echo CActiveForm::validate($model);
		Yii::app()->end();
	}
}
}
