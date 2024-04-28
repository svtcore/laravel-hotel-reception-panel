<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Spatie\Permission\Traits\HasRoles;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, HasRoles;
}
