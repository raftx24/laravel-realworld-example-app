<?php

namespace App\Http\Controllers\Api;

use App\RealWorld\Transformers\InvoiceTransformer;

class InvoiceController extends ApiController
{
    /**
     * InvoiceController constructor.
     *
     * @param InvoiceTransformer $transformer
     */
    public function __construct(InvoiceTransformer $transformer)
    {
        $this->transformer = $transformer;

        $this->middleware('auth.api');
    }

    /**
     * Get all the invoices.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $invoices = auth()->user()->invoices;

        return $this->respondWithTransformer($invoices);
    }
}
