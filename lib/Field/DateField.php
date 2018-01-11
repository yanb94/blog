<?php

namespace Framework\Field;

use Framework\Field;

class DateField extends Field
{
    protected $maxYear;
    protected $minYear;

    public function buildWidget(): string
    {
        $widget = "";

        if (!empty($this->errorMessage)) {
            $widget .= "<div class='alert alert-danger' role='alert'>".$this->errorMessage."</div>";
        }


        if (!empty($this->label)) {
            $widget .= "<label>".$this->label."</label>";
        }


        $widget .= "<select id=\"".$this->name."[day]\" name=\"".$this->name."[day]\" ";

        if (!empty($this->classCss)) {
            $widget .= "class='".$this->classCss."' ";
        }

        $widget .= ">";

        for ($i=1; $i < 32; $i++) {
            if (!empty($this->value) and $this->value['day'] == $i) {
                $widget .= "<option value='".$i."' selected >".$i."</option>";
            } else {
                $widget .= "<option value='".$i."' >".$i."</option>";
            }
        }

        $widget .= "</select>";

        $widget .= "<select id=\"".$this->name."[month]\" name=\"".$this->name."[month]\" ";

        if (!empty($this->classCss)) {
            $widget .= "class='".$this->classCss."' ";
        }

        $widget .= ">";

        for ($i=1; $i < 13; $i++) {
            if (!empty($this->value) and $this->value['month'] == $i) {
                $widget .= "<option value='".$i."' selected >".$i."</option>";
            } else {
                $widget .= "<option value='".$i."' >".$i."</option>";
            }
        }

        $widget .= "</select>";

        $widget .= "<select id=\"".$this->name."[year]\" name=\"".$this->name."[year]\" ";

        if (!empty($this->classCss)) {
            $widget .= "class='".$this->classCss."' ";
        }

        $widget .= ">";


        for ($i = $this->maxYear; $i > $this->minYear; $i--) {
            if (!empty($this->value) and $this->value['year'] == $i) {
                $widget .= "<option value='".$i."' selected >".$i."</option>";
            } else {
                $widget .= "<option value='".$i."' >".$i."</option>";
            }
        }

        $widget .= "</select>";

        return $widget;
    }

    public function setMaxYear(int $date)
    {
        $this->maxYear = $date;
    }

    public function setMinYear(int $date)
    {
        $this->minYear = $date;
    }
}