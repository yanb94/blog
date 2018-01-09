<?php

namespace Framework\Field;

use Framework\Field;

class TextField extends Field
{
    protected $cols;
    protected $rows;

    public function buildWidget()
    {
        $widget = "";

        if (!empty($this->errorMessage)) {
            $widget .= "<div class='alert alert-danger' role='alert'>".$this->errorMessage."</div>";
        }


        if (!empty($this->label)) {
            $widget .= "<label for=".$this->name.">".$this->label."</label>";
        }

        if (!empty($this->instruction)) {
            $widget .= "<span>".$this->instruction."</span>";
        }

        $widget .= "<textarea ";

        $widget .= "id=".$this->name." name=".$this->name;

        if (!empty($this->rows)) {
            $widget .= "rows=".$this->rows." ";
        }
        if (!empty($this->cols)) {
            $widget .= "cols=".$this->cols." ";
        }

        if (!empty($this->classCss)) {
            $widget .= "class=".$this->classCss." ";
        }

        $widget .= ">";

        if (!empty($this->value)) {
            $widget .= $this->value;
        }

        $widget .= "</textarea>";

        return $widget;
    }

    public function setCols(int $cols)
    {
        $this->cols = $cols;
    }

    public function getCols():int
    {
        return $this->cols;
    }

    public function setRows(int $rows)
    {
        $this->rows = $rows;
    }

    public function getRows():int
    {
        return $this->rows;
    }
}
