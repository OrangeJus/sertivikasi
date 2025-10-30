<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Payment;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::whereHas('rental', function($q){
            $q->where('user_id', auth()->id());
        })->with('rental.genset')->orderByDesc('created_at')->paginate(10);

        return view('user.payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        // Accept rental id via query parameter: ?rental_id=123
        $rentalId = $request->input('rental_id');
        $rental = Rental::where('id', $rentalId)->where('user_id', auth()->id())->firstOrFail();
        return view('user.payments.create', compact('rental'));
    }

    public function store(StorePaymentRequest $request)
    {
        $data = $request->validated();

        // if payment exists, update; otherwise create
        $payment = Payment::where('rental_id', $data['rental_id'])->first();

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payments', 'public');
            $data['payment_proof'] = $path;
        }

        if ($payment) {
            $payment->update($data);
        } else {
            $payment = Payment::create($data);
        }

        return redirect()->route('user.payments.show', $payment)->with('success', 'Bukti pembayaran berhasil diunggah.');
    }

    public function show(Payment $payment)
    {
        // ensure owner or admin
        $this->authorize('view', $payment->rental);
        $payment->load('rental.genset');
        return view('user.payments.show', compact('payment'));
    }
}
