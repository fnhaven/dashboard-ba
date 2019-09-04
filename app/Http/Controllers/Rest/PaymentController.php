<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Http\ErrorResponses;
use App\Http\StatusCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Payment as UserPayment;
use App\Catalog;
use App\Log;

use App\Services\Payment;

use Carbon\Carbon;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Services\Adapter\GuzzleHttpAdapter;

use Hash;

class PaymentController extends Controller
{
    use ErrorResponses;

    public function make(Request $request){
        $user = JWTAuth::parseToken()->authenticate();

        $validator  = Validator::make($request->all(), [
            'user_address' => 'required|exists:user_address,id',
            'catalog' => 'required|exists:catalogs,slug',
            'qty' => 'required|min:0',
        ]);

        if($validator->fails()) {
            return $this->responseErrorValidation(__("Whoops!"), $validator->errors());
        }

        $catalog = Catalog::where('slug', $request->catalog)->first();

        if($catalog->stock < $request->qty){
            return $this->responseError('Insufficient product.', StatusCodes::INTERNAL_SERVER_ERROR);
        }

        # save payment information
        $user_payment = new UserPayment;

        $user_payment->user_id = $user->id;
        $user_payment->user_address_id = (int)$request->user_address;
        $user_payment->catalog_id = $catalog->id;
        $user_payment->payment_code = 'BAOI-' . date('dmYHis');
        $user_payment->payment_type = '?';
        $user_payment->description = '?';
        $user_payment->value = (int)$request->qty;
        $user_payment->price = $catalog->price;
        $user_payment->total_price = $catalog->price * (int)$request->qty;
        $user_payment->status_detail = 'Requested';

        # TODO: count ongkir ny address (JNE)

        $user_payment->save();

        # request a payment
        $payment = Payment::request([
            'transaction_details' => [
                'order_id' => $user_payment->payment_code,
                'gross_amount' => $user_payment->total_price
            ],
            'item_details' => [
                [
                    'id' => $request->slug,
                    'price' => $catalog->price,
                    'quantity' => (int)$request->qty,
                    'name' => $catalog->name,
                    'merchant_name' => 'Beranda Anak'
                ]
            ],
            'customer_details' => [
                'email' => $user->email,
                'phone' => $user->phone_number
            ],
            'callbacks'=> [
                'finish'=> 'http://devdashboard.beranda-anak.com/api/payment/notify'
            ],
            'expiry'=> [
                // 'start_time'=> '2018-12-13 18:11:08 +0700',
                'start_time'=> Carbon::now()->format('Y-m-d H:i:s +0700'),
                'unit'=> 'hours',
                'duration'=> 24
            ],
        ]);

        if(!$payment){
            return $this->responseError('Failed to request a payment. please try again later.', StatusCodes::INTERNAL_SERVER_ERROR);
        }

        # Log the response
        $log = new Log;

        $log->user_id = $user->id;
        $log->user_type = 'customer';
        $log->activity = 'request payment';
        $log->activity_detail = json_encode($payment);
        $log->link = url('api/payment/make');

        $log->save();

        return response()->json(['status' => true, 'data' => $payment, 'order_id' => $user_payment->payment_code], 200);
    }

    public function notify(Request $request){
        # TODO: check payment
        #       decrease stock if payment success
        #       update status
        #       return to view based on status code

        if(! $user_payment = UserPayment::where('payment_code', $request->order_id)->where('status_detail', 'Requested')->first() ){
            return $this->responseError('Payment not found / Already validate', StatusCodes::NOT_FOUND);
        }

        $_payment = new \App\Services\Payment\Payment(new GuzzleHttpAdapter(), config('midtrans.api'));
        $payment = $_payment->status($request->order_id);

        # payment is requested
        if($payment->status_code == "404"){
            return $this->responseError($payment->status_message, StatusCodes::NOT_FOUND);
        }

        # payment pending
        if($payment->status_code == "201"){
            return $this->responseError($payment->status_message, StatusCodes::NOT_FOUND);
        }

        # payment denied
        if($payment->status_code == "202"){
            return $this->responseError($payment->status_message, StatusCodes::NOT_FOUND);
        }

        # payment success
        if($payment->status_code == "200" && $payment->fraud_status == 'accept' && $payment->transaction_status == 'capture'){
            $user_payment->status = 1;
            $user_payment->status_detail = 'Accepted';
            $user_payment->payment_type = $payment->card_type;
            $user_payment->description = $payment->status_message;

            $user_payment->save();
        }

        # payment failed
        if($payment->status_code !== "200"){
            return $this->responseError('Failed to request a notify payment. please try again later.', StatusCodes::INTERNAL_SERVER_ERROR);
        }

        dd('on develop.', $request->all(), $payment, $user_payment);
    }
}