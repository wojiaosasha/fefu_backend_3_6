<body>
Catalog
@include('catalog.category_list', ['categories', $categories])

@foreach($products as $product)
    <h1>
        <a href="{{ route('product', ['slug' => $product->slug]) }}">
            {{ $product->name }}
        </a>
    </h1>
    <p>
        {{ $product->price }} rub.
    </p>
@endforeach

<h3>{{ $products->links('pagination::semantic-ui') }}</h3>
</body>
</html>
