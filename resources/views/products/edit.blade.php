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

    <form action="{{ route('products.update', $product->id) }}" method="post" id="productForm">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $product->name }}">

        <div style="display:flex;align-items:center;gap:8px;">
            <button type="button" id="decrease">-</button>
            <input type="number" id="quantity" name="quantity" value="{{ $product->quantity }}" min="0">
            <button type="button" id="increase">+</button>
        </div>

        <textarea name="description">{{ $product->description }}</textarea>
        <input type="submit" value="Submit">
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updateQuantity(newQuantity) {
            $.ajax({
                url: '/products/{{ $product->id }}/update-quantity',
                type: 'POST',
                data: {
                    quantity: newQuantity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Quantity updated:', response.quantity);
                },
                error: function(xhr) {
                    alert('Error updating quantity');
                }
            });
        }

        $('#increase').on('click', function() {
            let current = parseInt($('#quantity').val());
            let newQuantity = current + 1;
            $('#quantity').val(newQuantity);
            updateQuantity(newQuantity);
        });

        $('#decrease').on('click', function() {
            let current = parseInt($('#quantity').val());
            if (current > 0) {
                let newQuantity = current - 1;
                $('#quantity').val(newQuantity);
                updateQuantity(newQuantity);
            }
        });

        
        $('#quantity').on('change', function() {
            updateQuantity($(this).val());
        });
    </script>
</x-layout>
