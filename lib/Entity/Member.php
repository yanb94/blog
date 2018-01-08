<?php

namespace Framework\Entity;

use Framework\Entity;
use Framework\UserInterface;

class Member extends Entity implements UserInterface
{
    protected $login;
    protected $firstname;
    protected $lastname;
    protected $civilite;
    protected $email;
    protected $password;
    protected $salt;
    protected $role;
    protected $valid = false;
    protected $confirmationToken;
    protected $birthDate;


    public function __construct(array $data = [])
    {
        parent::__construct($data);

        if (empty($this->id)) {
            $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
            $this->confirmationToken = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        }
    }

    public function serialize()
    {
        return serialize([
            "id"=>$this->id,
            "login"=>$this->login,
            "email"=>$this->email,
            "firstname"=>$this->firstname,
            "lastname"=>$this->lastname,
            "civilite"=>$this->civilite,
            "birthDate"=>$this->birthDate,
            "role"=> $this->role
        ]);
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->hydrate($data);
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login)
    {
        $this->login = $login;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public function setSalt(string $salt)
    {
        if ($salt != null and is_string($salt)) {
            $this->salt = $salt;
        }
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role)
    {
        $this->role = $role;
    }

    public function getValid(): bool
    {
        return $this->valid;
    }

    public function setValid(bool $valid)
    {
        $this->valid = $valid;
    }

    public function getConfirmationToken(): string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken(string $confirmationToken)
    {
        if ($confirmationToken != null and is_string($confirmationToken)) {
            $this->confirmationToken = $confirmationToken;
        }
    }

    public function getBirthDate()
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTime $date)
    {
        $this->birthDate = $date;
    }

    public function getCivilite(): string
    {
        return $this->civilite;
    }

    public function setCivilite(string $civilite)
    {
        $this->civilite = $civilite;
    }
}
