<?php

namespace Framework\Field;

use Framework\Field;

class DateField extends Field
{
    protected $maxYear;
    protected $minYear;

    public function buildWidget(): string
    {
        $month = array(
                     1 => 'Janvier',
                     2 => 'Février',
                     3 => 'Mars',
                     4 => 'Avril',
                     5 => 'Mai',
                     6 => 'Juin',
                     7 => 'Juillet',
                     8 => 'Août',
                     9=> 'Septembre',
                    10=> 'Octobre',
                    11 => 'Novembre',
                    12 => 'Décembre'
                );

        $widget = "";

        if (!empty($this->errorMessage)) {
            $widget .= "<div class='alert alert-danger' role='alert'>".$this->errorMessage."</div>";
        }


        if (!empty($this->label)) {
            $widget .= "<label>".$this->label."</label></br>";
        }


        $widget .= "<select id=\"".$this->name."[day]\" name=\"".$this->name."[day]\" ";

        if (!empty($this->classCss)) {
            $widget .= "class='".$this->classCss."' ";
        }

        $widget .= ">";

        for ($i=1; $i < 32; $i++) {
            if (!empty($this->value) && $this->value['day'] == $i) {
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
            if (!empty($this->value) && $this->value['month'] == $i) {
                $widget .= "<option value='".$i."' selected >".$month[$i]."</option>";
            } else {
                $widget .= "<option value='".$i."' >".$month[$i]."</option>";
            }
        }

        $widget .= "</select>";

        $widget .= "<select id=\"".$this->name."[year]\" name=\"".$this->name."[year]\" ";

        if (!empty($this->classCss)) {
            $widget .= "class='".$this->classCss."' ";
        }

        $widget .= ">";


        for ($i = $this->maxYear; $i > $this->minYear; $i--) {
            if (!empty($this->value) && $this->value['year'] == $i) {
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
