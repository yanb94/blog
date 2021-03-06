<?php

namespace Framework\FormBuilder;

use Framework\FormBuilder;

use Framework\Field\StringField;
use Framework\Field\PasswordField;
use Framework\Field\EmailField;
use Framework\Field\RepetableField;
use Framework\Field\DateField;
use Framework\Field\SelectField;

use Framework\Validator\NotNullValidator;
use Framework\Validator\MaxLengthValidator;
use Framework\Validator\MinLengthValidator;
use Framework\Validator\EmailValidator;
use Framework\Validator\SameValueValidator;
use Framework\Validator\DateValidator;
use Framework\Validator\BirthDateValidator;

class EditMemberFormBuilder extends FormBuilder
{
    const NAME_FORM = 'form_edit_member';

    public function build()
    {
        parent::build();

        $this->form
            ->add(new StringField([
                "name"=> "login",
                "label"=> "Pseudo",
                "maxLength" => 50,
                "minLength" => 3,
                "classCss" => "form-control",
                "validators" => [
                    new NotNullValidator("Vous devez indiquer un pseudo"),
                    new MaxLengthValidator("Votre pseudo ne doit pas comporter plus de 50 caractères", 50),
                    new MinLengthValidator("Votre pseudo doit comporter au moins 5 caractères", 5)
                ]
            ]))
            ->add(new SelectField([
                "name" => "civilite",
                "label" => "Civilité",
                "classCss" => "form-control",
                "options" => [
                    "h" => "Monsieur",
                    "f" => "Madame"
                ]
            ]))
            ->add(new StringField([
                "name"=> "firstname",
                "label" => "Nom",
                "maxLength" => 100,
                "minLength" => 2,
                "classCss" => "form-control",
                "validators" => [
                    new NotNullValidator("Vous devez indiquer votre nom"),
                    new MaxLengthValidator("Votre nom ne doit pas comporter plus de 100 caractères", 50),
                    new MinLengthValidator("Votre nom doit comporter au moins 2 caractères", 5)
                ]
            ]))
            ->add(new StringField([
                "name"=> "lastname",
                "label" => "Prénom",
                "maxLength" => 100,
                "minLength" => 2,
                "classCss" => "form-control",
                "validators" => [
                    new NotNullValidator("Vous devez indiquer votre prénom"),
                    new MaxLengthValidator("Votre prénom ne doit pas comporter plus de 100 caractères", 50),
                    new MinLengthValidator("Votre prénom doit comporter au moins 2 caractères", 5)
                ]
            ]))
            ->add(new EmailField([
                "name"=> "email",
                "label"=> "Adresse Email",
                "maxLength"=> 255,
                "classCss" => "form-control",
                "validators" => [
                    new NotNullValidator("Vous devez indiquer votre email"),
                    new EmailValidator("Vous devez entrez un email correct"),
                    new MaxLengthValidator("Votre email ne doit pas comporter plus de 255 caractères", 255)
                ]
            ]))
            ->add(new DateField([
                "name" => "plainBirthDate",
                "label" => "Date de naissance",
                "classCss" => "form-control my-date-field",
                "maxYear" => (new \DateTime('- 13 year'))->format('Y'),
                "minYear" => (new \DateTime('- 120 year'))->format('Y'),
                "validators" => [
                    new DateValidator('Votre date doit être correct'),
                    new BirthDateValidator('Vous devez avoir plus de 13 ans')
                ]
            ]))
        ;
    }
}
