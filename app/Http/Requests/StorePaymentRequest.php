<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Rental;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        // only owner of rental or admin can upload/modify payment via this request
        $rentalId = $this->input('rental_id') ?? $this->route('rental');
        $rental = $rentalId ? Rental::find($rentalId) : null;
        if (!$rental) return false;
        return $this->user() && ($this->user()->isAdmin() || $this->user()->id === $rental->user_id);
    }

    public function rules(): array
    {
        return [
            'rental_id' => 'required|exists:rentals,id',
            'payment_date' => 'nullable|date',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:transfer,cash',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ];
    }
}
