<?php

class PostController extends Zend_Controller_Action
{
	private $post_data;

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
    public function addAction()
    {
	$this->view->post_data=$this->_request->getParams();
		if($this->_request->isPost())
		{
		    $post_data=$this->_request->getParams();
			var_dump($post_data);
			echo $post_data['commentbody'];
			if(!empty($post_data['commentbody']))
			{
				var_dump($post_data);
				$comment=new Application_Model_Comment();
				$comment->addComment($post_data);
			}
			else
			{
			$post=new Application_Model_Post();		
			$this->view->post_id=$post->addPost($post_data);
			$this->view->post_data=$this->_request->getParams();
			}
 			
		}
	
    }

    public function listAction()
    {
     	$post=new Application_Model_Post();
		$posts=$post->listPosts();
			
		for($i=0;$i<count($posts);$i++)
		{
			echo "Title:".$posts[$i]['title']."<br/>";
			echo "body:".$posts[$i]['body']."<br/>";
			echo "<a href='http://localhost/mysite/public/post/edit/id/".$posts[$i]['id']."'>Edit</a>";
			echo "<a href='http://localhost/mysite/public/post/delete/id/".$posts[$i]['id']."'>Delete</a>";
			
		} 
	}

    public function deleteAction()
    {
		$post=new Application_Model_Post();
		$post->deletePost($this->_request->getParam('id'));
		$this->redirect('/post/list/');
        
    }

    public function editAction()
    {
		$id=$this->_request->getParam('id');
		$this->view->action = 'edit';
		if(!empty($id))
		{
		$this->view->post_data=$this->_request->getParams();
		$post_model = new Application_Model_Post();
		$posts = $post_model->getPostById($id);
		$this->view->post = $posts[0];
		}
		if($this->_request->isPost())
		{
        $post_data = $this->_request->getParams();
		//var_dump($post_data);
		$post_model = new Application_Model_Post();
   		$post_model->editPost($id,Array("title"=>$post_data['title'],"body"=>$post_data['postbody']));
		$posts = $post_model->getPostById($id);
		$this->view->post = $posts[0];
		}
		$this->render('add');
	
		//$post=new Application_Model_Post()
       // $post->editPost($this->$id,);
    }




}









