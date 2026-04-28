<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('booking')->orderBy('created_at', 'desc')->paginate(10);
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $bookings = Booking::whereDoesntHave('payments')->get(); // Only unpaid bookings
        return view('payments.create', compact('bookings'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,paid,refunded,failed',
            'payment_method' => 'nullable|string|max:50',
            'transaction_id' => 'nullable|string|max:100|unique:payments',
            'paid_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if payment already exists for this booking
        if (Payment::where('booking_id', $request->booking_id)->exists()) {
            return redirect()->back()->withErrors(['booking_id' => 'Payment already exists for this booking.'])->withInput();
        }

        Payment::create($request->validated());

        return redirect()->route('payments.index')
            ->with('success', 'Payment created successfully!');
    }

    public function show(Payment $payment)
    {
        $payment->load('booking.user');
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $bookings = Booking::get();
        return view('payments.edit', compact('payment', 'bookings'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,paid,refunded,failed',
            'payment_method' => 'nullable|string|max:50',
            'transaction_id' => 'nullable|string|max:100|unique:payments,transaction_id,' . $payment->id,
            'paid_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $payment->update($request->validated());

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment updated successfully!');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully!');
    }
}

