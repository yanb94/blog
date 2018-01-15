<?php

namespace Framework\FormBuilder;

use Framework\FormBuilder;
use Framework\Field\TextField;
use Framework\Validator\NotNullValidator;
use Framework\Validator\MaxLengthValidator;

class CommentFormBuilder extends FormBuilder
{
    const NAME_FORM = 'form_comment';

    public function build()
    {
        parent::build();

        $this->form->add(new TextField([
            "name"=>"contenu",
            "label"=> "Contenu",
            "classCss"=> "form-control",
            "rows" => 10,
            "instruction" => "Vous ne devez pas dépassé les 300 caractères",
            "validators" => [
                new NotNullValidator("Vous devez écrire un commentaire"),
                new MaxLengthValidator("Votre commentaire ne doit pas comporter plus de 300 caractères", 300)
            ]
        ]));
    }
}
