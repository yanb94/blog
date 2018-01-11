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

    protected $plainPassword;
    protected $plainBirthDate;


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

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin(string $login)
    {
        $this->login = $login;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getPassword()
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

    public function getCivilite()
    {
        return $this->civilite;
    }

    public function setCivilite(string $civilite)
    {
        $this->civilite = $civilite;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(array $plainPassword)
    {
        $this->plainPassword = $plainPassword;

        if ($this->plainPassword['first'] == $this->plainPassword['second']) {
            $this->setPassword($this->plainPassword['second']);
        }
    }

    public function getPlainBirthDate()
    {
        return $this->plainBirthDate;
    }

    public function setPlainBirthDate(array $plainBirthDate)
    {
        $this->plainBirthDate = $plainBirthDate;

        if (isset($plainBirthDate['month']) and isset($plainBirthDate['day']) and isset($plainBirthDate['year'])) {
            $date = new \DateTime($plainBirthDate['month'].'/'.$plainBirthDate['day'].'/'.$plainBirthDate['year']);
            $this->setBirthDate($date);
        }
    }
}
