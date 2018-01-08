<?php

namespace Framework;

interface UserInterface extends \Serializable
{
    public function getId(): int;
    public function setId(int $id);

    public function getLogin(): string;
    public function setLogin(string $login);

    public function getEmail(): string;
    public function setEmail(string $email);

    public function getPassword(): string;
    public function setPassword(string $password);

    public function getSalt(): string;
    public function setSalt(string $salt);

    public function getRole(): string;
    public function setRole(string $role);

    public function getValid(): bool;
    public function setValid(bool $valid);

    public function getConfirmationToken(): string;
    public function setConfirmationToken(string $confirmationToken);
}
