<?php

namespace Framework;

use Framework\UserInterface;

class User extends AppComponent
{
    public function getAttribute(string $attr): bool
    {
        return isset($_SESSION[$attr]) ? $_SESSION[$attr] : null;
    }

    public function setAttribute(string $attr, $value)
    {
        $_SESSION[$attr] = $value;
    }

    public function isAuthenticated(): bool
    {
        return isset($_SESSION['auth']) && $_SESSION['auth'] === true;
    }

    public function setAuthenticated(bool $authenticated = true)
    {
        $_SESSION['auth'] = $authenticated;
    }

    public function setRole(string $role)
    {
        $_SESSION['role'] = $role;
    }

    public function getRole()
    {
        return isset($_SESSION['role']) ? $_SESSION['role'] : null;
    }

    public function setMember(UserInterface $member)
    {
        $_SESSION['user'] = $member;
    }

    public function getMember()
    {
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }

    public function disconnect()
    {
        session_destroy();
    }

    public function isGranted(string $myRole)
    {
        if (isset($_SESSION['role'])) {
            if ($myRole == $_SESSION['role']) {
                return true;
            } else {
                $listRole = $this->app->getConfig()->role_hierarchy->role;

                foreach ($listRole as $role) {
                    if ($role['name'] == $_SESSION['role']) {
                        $listRoleChild = $role->role_child;

                        foreach ($listRoleChild as $roleChild) {
                            if ($roleChild['name'] == $myRole) {
                                return true;
                            }
                        }
                    }
                }
            }
        }

        return false;
    }

    public function getFlash()
    {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);

        return $flash;
    }

    public function hasFlash(): bool
    {
        return isset($_SESSION['flash']);
    }

    public function hasFlashArray(string $key):bool
    {
        return isset($_SESSION['flash'][$key]);
    }

    public function setFlash($value)
    {
        $_SESSION['flash'] = $value;
    }

    public function getCrsfToken()
    {
        if (!isset($_SESSION['crsf_token'])) {
            $_SESSION['crsf_token'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        }

        return $_SESSION['crsf_token'];
    }

    public function connect(UserInterface $member)
    {
        $this->setRole($member->getRole());
        $this->setMember($member);
        $this->setAuthenticated(true);
    }
}
