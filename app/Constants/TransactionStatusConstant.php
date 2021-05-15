<?php
namespace App\Constants;

abstract class TransactionStatusConstant
{

    use \App\Traits\ConstantTrait;
    CONST PAID = 'Pago';
    CONST NOT_PAID = 'Nao pago';

}
