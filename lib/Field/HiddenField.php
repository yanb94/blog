<?php

namespace Framework\Field;

use Framework\Field;

class HiddenField extends Field
{
    const TYPE = "hidden";

    public function buildWidget(): string
    {
        $widget = "";

        $widget .= "<imput type='".HiddenField::TYPE."' ";
        $widget .= "id='".$this->getName()."' name='".$this->getName()."' ";
        $widget .= "value='".$this->getValue()."' ";

        $widget .= "/>";

        return $widget;
    }
}
