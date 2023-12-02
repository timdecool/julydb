<?php
namespace App\Models;
use App\Models\AbstractTable;
use DateTime;

class Word extends AbstractTable {
    // Properties
    private ?string $role = null;
    private ?string $firstName = null;
    private ?string $lastName = null;
    private ?string $mail = null;
    private ?\DateTime $dateCreated = null;
    private ?\DateTime $dateUpdated = null;
    private ?\DateTime $lastVisit = null;
    private ?string $password = null;
    private ?int $idImage = null;

    // Role
    /**
     * @return string|null
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * @param string|null
     */
    public function setRole(?string $role) {
        $this->role = $role;
    }

    // First name
    /**
     * @return string|null
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * @param string|null
     */
    public function setFirstName(?string $firstName) {
        $this->firstName = $firstName;
    }

    // Last name
    /**
     * @return string|null
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * @param string|null
     */
    public function setLastName(?string $lastName) {
        $this->lastName = $lastName;
    }

    // Mail
    /**
     * @return string|null
     */
    public function getMail() {
        return $this->mail;
    }

    /**
     * @param string|null
     */
    public function setMail(?string $mail) {
        $this->mail = $mail;
    }

    // Date Created
    /**
     * @return DateTime|null
     */
    public function getDateCreated() {
        return $this->dateCreated;
    }

    /**
     * @param DateTime|null
     */
    public function setDateCreated(?DateTime $dateCreated) {
        $this->dateCreated = $dateCreated;
    }

    // Date Updated
    /**
     * @return DateTime|null
     */
    public function getDateUpdated() {
        return $this->dateUpdated;
    }

    /**
     * @param DateTime|null
     */
    public function setDateUpdated(?DateTime $dateUpdated) {
        $this->dateUpdated = $dateUpdated;
    }

    // Last Visit
    /**
     * @return DateTime|null
     */
    public function getLastVisit() {
        return $this->lastVisit;
    }

    /**
     * @param DateTime|null
     */
    public function setLastVisit(?DateTime $lastVisit) {
        $this->lastVisit = $lastVisit;
    }

    // Password
    /**
     * @return string|null
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param string|null
     */
    public function setPassword(?string $password) {
        $this->password = $password;
    }

    // ID Image
    /**
     * @return int|null
     */
    public function getIdImage() {
        return $this->idImage;
    }

    /**
     * @param int|null
     */
    public function setIdImage(?int $idImage) {
        $this->idImage = $idImage;
    }

    public function toArray() {
        return [
            $this->firstName, 
            $this->lastName, 
            $this->mail, 
            password_hash($this->password,PASSWORD_DEFAULT)
        ];
    }

    public function validate() :array {
        $errors = [];

        if(empty($this->firstName)) {
            $errors[] = "Veuillez renseigner votre prénom.";
        }

        if(empty($this->lastName)) {
            $errors[] = "Veuillez renseigner votre nom.";
        }

        if(!filter_var($this->mail, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Veuillez renseigner un email valide.";
        }

        $manager = new UserManager();
        $users = $manager->getAll("mail");
        foreach($users as $u) {
            if($u['mail'] == $this->mail) {
                $errors[] = "Il existe déjà un compte associé à cet e-mail.";
            }
        }


        if(strlen($this->password) < 6) {
            $errors[] = "Veuillez choisir un mot de passe d'au moins 6 caractères.";
        }

        return $errors;
    }
}