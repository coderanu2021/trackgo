<!DOCTYPE html>
<html>
<head>
    <title>Product Test</title>
</head>
<body>
    <h1 style="color: red;">PRODUCT TEST PAGE</h1>
    
    <h2>Products Data:</h2>
    <p>Products variable exists: {{ isset($products) ? 'YES' : 'NO' }}</p>
    
    @if(isset($products))
        <p>Products count: {{ $products->count() }}</p>
        <p>Products type: {{ get_class($products) }}</p>
        
        @if($products->count() > 0)
            <h3>Products List:</h3>
            @foreach($products as $index => $product)
                <div style="border: 1px solid black; margin: 10px; padding: 10px;">
                    <strong>Product {{ $index + 1 }}:</strong><br>
                    ID: {{ $product->id }}<br>
                    Title: {{ $product->title }}<br>
                    Price: ${{ $product->price }}<br>
                    Active: {{ $product->is_active ? 'YES' : 'NO' }}<br>
                    Category: {{ $product->category->name ?? 'No Category' }}
                </div>
            @endforeach
        @else
            <p style="color: red;">No products found in collection!</p>
        @endif
    @else
        <p style="color: red;">Products variable not passed to view!</p>
    @endif
</body>
</html>