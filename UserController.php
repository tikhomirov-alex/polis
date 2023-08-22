<?php

class UserController {

  private string $url = "https://jsonplaceholder.typicode.com/users";

  public function getStatus(string $url) {
    $headers = get_headers($url);
    $status = (int)substr($headers[0], 9, 3);
    return $status;
  }

  public function getUsers() {
    try {

      $status = $this->getStatus($this->url);
      if ($status < 200 || $status >= 300) {
        throw new Error('Bad url, response status ' . $status);
      }

      $users = file_get_contents($this->url);
      return $users;
    }
    catch (Error $ex) {
      throw new Error('Failed to get users: ' . $ex);
    }
  }

  public function getUserById(int $id) {
    try {
      $full_url = $this->url . '/' . $id;

      $status = $this->getStatus($full_url);
      if ($status < 200 || $status >= 300) {
        throw new Error('Bad url, response status ' . $status);
      }

      $user = file_get_contents($full_url);
      return $user;
    } catch (Error $ex) {
      throw new Error('Failed to get user id ' . $id . ':' . $ex);
    }
  }
}

?>
