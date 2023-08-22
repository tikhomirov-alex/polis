<?php

class TodoController {

  private string $url = "https://jsonplaceholder.typicode.com/todos";

  public function getStatus(string $url) {
    $headers = get_headers($url);
    $status = (int)substr($headers[0], 9, 3);
    return $status;
  }

  public function getTodos() {
    try {

      $status = $this->getStatus($this->url);
      if ($status < 200 || $status >= 300) {
        throw new Error('Bad url, response status ' . $status);
      }

      $todos = file_get_contents($this->url);
      return $todos;
    }
    catch (Error $ex) {
      throw new Error('Failed to get todos: ' . $ex);
    }
  }

  public function getTodoById(int $id) {
    try {
      $full_url = $this->url . '/' . $id;

      $status = $this->getStatus($full_url);
      if ($status < 200 || $status >= 300) {
        throw new Error('Bad url, response status ' . $status);
      }

      $todo = file_get_contents($full_url);
      return $todo;
    } catch (Error $ex) {
      throw new Error('Failed to get todo id ' . $id . ':' . $ex);
    }
  }
}

?>
