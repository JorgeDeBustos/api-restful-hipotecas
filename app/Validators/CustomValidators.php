<?php

namespace App\Validators;

class CustomValidators
{
    public static function isValidEmail($value)
    {
        return preg_match('/^\S+@\S+\.\S+$/', $value) === 1;
    }

    public static function isValidDni($cif)
    {
        $cif = strtoupper($cif);
        $validDni = true;

         // Invalid format
         if (!preg_match('/((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)/', $cif)) {
            $validDni = false;
        }

        if ($validDni) {
            for ($i = 0; $i < 9; $i++) {
                $num[$i] = substr($cif, $i, 1);
            }
            //NIF
            if (preg_match('/(^[0-9]{8}[A-Z]{1}$)/', $cif)) {
                if (!($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 0, 8) % 23, 1))){
                    $validDni = false;
                }
            }

            //NIE Extranjeros
            if (preg_match('/^[XYZ]{1}/', $cif)) {
                if (!($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr(str_replace(array('X', 'Y', 'Z'), array('0', '1', '2'), $cif), 0, 8) % 23, 1))){
                    $validDni = false;
                }
            }
        }
        return $validDni;
    }
}
