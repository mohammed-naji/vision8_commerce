<?php

use App\Models\Order;
use App\Models\User;
use App\Notifications\NewOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('testtest', function() {

//         $notification_channel = 'mail';
//         $channels = explode(',', $notification_channel);
//         dd($channels);
// });

// Dont Do This Just For Test Only
// Route::get('send-notification', function() {

//     // $user = Auth::user();

//     // Mail::to($user->email)->send( new InvoiceMail() );

//     // $user->notify(new NewOrderNotification());

// });


// Route::get('invoice', function() {
//     // return view('pdf.invoice');
//     $order = Order::find(2);
//     $pdf = Pdf::loadView('pdf.invoice', ['order' =>  $order]);
//     $pdf->save('invoices/latest.pdf');
// });


Route::get('send-notify', function() {
    $user = Auth::user();
    $order = Order::find(2);
    $user->notify(new NewOrder($order));
});


Route::get('read-notify', function() {
    return view('read_notify');
});

Route::get('read-notify/{id}', function($id) {
    // Auth::user()->notifications->find($id)->update(['read_at' => now()]);
    Auth::user()->notifications->find($id)->markAsRead();
    // return redirect(Auth::user()->notifications->find($id)->data['url']);
    return redirect()->back();
})->name('readd');

Route::delete('delete-notify/{id}', function($id) {
    Auth::user()->notifications->find($id)->delete();
    return redirect()->back();
})->name('deletee');


Route::get('read-all-notify', function() {
    Auth::user()->unreadnotifications->markAsRead();
    return redirect()->back();
})->name('readall');
