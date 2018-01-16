<?php

namespace Framework\FormBuilder;

use Framework\FormBuilder\ArticleFormBuilder;
use Framework\Field\SelectField;

use Framework\Entity;

class EditArticleFormBuilder extends ArticleFormBuilder
{
    const NAME_FORM = 'form_edit_article';

    protected $listMember = [];

    public function __construct(Entity $entity, string $crsf_token, $listMember)
    {
        parent::__construct($entity, $crsf_token);

        foreach ($listMember as $member) {
            $this->listMember[$member->getId()] = $member->getLogin();
        }
    }


    public function build()
    {
        parent::build();

        $this->form->add(
            new SelectField([
                "name" => "author",
                "label" => "Auteur",
                "classCss" => "form-control",
                "options" => $this->listMember
            ])
        )
        ;
    }
}
