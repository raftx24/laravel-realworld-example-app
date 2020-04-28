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

        $this->middleware('auth.api')->except('index');
    }

    /**
     * Get all the invoices.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->respondWithTransformer(
            auth()->user()->invoices
        );
    }
}
