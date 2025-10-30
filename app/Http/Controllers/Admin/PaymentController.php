<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('rental.genset','rental.user');

        if ($q = $request->input('q')) {
            $query->whereHas('rental', function($sub) use ($q) {
                $sub->whereHas('user', function($u) use ($q) {
                    $u->where('name', 'like', "%{$q}%");
                })->orWhereHas('genset', function($g) use ($q) {
                    $g->where('nama_genset', 'like', "%{$q}%");
                });
            });
        }

        $payments = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load('rental.genset','rental.user');
        return view('admin.payments.show', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate(['payment_status' => 'required|in:pending,paid,cancelled']);
        $payment->update(['payment_status' => $request->payment_status]);

        // Optionally, when payment is marked paid, you might want to update rental status.
        if ($request->payment_status === 'paid') {
            $rental = $payment->rental;
            if ($rental && $rental->status === 'pending') {
                // keep business rule simple: do not automatically activate rental here; admin can still do it separately
            }
        }

        return redirect()->back()->with('success', 'Status pembayaran diperbarui.');
    }
}
