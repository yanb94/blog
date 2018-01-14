<?php

namespace Framework;

use Framework\AppComponent;
use Framework\App;
use Framework\PDOFactory;
use Framework\Managers;
use Framework\Response\HTMLResponse;
use Framework\Response\RedirectResponse;

abstract class Controller extends AppComponent
{
    protected $managers;
    protected $twig;

    public function __construct(App $app)
    {
        parent::__construct($app);

        $database = $this->app->getConfig()->database;

        $dao = PDOFactory::getMysqlConnexion(
            $database['host'],
            $database['db'],
            $database['user'],
            $database['password']
        );

        $this->managers = new Managers($dao);
        $this->twig = new TwigWrapper($this->getApp()->getConfig()->twig->paths->path);
        $this->twigExtension();
    }

    protected function twigExtension()
    {
        $this->twig
            ->addGlobal('url', $this->app->getRouter())
            ->addGlobal('user', $this->app->getUser())
            ->addFilter('sexe', function ($sexe) {
                if ($sexe == 'h') {
                    return 'Monsieur';
                } elseif ($sexe == 'f') {
                    return 'Madame';
                }
            })
            ->addFilter('frenchMonth', function ($month) {
                $month = array(
                     1 => 'Janvier',
                     2 => 'Février',
                     3 => 'Mars',
                     4 => 'Avril',
                     5 => 'Mai',
                     6 => 'Juin',
                     7 => 'Juillet',
                     8 => 'Août',
                     9=> 'Septembre',
                    10=> 'Octobre',
                    11 => 'Novembre',
                    12 => 'Décembre'
                );

                return $month[(int)$month];
            })
            ->addFilter('age', function ($date) {
                $age = date('Y') - date('Y', strtotime($date));
                if (date('md') < date('md', strtotime($date))) {
                    return $age - 1;
                }
                return $age;
            })
            ->addFilter('role', function ($role) {
                $listRole = [
                    "ROLE_USER" => "Membre",
                    "ROLE_ADMIN"=> "Administrateur"];

                if (isset($listRole[$role])) {
                    return $listRole[$role];
                } else {
                    return false;
                }
            })
            ;
    }

    public function render(string $template, array $params = [])
    {
        $html = $this->twig->getTwig()->render($template, $params);
        return new HTMLResponse($html);
    }

    public function redirect(string $url)
    {
        return new RedirectResponse($url);
    }
}
