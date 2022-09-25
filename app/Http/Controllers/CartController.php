<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Mail\InvoiceMail;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function add_to_cart(Request $request)
    {
        $request->validate([
            'quantity' => 'gt:0',
            'product_id' => 'exists:products,id'
        ]);

        $product = Product::find($request->product_id);

        Cart::updateOrCreate([
            'product_id' => $request->product_id,
            'user_id' => Auth::id()
        ], [
            'price' => $product->sale_price ? $product->sale_price : $product->price,
            'quantity' => DB::raw('quantity + '.$request->quantity),
        ]);

        return redirect()->back()->with('msg', 'Product added to cart successfully');
    }

    public function cart()
    {
        return view('site.cart');
    }

    public function update_cart(Request $request)
    {
        foreach($request->qyt as $product_id => $new_qyt) {
            Cart::where('product_id', $product_id)
                ->where('user_id', Auth::id())
                ->update(['quantity' => $new_qyt]);
        }

        return redirect()->back();
    }

    public function remove_cart($id)
    {
        Cart::destroy($id);

        return redirect()->back();
    }

    public function checkout()
    {
        $total = Auth::user()->carts()->sum(DB::raw('price * quantity'));

        if($total == 0) {
            return redirect()->route('site.shop');
        }

        $url = "https://eu-test.oppwa.com/v1/checkouts";
        $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
                    "&amount=$total" .
                    "&currency=USD" .
                    "&paymentType=DB";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $responseData = json_decode($responseData, true);
        $id = $responseData['id'];

        return view('site.checkout', compact('id'));
    }

    public function payment(Request $request)
    {
        // dd($request->all());
        $resourcePath = $request->resourcePath;

        $url = "https://eu-test.oppwa.com$resourcePath";
        $url .= "?entityId=8a8294174b7ecb28014b9699220015ca";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $responseData = json_decode($responseData, true);

        // "code": "000.100.110",
        $code = $responseData['result']['code'];
        if($code == '000.100.110') {
            $amount = $responseData['amount'];
            $trasnaction_id = $responseData['id'];
            // echo 'Done';

            DB::beginTransaction();
            try {
                // create new order
                $order = Order::create([
                    'total' => $amount,
                    'user_id' => Auth::id()
                ]);

                // add carts to order items
                foreach(Auth::user()->carts as $cart) {
                    OrderItem::create([
                        'price' => $cart->price,
                        'quantity' => $cart->quantity,
                        'product_id' => $cart->product_id,
                        'user_id' => $cart->user_id,
                        'order_id' => $order->id
                    ]);

                    // decrease the product quantity
                    $cart->product()->decrement('quantity', $cart->quantity);

                    // delete user cart
                    $cart->delete();

                }

                // create new payment
                Payment::create([
                    'total' => $amount,
                    'user_id' => Auth::id(),
                    'order_id' => $order->id,
                    'transaction_id' => $trasnaction_id
                ]);

                DB::commit();
            }catch(Exception $e) {
                DB::rollBack();
                throw new Exception($e->getMessage());
            }

            // Send Invoice
            $invname = rand().rand().'.pdf';
            Pdf::loadView('pdf.invoice', ['order' =>  $order])->save('invoices/'.$invname);
            Mail::to(Auth()->user()->email)->send( new InvoiceMail(Auth::user()->name, $invname) );

            // redirect to success page
            return redirect()->route('site.success');
        }else {
            // echo 'Error';
            // redirect to fail page
            return redirect()->route('site.fail');
        }
    }

    public function success()
    {
        return view('site.success');
    }

    public function fail()
    {
        return view('site.fail');
    }

}
