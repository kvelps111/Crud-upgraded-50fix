<x-layout>
    <x-slot:title>
        Show a product
    </x-slot:title>

    @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h1>{{ $product->name }}</h1>
    <h4>Quantity: {{ $product->quantity }}</h4>
    <p>{{ $product->description }}</p>

    <h3>Birkas:</h3>

    <ul id="product-tags">
        @foreach($product->tags as $tag)
            <li>{{ $tag->name }}</li>
        @endforeach
    </ul>

    <input type="text" id="new-tag-name" placeholder="Pievienot birku">
    <button id="add-tag-btn" data-url="{{ route('tags.store', $product) }}">
        Pievienot
    </button>

    <a href="{{ route('products.edit', $product) }}">Edit</a>

    <form action="{{ route('products.destroy', $product) }}" method="post">
        @csrf
        @method('DELETE')
        <input type="submit" value="Delete">
    </form>

    @vite(['resources/js/product-quantity.js', 'resources/js/product-tags.js'])
</x-layout>
