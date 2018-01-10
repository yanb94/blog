<?php

namespace Framework;

use Framework\Entity;
use Framework\Field;

class Form
{
    protected $entity;
    protected $fields = [];
    protected $name;

    public function __construct(Entity $entity, string $name)
    {
        $this->setEntity($entity);
        $this->setName($name);
    }


    public function add(Field $field): self
    {
        $nameFields = $field->getName();

        $method = "get".ucfirst($nameFields);
        if (method_exists($this->entity, $method)) {
            $field->setValue($this->entity->$method());
        }

        $this->fields[] = $field;

        return $this;
    }

    public function isValid(): bool
    {
        $valid = true;

        foreach ($this->fields as $field) {
            if (!$field->isValid()) {
                $valid = false;
            }
        }

        return $valid;
    }

    public function createView():string
    {
        $view = '';

        foreach ($this->fields as $field) {
            $nameField = $field->getName();

            $field->setName($this->name.'['.$nameField.']');
            $view .= $field->buildWidget().'</br>';
        }

        return $view;
    }

    public function setEntity(Entity $entity)
    {
        $this->entity = $entity;
    }

    public function getEntity(): Entity
    {
        return $this->entity;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName():string
    {
        return $this->name;
    }
}
