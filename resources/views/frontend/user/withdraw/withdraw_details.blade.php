<div>
    <ul>
        <li>ID : #{{ $withdraw->id }}</li>
        <li>Date : {{ date('F j, Y', strtotime($withdraw->created_at)) }}</li>
        <li>Amount : {{ $withdraw->amount }} {{ base_currency_name() }}</li>
        <li>Payment Method : {{ $withdraw->withdraw_method }}</li>
        <li class="mt-2 mb-1" style="list-style-type: disclosure-closed">{{ $withdraw->withdraw_method }} Info:</li>
        @foreach($withdraw->withdraw_method_information ?? [] as $withdraw_method_information)
            <li>{{ $withdraw_method_information['key'] }} : {{ $withdraw_method_information['value'] ?? '' }}</li>
        @endforeach
        <li>Status : {{ $withdraw->status }}</li>
    </ul>
</div>
