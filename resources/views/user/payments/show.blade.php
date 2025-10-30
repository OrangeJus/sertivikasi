@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Pembayaran #{{ $payment->id }}</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Rental:</strong> {{ $payment->rental->genset->nama_genset ?? '-' }}</p>
            <p><strong>Jumlah:</strong> Rp{{ number_format($payment->amount,0,',','.') }}</p>
            <p><strong>Metode:</strong> {{ $payment->payment_method }}</p>
            <p><strong>Tanggal:</strong> {{ $payment->payment_date?->format('Y-m-d H:i') ?? '-' }}</p>
            <p><strong>Status:</strong> {{ $payment->payment_status }}</p>
            <p><strong>Bukti:</strong>
                @if($payment->payment_proof)
                    <a href="{{ asset('storage/'.$payment->payment_proof) }}" target="_blank">Lihat Bukti</a>
                @else
                    -
                @endif
            </p>
        </div>
    </div>

    <a href="{{ route('user.payments.index') }}" class="btn btn-link mt-3">Kembali</a>
</div>
@endsection
