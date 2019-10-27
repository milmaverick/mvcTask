<?php

require_once 'App/models/IndexModel.php';

class IndexController extends Controller {

	private $pageTpl = 'App/views/main.tpl.php';

	public function __construct() {
		$this->model = new IndexModel();
		$this->view = new View();
	}

	public function index() {
		$comments= $this->model->getTask();
		$this->pageData= $comments;
		$this->view->render('App/views/index.php', 	$this->pageTpl , $this->pageData);
	}

	public function pagination()
	{
		// code...
		$pages= $this->model->pagination();
		$this->pageData= $pages;
		$this->view->renderPartial('App/views/pagination.php', $this->pageData);
	}

	public function showTask()
	{
		$comments= $this->model->getTask($_POST['params']);
		$this->pageData= $comments;
		$this->view->renderPartial('App/views/index.php', $this->pageData);
	}

	public function upload()
	{
		// code...
		$errors=array();
		if(trim($_POST['name'])==''){
			{
				$errors[]='Введите имя';
			}
		}
		if(trim($_POST['email'])==''){
			{
				$errors[]='Введите email';
			}
		}
		if($_POST['text']==''){
			{
				$errors[]='Введите текст';
			}
		}
		if(!preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}
		[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', trim($_POST['email'])))
		{
			$errors[]='Некорректный email';
		}
		if(empty($errors))
		{

			$params=[
				'name'=>$_POST['name'],
				'email'=>$_POST['email'],
				'text'=>$_POST['text'],
			];

			echo $this->model->save($params);

		}
		else{
			echo array_shift($errors);
		}
	}

	public function getPage()
	{
		// code...
		echo $this->model->getPage();
	}

}
?>
