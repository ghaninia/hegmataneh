<?php

namespace App\Services\Guest;

use Illuminate\Http\Request;
use App\Services\Guest\GuestServiceInterface;

class GuestService implements GuestServiceInterface
{
    protected $request , $userToken ;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

}
