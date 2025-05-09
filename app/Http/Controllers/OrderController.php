<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Models\Order;
use App\Models\Payment;
use App\Notifications\OrderPlaced;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function checkout(): View
    {
        return view('orders.checkout');
    }

    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'address_id' => ['required'],
            'payment_method' => ['required'],
            'notes' => ['nullable', 'string']
        ]);

        $cart = cart();

        $order = Order::create([
            'order_number' => $orderID = Order::generateOrderNumber(),
            'order_date' => now()->format('Y-m-d'),
            'user_id' => auth()->id(),
            'payment_method' => $validated['payment_method'],
            'sub_total' => $cart->total,
            'grand_total' => $cart->total,
            'notes' => $validated['notes']
        ]);

        $order->payments()->create([
            'payment_number' => Payment::generatePaymentNumber(),
            'reference' =>  $orderID,
            'amount' =>  $cart->total,
            'method' =>  PaymentType::CASH,
        ]);

        $order->increment('paid_amount', $cart->total);
        $order->payment_status = PaymentStatus::PAID;

        $order->save();

        $cartItems = $cart->items->map(function ($item) {
            return $item->only(['product_id', 'quantity', 'price', 'total']);
        });

        $order->items()->createMany($cartItems->toArray());

        $address = auth()->user()->addresses()->find($validated['address_id']);

        $order->address()->create($address->replicate()->makeHidden(['id', 'addressable_id', 'addressable_type', 'is_default', 'created_at', 'updated_at'])->toArray());

        /**
         * Delete Cart and Cart Items
         */
        $cart->items()->delete();
        $cart->delete();

        return redirect()->route('account.orders.show', $order)
            ->with('success', 'Order placed successfully.');
    }

    public function index(): View
    {
        $orders = auth()->user()->orders()->latest()->paginate(10)
            ->withQueryString();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $userOrder = auth()->user()->orders()->where('id', $order->id)->first();

        if (is_null($userOrder)) {
            abort(404);
        }

        return view('orders.show', compact('order'));
    }
}
