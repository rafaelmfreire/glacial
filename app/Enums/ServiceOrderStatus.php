<?php

namespace App\Enums;

enum ServiceOrderStatus: int {
    case Pendente   = 1;
    case Concluido  = 2;
    case Condenada  = 3;
    case Orcamento  = 4;
    case Oficina    = 5;
}