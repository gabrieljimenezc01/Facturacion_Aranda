<?php
require_once __DIR__ . '/../config/db.php';

class Validator {
  private $errors = [];

  public function validateUsername($username) {
    if (empty($username)) {
      $this->errors['user'] = "El nombre de usuario es obligatorio.";
    }
    return $this;
  }

  public function validateDuplicateUsername($username) {
    global $conn;
    if (!empty($username)) {
      $sql = "SELECT COUNT(*) FROM login WHERE usuario = :user";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':user', $username, PDO::PARAM_STR);
      $stmt->execute();
      $count = $stmt->fetchColumn();
      if ($count > 0) {
        $this->errors['duplicate'] = "El nombre de usuario ya esta en uso.";
      }
    }
    return $this;
  }

  public function validatePassword($password) {
    if (empty($password)) {
      $this->errors['password'] = "La contraseña es obligatoria.";
    } elseif (strlen($password) < 3) {
      $this->errors['password'] = "La contraseña debe tener al menos 3 caracteres.";
    }
    return $this;
  }

  public function validateSpecialPassword($specialPassword) {
    if ($specialPassword !== '12345') {
      $this->errors['special'] = "La contraseña especial es incorrecta.";
    }
    return $this;
  }

  public function validateName($name) {
    if (empty($name)) {
      $this->errors['nombre'] = "El nombre es obligatorio.";
    }
    return $this;
  }

  public function validateSurname($surname) {
    if (empty($surname)) {
      $this->errors['apellido'] = "El apellido es obligatorio.";
    }
    return $this;
  }

  public function getErrors() {
    return $this->errors;
  }

  public function hasErrors() {
    return !empty($this->errors);
  }
}
?>
