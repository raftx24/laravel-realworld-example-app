<?php

namespace App\RealWorld\Transformers;

use App\Enums\InvoiceType;

class InvoiceTransformer extends Transformer
{
    protected $resourceName = 'invoices';

    public function transform($data)
    {
        $data['type'] = InvoiceType::toString($data['type']);

        return $data;
    }
}