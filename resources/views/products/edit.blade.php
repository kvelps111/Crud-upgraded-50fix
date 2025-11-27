<x-layout>
    <x-slot:title>
        Edit product
        </x-slot>

        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="post">
            @csrf
            @method('PUT')

            <input type="text" name="name" value="{{ $product->name }}">
            <input type="number" name="quantity" value="{{ $product->quantity }}">
            <textarea name="description">{{ $product->description }}</textarea>
            <div id="tags-container">
                @foreach($product->tags as $tag)
                    <input type="hidden" name="tags[]" value="{{ $tag->name }}">
                @endforeach
            </div>

            {{-- Visual tags display --}}
            <div class="tags-visual-container" id="tags-visual-container">
                @foreach($product->tags as $tag)
                    <span class="tag" style="background-color: {{ $tag->color }}; color: white;">
                        {{ $tag->name }}
                        <button type="button" class="tag-remove-btn" data-tag-name="{{ $tag->name }}">×</button>
                    </span>
                @endforeach
            </div>
            <input type="submit" value="Submit">
        </form>
</x-layout>