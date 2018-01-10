<?php

namespace Framework\Field;

use Framework\Field;

class RepetableField extends Field
{
    protected $fields = [];

    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    public function setValue($values)
    {
        parent::setValue($values);

        foreach ($this->fields as $field) {
            $field->setValue($this->value[$field->getName()]);
        }
    }

    public function buildWidget(): string
    {
        $widget = "";

        $lastFieldsIndex = count($this->fields);


        $i = 1;
        foreach ($this->fields as $field) {
            if ($i == $lastFieldsIndex) {
                $msgInitial = $field->getErrorMessage();
                $br = "";

                if (!empty($msgInitial)) {
                    $br = "</br>";
                }

                $field->setErrorMessage($msgInitial." ".$br.$this->errorMessage);
            }

            $fieldName = $field->getName();
            $field->setName($this->name."[".$fieldName."]");

            $widget .=  $field->buildWidget();

            $i++;
        }

        return $widget;
    }

    public function isValid():bool
    {
        $valid = parent::isValid();

        foreach ($this->fields as $field) {
            foreach ($field->getValidators() as $validator) {
                if (!$validator->isValid($field->getValue())) {
                    $field->setErrorMessage($validator->getErrorMessage());
                    $valid = false;
                    break;
                }
            }
        }

        return $valid;
    }
}
