<?php
require_once('PostController.php');
require_once('UserController.php');
require_once('TodoController.php');

$post_controller = new PostController();
$user_controller = new UserController();
$todo_controller = new TodoController();

try {
  $data = $post_controller->getPosts();
  echo $data;

  // $post_44 = $post_controller->getPostById(44);
  // echo $post_44;

  // $wrong_post_251 = $post_controller->getPostById(251);
  // echo $wrong_post_251;

  // $new_post = $post_controller->addPost(35, 'Hello', 'Test post');
  // echo $new_post;

  // $edited_post = $post_controller->editPost(35, 3, "Hello", "world");
  // echo $edited_post;

  // $deleted = $post_controller->deletePost(35);
  // echo $deleted;

  // $users = $user_controller->getUsers();
  // echo $users;

  // $user_8 = $user_controller->getUserById(8);
  // echo $user_8;

  // $todos = $todo_controller->getTodos();
  // echo $todos;

  // $todo_56 = $todo_controller->getTodoById(56);
  // echo $todo_56;

} catch (Error $ex) {
  echo "<p style='color: red'>" . $ex->getMessage() . "</p>";
}

?>
