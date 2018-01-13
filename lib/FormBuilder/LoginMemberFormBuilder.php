<?php

namespace Framework\FormBuilder;

use Framework\FormBuilder;
use Framework\Field\StringField;
use Framework\Field\PasswordField;
use Framework\Validator\NotNullValidator;

class LoginMemberFormBuilder extends FormBuilder
{
    const NAME_FORM = 'form_login';

    public function build()
    {
        parent::build();

        $this->form->add(new StringField([
                "name"=> "login",
                "label"=> "Pseudo",
                "classCss" => "form-control",
                "validators" => [
                    new NotNullValidator("Vous devez indiquer un pseudo")
                ]
            ]))
            ->add(new PasswordField([
                "name" => "password",
                "label" => "Mot de passe",
                "classCss" => "form-control",
                "validators" => [
                    new NotNullValidator("Vous devez indiquer un mot de passe")
                ]
            ]));
    }
}
