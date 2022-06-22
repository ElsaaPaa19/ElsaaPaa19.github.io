<?php

namespace App\Modules\Member\Controllers;

use App\Controllers\BaseController;

class Member extends BaseController
{
    public function __construct()
    {
    }

    public function index()
    {
        //memanggil function di model

        return view('App\Modules\Member\Views/member', [
            'title' => 'Member',
        ]);
    }
}
