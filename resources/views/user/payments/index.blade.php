@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pembayaran Saya</h1>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Rental</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->rental->genset->nama_genset ?? '-' }}</td>
                    <td>Rp{{ number_format($p->amount,0,',','.') }}</td>
                    <td>{{ $p->payment_status }}</td>
                    <td><a href="{{ route('user.payments.show', $p) }}" class="btn btn-sm btn-outline-primary">Lihat</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $payments->links() }}
</div>
@endsection
