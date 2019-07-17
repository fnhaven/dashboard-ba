<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\ErrorResponses;
use App\Http\StatusCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Payment;

use Carbon\Carbon;

use Hash;

class PaymentController extends Controller
{
    use ErrorResponses;

    public function make(Request $request){

    }

    public function notify(Request $request){

    }
}