<?php

namespace Framework\Field;

use Framework\Field;

class HiddenField extends Field
{
    const TYPE = "hidden";

    public function buildWidget(): string
    {
        $widget = "";

        $widget .= "<input type='".HiddenField::TYPE."' ";
        $widget .= "id='".$this->getName()."' name='".$this->getName()."' ";
        
        if (!empty($this->value)) {
            $widget .= "value='".htmlspecialchars($this->getValue())."' ";
        }

        $widget .= "/>";

        return $widget;
    }
}
