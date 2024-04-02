<div>
    <h1>
        {{$order['instalment']}} payment has automatically been made
    </h1>
    <h2>Next payment: {{$order['next_payment']}}</h2>
    <h2>Payments</h2>
    <ul>
        @foreach ($payments as $payment)
            @if($loop->index <= $order['instalment']-1)
                <li>{{$loop->index+1}} payment: {{$payment}} EUR (Paid)</li>
            @else
                <li>{{$loop->index+1}} payment: {{ $payment }} EUR</li>
            @endif
        @endforeach
    </ul>
</div>
