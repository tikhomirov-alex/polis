<?php
require_once('models/Post.php');


class PostController {

  private string $url = "https://jsonplaceholder.typicode.com/posts";

  public function getStatus(string $url) {
    $headers = get_headers($url);
    $status = (int)substr($headers[0], 9, 3);
    return $status;
  }

  public function getPosts() {
    try {
      $status = $this->getStatus($this->url);
      if ($status < 200 || $status >= 300) {
        throw new Error('Bad url, response status ' . $status);
      }
      $posts = file_get_contents($this->url);
      echo $posts;
      return $posts;
    }
    catch (Error $ex) {
      throw new Error('Failed to get posts: ' . $ex);
    }
  }

  public function getPostById(int $id) {
    try {
      $full_url = $this->url . '/' . $id;

      $status = $this->getStatus($full_url);
      if ($status < 200 || $status >= 300) {
        throw new Error('Bad url, response status ' . $status);
      }

      $post = file_get_contents($full_url);
      echo $post;
      return $post;
    } catch (Error $ex) {
      throw new Error('Failed to get post id ' . $id . ':' . $ex);
    }
  }

  public function addPost(int $user_id, string $title, string $body) {
    try {

      if (!$title) {
        throw new Error('Post title is empty');
      }
      if (!$body) {
        throw new Error('Post body is empty');
      }

      $status = $this->getStatus($this->url);
      if ($status < 200 || $status >= 300) {
        throw new Error('Bad url, response status ' . $status);
      }

      $post = new Post($user_id, $title, $body);
      $content = json_encode($post);

      $ctx = stream_context_create(
        array(
          'http'=>array(
            'header'=>"Content-type: application/json; charset=UTF-8",
            'method'=>'POST',
            'content'=>$content
          )
        )
      );

      $new_post = file_get_contents($this->url, false, $ctx);
      return $new_post;

    } catch (Error $ex) {
      throw new Error('Failed to create post: ' . $ex);
    }
  }
  
  public function editPost(int $post_id, int $user_id, string $new_title, string $new_body) {
    try {
      if (!$new_title) {
        throw new Error('Post title is empty');
      }
      if (!$new_body) {
        throw new Error('Post body is empty');
      }

      $post = new Post($user_id, $new_title, $new_body);
      $post->id = $post_id;
      $content = json_encode($post);

      $ctx = stream_context_create(
        array(
          'http'=>array(
            'header'=>"Content-type: application/json; charset=UTF-8",
            'method'=>'PUT',
            'content'=>$content
          )
        )
      );
      $full_url = $this->url . '/' . $post_id;
      $status = $this->getStatus($full_url);
      if ($status < 200 || $status >= 300) {
        throw new Error('Bad url, response status ' . $status);
      }

      $response = file_get_contents($full_url, false, $ctx);
      return $response;

    } catch (Error $ex) {
      throw new Error('Failed to edit post: ' . $ex);
    }
  }

  public function deletePost(int $post_id) {
    try {
      
      $ctx = stream_context_create(
        array(
          'http'=>array(
            'method'=>'DELETE'
          )
        )
      );
      $full_url = $this->url . '/' . $post_id;
      $status = $this->getStatus($full_url);
      if ($status < 200 || $status >= 300) {
        throw new Error('Bad url, response status ' . $status);
      }
      
      $response = file_get_contents($full_url, false, $ctx);
      return $response;

    } catch (Error $ex) {
      throw new Error('Failed to delete post id ' . $post_id . ': ' . $ex);
    }
  }
}

?>
