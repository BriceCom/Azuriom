<?php

namespace Azuriom\Plugin\FreeKassa;

use Azuriom\Models\User;
use Azuriom\Plugin\Shop\Cart\Cart;
use Azuriom\Plugin\Shop\Models\Payment;
use Azuriom\Plugin\Shop\Payment\PaymentMethod;
use Illuminate\Http\Request;

class FreeKassaMethod extends PaymentMethod
{
    /**
     * The payment method id name.
     *
     * @var string
     */
    protected $id = 'freekassa';

    /**
     * The payment method display name.
     *
     * @var string
     */
    protected $name = 'FreeKassa';

    public function startPayment(Cart $cart, float $amount, string $currency)
    {
        
        $payment = $this->createPayment($cart, $amount, $currency);

        $project_id = $this->gateway->data['project-id'];
        $pay_id = $payment->id;
        //$desc = $this->gateway->data['desc'];
        $success_url = '';
        $fail_url = '';
        $secret_key = $this->gateway->data['private-key'];

        $arr_sign = array( 
            $project_id, 
            $amount, 
            $secret_key,
            $currency, 
            $pay_id
        );
        $sign = md5(implode(':', $arr_sign));

        return redirect()->away("https://pay.freekassa.com/?m={$project_id}&oa={$amount}&currency={$currency}&s={$sign}&o={$pay_id}");
    }

    public function notification(Request $request, ?string $paymentId)
    {

        $project_id = $this->gateway->data['project-id'];
        $secret_key = $this->gateway->data['private-key-2'];

        $arr_sign = array(
            $project_id,
            $request->input('AMOUNT'),
            $secret_key,
            $request->input('MERCHANT_ORDER_ID')
        );


        $sign = md5(implode(":", $arr_sign));

        if($sign != $request->input('SIGN')){
            return response()->json(['status' => 'invalid sign.']);
        }
    

        //Так же, рекомендуется добавить проверку на сумму платежа и не была ли эта заявка уже оплачена или отменена


        $payment = Payment::findOrFail($request->input('MERCHANT_ORDER_ID'));
        return $this->processPayment($payment, $request->input('intid'));

    }

   public function success(Request $request)
    {
        return redirect()->route('shop.home')->with('success', trans('messages.status.success'));
    }

    public function view()
    {
        return 'freekassa::admin.freekassa';
    }

    public function rules()
    {
        return [
            'private-key' => ['required', 'string'],
            'private-key-2' => ['required', 'string'],
            'project-id' => ['required', 'string'],
        ];
    }

    public function image()
    {
        return asset('plugins/freekassa/img/freekassa.svg');
    }

}
