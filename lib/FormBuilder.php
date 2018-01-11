<?php

namespace Framework;

use Framework\Form;
use Framework\Entity;
use Framework\Field\HiddenField;

abstract class FormBuilder
{
    const NAME_FORM = 'form_';

    protected $form;
    protected $crsf_token;

    public function __construct(Entity $entity, string $crsf_token)
    {
        $this->setForm(new Form($entity, static::NAME_FORM));
        $this->setCrsfToken($crsf_token);
    }

    public function build()
    {
        $this->form
        ->add(new HiddenField([
            "name"=> "crsf_token",
            "value" =>  $this->getCrsfToken()
        ]));
    }

    public function setForm(Form $form)
    {
        $this->form = $form;
    }

    public function getForm():Form
    {
        return $this->form;
    }

    public function setCrsfToken(string $crsf_token)
    {
        $this->crsf_token = $crsf_token;
    }

    public function getCrsfToken()
    {
        return $this->crsf_token;
    }
}
