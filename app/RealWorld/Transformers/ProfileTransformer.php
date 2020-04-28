<?php

namespace App\RealWorld\Transformers;

class ProfileTransformer extends Transformer
{
    protected $resourceName = 'profile';

    public function transform($user)
    {
        return [
            'username'  => $user['username'],
            'bio'       => $user['bio'],
            'image'     => $user['image'],
            'following' => $user['following'],
            'balance' => $user->balance(),
        ];
    }
}