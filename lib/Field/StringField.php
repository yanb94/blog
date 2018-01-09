<?php

namespace Framework\Field;

use Framework\Field;

class StringField extends Field
{
    const TYPE = "text";

    protected $maxLength;
    protected $minLength;

    public function buildWidget():string
    {
        $widget = "";

        if (!empty($this->errorMessage)) {
            $widget .= "<div class='alert alert-danger' role='alert'>".$this->errorMessage."</div>";
        }


        if (!empty($this->label)) {
            $widget .= "<label for='".$this->name."'>".$this->label."</label>";
        }

        if (!empty($this->instruction)) {
            $widget .= "<span>".$this->instruction."</span>";
        }

        $widget .= "<input type='".static::TYPE."' ";

        $widget .= "id='".$this->getName()."' name='".$this->getName()."' ";

        if (!empty($this->classCss)) {
            $widget .= "class='".$this->classCss."' ";
        }


        if (!is_null($this->value)) {
            $widget .= "value='".$this->value."' ";
        }

        if (!empty($this->maxLength)) {
            $widget .= "maxLength='".$this->maxLength."' ";
        }

        if (!empty($this->minLength)) {
            $widget .= "minLength='".$this->minLength."' ";
        }

        $widget .= "/>";

        return $widget;
    }

    public function setMaxLength(int $maxLength)
    {
        $this->maxLength = $maxLength;
    }

    public function setMinLength(int $minLength)
    {
        $this->minLength = $minLength;
    }
}
