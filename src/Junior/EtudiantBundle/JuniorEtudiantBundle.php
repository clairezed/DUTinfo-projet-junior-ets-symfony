<?php

namespace Junior\EtudiantBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class JuniorEtudiantBundle extends Bundle {

    public function getParent() {
        return 'FOSUserBundle';
    }

}
