<?php

namespace Framework\Manager;

use Framework\Manager;
use Framework\Entity\Member;

class MemberManager extends Manager
{
    public function add(Member $member)
    {
        $password = $this->cryptPassword($member);

        $req = $this->dao->prepare('
            INSERT INTO
                member 
            SET 
                login = :login,
                firstname = :firstname,
                lastname = :lastname,
                civilite = :civilite,
                email = :email,
                password = :password,
                salt = :salt,
                role = :role,
                valid = :valid,
                confirmationToken = :confirmationToken,
                birthDate = :birthDate
            ');

        $req->bindValue(':login', $member->getLogin());
        $req->bindValue(':firstname', $member->getFirstname());
        $req->bindValue(':lastname', $member->getLastname());
        $req->bindValue(':civilite', $member->getCivilite());
        $req->bindValue(':email', $member->getEmail());
        $req->bindValue(':password', $password);
        $req->bindValue(':salt', $member->getSalt());
        $req->bindValue(':role', $member->getRole());
        $req->bindValue(':valid', $member->getValid());
        $req->bindValue(':confirmationToken', $member->getConfirmationToken());
        $req->bindValue(':birthDate', $member->getBirthDateString());

        $req->execute();

        $member->setId($this->dao->lastInsertId());
    }

    public function delete(int $id)
    {
        $req = $this->dao->prepare("
            DELETE FROM
                member
            WHERE 
                id = :id
            ");

        $req->bindValue(':id', $id, \PDO::PARAM_INT);

        $req->execute();
    }

    public function edit(Member $member)
    {
        $req = $this->dao->prepare('
            UPDATE 
                member 
            SET 
                login = :login,
                firstname = :firstname,
                lastname = :lastname,
                civilite = :civilite,
                email = :email,
                role = :role,
                valid = :valid,
                birthDate = :birthDate
            WHERE 
                id = :id
            ');

        $req->bindValue(':id', $member->getId(), \PDO::PARAM_INT);
        $req->bindValue(':login', $member->getLogin());
        $req->bindValue(':firstname', $member->getFirstname());
        $req->bindValue(':lastname', $member->getLastname());
        $req->bindValue(':civilite', $member->getCivilite());
        $req->bindValue(':email', $member->getEmail());
        $req->bindValue(':role', $member->getRole());
        $req->bindValue(':valid', $member->getValid());
        $req->bindValue(':birthDate', $member->getBirthDateString());

        $req->execute();
    }

    public function editPassword(Member $member)
    {
        $password = $this->cryptPassword($member);

        $req = $this->dao->prepare('
            UPDATE 
                member 
            SET 
                password = :password
            WHERE 
                id = :id
            ');

        $req->bindValue(':password', $password);
        $req->bindValue(':id', $member->getId());

        $req->execute();
    }

    public function get(int $id): Member
    {
        $req = $this->dao->prepare($this->genericSelect()." WHERE id = :id");

        $req->bindValue(':id', $id, \PDO::PARAM_INT);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Member::class);

        return $req->fetch();
    }

    public function getByRole(string $role)
    {
        $req = $this->dao->prepare($this->genericSelect()." WHERE role = :role");

        $req->bindValue(':role', $role);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Member::class);

        return $req->fetchAll();
    }

    public function getByValidate(string $valid)
    {
        $req = $this->dao->prepare($this->genericSelect()." WHERE valid = :valid");

        $req->bindValue(':role', $valid);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Member::class);

        return $req->fetchAll();
    }

    public function getByLogin(string $login)
    {
        $req = $this->dao->prepare($this->genericSelect()." WHERE login = :login");

        $req->bindValue(':login', $login, \PDO::PARAM_INT);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Member::class);

        return $req->fetch();
    }

    public function getByConfirmToken(string $confirmToken, bool $valid)
    {
        $req = $this->dao->prepare($this->genericSelect()." WHERE confirmationToken = :confirmationToken
         AND valid = :valid");

        $req->bindValue(':confirmationToken', $confirmToken);
        $req->bindValue(':valid', $valid, \PDO::PARAM_BOOL);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Member::class);

        return $req->fetch();
    }

    protected function genericSelect()
    {
        return "
            SELECT
                id,
                login,
                firstname,
                lastname,
                civilite,
                email,
                password,
                salt,
                role,
                valid,
                confirmationToken,
                birthDate 
            FROM
                member
        ";
    }

    protected function cryptPassword(Member $member)
    {
        return crypt($member->getPassword(), $member->getSalt());
    }
}
