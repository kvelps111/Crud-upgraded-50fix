<x-layout>
    <x-slot:title>
        Edit product
    </x-slot>

    {{-- Error messages --}}
    @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Regular form for name/description --}}
    <form action="{{ route('products.update', $product->id) }}" method="post" id="product-form">
        @csrf
        @method('PUT')

        <label>Name:</label>
        <input type="text" name="name" value="{{ $product->name }}">

        <label>Quantity:</label>
        <input type="number" name="quantity" value="{{ $product->quantity }}" readonly>

        {{-- AJAX buttons for quantity --}}
        <button type="button" class="qtyplus" onclick="plusqty()">+</button>
        <button type="button" class="qtyminus" onclick="minusqty()">-</button>

        <label>Description:</label>
        <textarea name="description">{{ $product->description }}</textarea>

        <input type="submit" value="Submit">
    </form>

    {{-- AJAX Script --}}
    <script>
        function updateQuantity(productId, newQuantity) {
            fetch(`/products/${productId}/quantity`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity: newQuantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector('input[name="quantity"]').value = data.quantity;
                } else {
                    alert("Failed to update quantity");
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function plusqty() {
            let input = document.querySelector('input[name="quantity"]');
            let current = parseInt(input.value);
            updateQuantity({{ $product->id }}, current + 1);
        }

        function minusqty() {
            let input = document.querySelector('input[name="quantity"]');
            let current = parseInt(input.value);
            if (current > 0) {
                updateQuantity({{ $product->id }}, current - 1);
            }
        }
    </script>
</x-layout>
