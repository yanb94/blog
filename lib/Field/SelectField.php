<?php

namespace Framework\Field;

use Framework\Field;

class SelectField extends Field
{
    protected $options = [];

    public function buildWidget():string
    {
        $widget = "";

        if (!empty($this->errorMessage)) {
            $widget .= "<div class='alert alert-danger' role='alert'>".$this->errorMessage."</div>";
        }


        if (!empty($this->label)) {
            $widget .= "<label>".$this->label."</label>";
        }


        $widget .= "<select id=\"".$this->name."\" name=\"".$this->name."\" ";

        if (!empty($this->classCss)) {
            $widget .= "class=\"".$this->classCss."\" ";
        }

        $widget .= ">";

        foreach ($this->options as $key => $value) {
            if ($this->value == $key) {
                $widget .= "<option value='".$key."' selected >".$value."</option>";
            } else {
                $widget .= "<option value='".$key."' >".$value."</option>";
            }
        }

        $widget .= "</select>";

        return $widget;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    public function getOptions():array
    {
        return $this->options;
    }
}
