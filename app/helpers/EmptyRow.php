<?php


namespace App\helpers;


class EmptyRow
{
    public function __get($property_name) {
        return new EmptyRow();
    }

    public function __call($method_name, $args) {
        return new EmptyRow();
    }

    public function __toString() {
        return '';
    }
}
