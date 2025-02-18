<?php

use App\Helpers\GlobalHelper;
use App\Helpers\KeysHelper;
use App\Helpers\ValidatorHelper;

function globalHelper() {
    return new GlobalHelper;
}

function validatorHelper() {
    return new ValidatorHelper;
}

function keyHelper() {
    return new KeysHelper;
}