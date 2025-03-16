<div>
    <ul>
        <li>ID : #{{ $product_review->id }}</li>
        <li>Date : {{ date('F j, Y', strtotime($product_review->created_at)) }}</li>
        <li>Product : {{ @$product_review->product->name }}</li>
        <li>Rating :
            @for($i=0; $i <= $product_review->rating; $i++)
                <i class="w-icon-star-full "></i>
            @endfor
        </li>
        <li>Status : {{ $product_review->status == 1 ? 'Approved' : 'Pending' }}</li>

        <li>Review : {!! nl2br($product_review->review) !!}</li>
    </ul>
</div>
