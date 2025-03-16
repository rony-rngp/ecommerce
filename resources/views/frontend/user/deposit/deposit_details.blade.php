<div>
    <ul>
        <li>ID : #{{ $deposit->id }}</li>
        <li>Date : {{ date('F j, Y', strtotime($deposit->created_at)) }}</li>
        <li>Amount : {{ $deposit->amount }} {{ base_currency_name() }}</li>
        <li>Payment Method : {{ $deposit->payment_method }} ({{ ucfirst($deposit->payment_type) }})</li>
        @if($deposit->payment_type == 'offline')
            <li class="mt-2 mb-1" style="list-style-type: disclosure-closed">Offline Payment Info:</li>
            @foreach($deposit->offline_payment_info ?? [] as $offline_payment_info)
                <li>{{ $offline_payment_info['key'] }} : {{ $offline_payment_info['value'] ?? '' }}</li>
            @endforeach
        @else
            <li>Transaction ID : {{ $deposit->transaction_id }}</li>
        @endif
        <li>Status : {{ $deposit->status }}</li>
    </ul>
</div>
