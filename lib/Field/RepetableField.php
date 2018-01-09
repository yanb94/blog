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

                $fields->setErrorMessage($msgInitial." ".$br.$this->errorMessage);
            }

            $widget .=  $fields->buildWidget();

            $i++;
        }

        return $widget;
    }
}
