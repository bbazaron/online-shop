<div class="container">
    <a href="{{route('catalog')}}" class="btn btn-catalog">
        <i class="fas fa-list"></i> Каталог
    </a>

    <a href="{{route('profile')}}" class="btn btn-profile">
        <i class="fas fa-user"></i> Профиль
    </a>

    <a href="{{route('orders')}}" class="btn btn-orders">
        <i class="fas fa-clipboard-list"></i> Мои заказы
    </a>

    <a href="{{route('cart')}}" class="btn btn-cart">
        <i class="fas fa-shopping-cart"></i> Корзина
        {{--        <span class="cart-quantity"><?php echo $cartQuantity;?></span>--}}
        {{--        <span class="cart-total"><?php echo $sum;?> ₽</span>--}}
    </a>


    <div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6">Список продуктов</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border border-gray-200">
            <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4 border-b text-left">ID</th>
                <th class="py-2 px-4 border-b text-left">Название</th>
                <th class="py-2 px-4 border-b text-left">Цена</th>
                <th class="py-2 px-4 border-b text-left">Описание</th>
                <th class="py-2 px-4 border-b text-left">Картинка</th>
                <th class="py-2 px-4 border-b text-center">Действия</th>
            </tr>
            </thead>
            <tbody>@forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $product->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $product->name }}</td>
                    <td class="py-2 px-4 border-b">{{ number_format($product->price, 2, ',', ' ') }} ₽</td>
                    <td class="py-2 px-4 border-b">{{ Str::limit($product->description, 50) }}</td>
                    <td class="py-2 px-4 border-b">
                        @if($product->image)
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="h-16 w-16 object-cover rounded-md border mx-auto">
                        @else
                            <span class="text-gray-400 text-sm italic">Нет изображения</span>
                        @endif
                    </td>

                    {{-- Редактировать --}}
                    <td class="py-2 px-4 border-b text-center">
                        <a href="{{ route('editProductForm', $product->id) }}"
                           class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">
                            ✏️ Редактировать
                        </a>
                    </td>

                    {{-- Удалить --}}
                    <td class="py-2 px-4 border-b text-center">
                        <form action="{{ route('deleteProduct', $product->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                                ✖️ Удалить
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">Нет продуктов</td>
                </tr>
            @endforelse

            </tbody>
        </table>
    </div>
    <br><br>
    <a href="{{route('createProductForm')}}" class="btn btn-cart">
        <i class="fas fa-shopping-cart"></i> Добавить новый продукт
    </a>

    <style>
        :root {
            --primary-color: #4a6bff;
            --secondary-color: #ff6b6b;
            --dark-color: #2c3e50;
            --light-color: #f8f9fa;
        }

        body {
            font-style: sans-serif;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }

        a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: none;
        }

        h3 {
            line-height: 3em;
        }

        .card {
            max-width: 16rem;
        }

        .card:hover {
            box-shadow: 1px 2px 10px lightgray;
            transition: 0.2s;
        }

        .card-header {
            font-size: 13px;
            color: gray;
            background-color: white;
        }

        .text-muted {
            font-size: 11px;
        }

        .card-footer{
            font-weight: bold;
            font-size: 18px;
            background-color: white;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 15px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border: none;
            outline: none;
        }

        .btn-catalog {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-catalog:hover {
            background-color: #3a5bef;
        }

        .btn-profile {
            background-color: var(--dark-color);
            color: white;
        }

        .btn-profile:hover {
            background-color: #1a2b3c;
        }

        .btn-orders {
            background-color: #6c5ce7;
            color: white;
        }

        .btn-orders:hover {
            background-color: #5d4aec;
        }

        .btn-cart {
            position: relative;
            background-color: var(--secondary-color);
            color: white;
            padding-right: 50px;
        }

        .btn-cart:hover {
            background-color: #ff5252;
        }

        .cart-quantity {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background-color: white;
            color: var(--secondary-color);
            border-radius: 10px;
            padding: 2px 8px;
            font-size: 15px;
            font-weight: bold;
            min-width: 20px;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .cart-total {
            margin-left: 5px;
            font-size: 12px;
            opacity: 0.9;
        }</style>
