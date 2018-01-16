<?php

namespace Framework\FormBuilder;

use Framework\FormBuilder;
use Framework\Field\TextField;
use Framework\Field\StringField;

use Framework\Validator\NotNullValidator;
use Framework\Validator\MaxLengthValidator;
use Framework\Validator\MinLengthValidator;

class ArticleFormBuilder extends FormBuilder
{
    const NAME_FORM = 'form_article';

    public function build()
    {
        parent::build();

        $this->form
        ->add(new StringField([
            "name"=> "titre",
            "label"=> "Titre de l'article",
            "maxLength" => 50,
            "minLength" => 5,
            "classCss" => "form-control",
            "validators" => [
                new NotNullValidator("Vous devez écrire un titre"),
                new MaxLengthValidator("Votre titre ne doit pas dépassé 50 caractères", 50),
                new MinLengthValidator("Votre titre doit comporter au moins 5 caractères", 5)
            ]
        ]))
        ->add(new TextField([
            "name" => "chapo",
            "label" => "Description courte",
            "classCss" => "form-control",
            "rows" => 5,
            "validators" => [
                new NotNullValidator("Vous devez remplir ce champ"),
                new MaxLengthValidator("Votre description ne doit pas dépassé 300 caractères", 300),
                new MinLengthValidator("Votre description doit comporter au moins 20 caractères", 20)
            ]
        ]))
        ->add(new TextField([
            "name" => "contenu",
            "label" => "Contenu de l'article",
            "classCss" => "form-control",
            "rows" => 20,
            "validators" => [
                new NotNullValidator("Ce champ ne doit pas resté vide")
            ]
        ]));
    }
}
