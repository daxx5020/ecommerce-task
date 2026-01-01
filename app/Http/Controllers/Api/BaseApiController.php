<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;

class BaseApiController extends Controller
{
    use ApiResponseTrait;
}
