<?php

if (!isset($seg)) {
    exit;
}

function validarExtensao($foto) {
    switch ($foto) {
        case 'application/msword';
            return true;
        default :
            return false;
    }
}
