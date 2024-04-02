<div>
    <h1>Your order has been confirmed</h1>
    <span>Products</span>
    <ul>
        @foreach ($order['products'] as $product)
            <li>{{ $product['name'] }} - {{ $product['price'] }}EUR</li>
        @endforeach
    </ul>
    <span @style(['display: block','padding-bottom:1rem'])>Shipping: {{$order['shipping']}}EUR</span>
    <span @style(['display: block','padding-bottom:1rem'])>VAT: {{ $order['vat'] }}EUR</span>
    <span @style(['display: block','padding-bottom:1rem'])>Total: {{ $order['total'] }}EUR</span>
    <br/>
    <h2>Payments</h2>
    <ul>
        @foreach ($order['payments'] as $payment)
            @if($loop->first)
                <li>{{$loop->index+1}} payment: {{ $order['payments'][0] }} EUR (Paid)</li>
            @else
                <li>{{$loop->index+1}} payment: {{ $order['payments'][$loop->index] }} EUR</li>
            @endif
        @endforeach
    </ul>

</div>
