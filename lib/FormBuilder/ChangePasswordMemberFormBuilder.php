<?php

namespace Framework\FormBuilder;

use Framework\FormBuilder;

use Framework\Field\PasswordField;
use Framework\Field\RepetableField;

use Framework\Validator\NotNullValidator;
use Framework\Validator\MaxLengthValidator;
use Framework\Validator\MinLengthValidator;
use Framework\Validator\EmailValidator;
use Framework\Validator\SameValueValidator;
use Framework\Validator\DateValidator;
use Framework\Validator\BirthDateValidator;

class ChangePasswordMemberFormBuilder extends FormBuilder
{
    const NAME_FORM = "form_change_password_member";

    public function build()
    {
        parent::build();

        $this->form
            ->add(new PasswordField([
                "name" => "oldPassword",
                "label" => "Ancien mot de passe",
                "classCss" => "form-control",
                "validators" => [
                ]
            ]))
            ->add(new RepetableField([
                "name" => "plainPassword",
                "fields" => [
                    new PasswordField([
                        "name" => "first",
                        "label" => "Nouveau mot de passe",
                        "classCss" => "form-control",
                        "maxLength" => 50,
                        "minLength" => 8,
                        "validators" => [
                            new NotNullValidator("Vous devez indiquer un mot de passe"),
                            new MaxLengthValidator("Votre mot de passe ne doit pas avoir plus de 50 caractères", 50),
                            new MinLengthValidator("Votre mot de passe doit comporter au moins 8 caractères", 8)
                        ]
                    ]),
                    new PasswordField([
                        "name"=> "second",
                        "label" => "Confirmer votre nouveau mot de passe",
                        "classCss" => "form-control",
                        "maxLength" => 50,
                        "minLength" => 8,
                        "validators" => [
                            new NotNullValidator("Vous devez confirmer votre mot de passe"),
                        ]
                    ])
                ],
                "validators" => [
                    new SameValueValidator("Vos mot de passe doivent être identique")
                ]
            ]));
    }
}
