<x-layout>
    <x-slot:title>
        All products
    </x-slot:title>

    <ul class="product-list">
        @foreach ($products as $product)
            <li>
                <h1>{{ $product->name }}</h1>
                <p>{{ $product->description }}</p>

                {{-- PRODUCT TAGS --}}
                @if ($product->tags->count() > 0)
                    <div class="product-tags">
                        <strong>Birkas:</strong>
                        <ul>
                            @foreach ($product->tags as $tag)
                                <li class="tag-badge">{{ $tag->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <p class="no-tags">No tags</p>
                @endif

                <div class="product-actions">
                    <a href="{{ route('products.show', $product) }}" class="btn btn-show">Show</a>
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-edit">Edit</a>

                    <form action="{{ route('products.destroy', $product) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete" class="btn btn-delete">
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</x-layout>
