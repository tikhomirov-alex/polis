<?php

class Post {

  public function __construct($user_id, $title, $body) {
    $this->userId = $user_id;
    $this->title = $title;
    $this->body = $body;
  }

  public int $userId;
  public int $id;
  public string $title;
  public string $body;   
}

?>
