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
    </a>

    <a>

        <form id="searchForm"
              action="{{ route('catalog.search') }}"
              method="GET"
              class="d-flex mb-4"
              style="gap: 10px; position: relative;"
              data-search-url="{{ route('catalog.search') }}">
            <input
                type="text"
                id="searchInput"
                name="q"
                value="{{ request('q') }}"
                class="form-control"
                placeholder="Введите название товара..."
                style="max-width: 400px;"
                autocomplete="off"
            >
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Найти
            </button>

            <ul id="suggestions" class="list-group position-absolute w-100"
                style="top: 100%; z-index: 1000; display: none;"></ul>
        </form>

    <h3>Каталог</h3>

    @if(isset($products) && count($products))
        @foreach($products as $product)
            <div class="card-deck mb-4">
                <div class="card text-center">
                    <a>
                        <hr>
                        <img class="card-img-top" src="{{ $product['image'] }}" alt="Card image" width="300" height="200">

                        <div class="card-body">
                            <p class="card-footer">{{ $product['name'] }}</p>
                            <a><h5 class="card-title">Описание: {{ $product['description'] }}</h5></a>
                            <div class="card-title">
                                Цена: {{ $product['price'] }}
                            </div>
                            <br>
                            <form action="{{route('productPage', ['id' => $product['id']])}}">
                                @csrf
                                <div class="container">
                                    <button type="submit" class="register btn">Открыть</button>
                                </div>
                            </form>
                        </div>
                    </a>
                </div>

                <div class="card-title" style="display: flex; gap: 10px;">Добавить в корзину
                    <div style="display: flex; gap: 20px;">

                        <form class='increase-button' onsubmit="return false">
                            @csrf
                            <div class="container">
                                <input type="hidden" value="{{ $product['id'] }}" name="product_id">
                                <button type="submit" class="register btn"> + </button>
                            </div>
                        </form>

                        <form class='decrease-button' onsubmit="return false">
                            @csrf
                            <div class="container">
                                <input type="hidden" value="{{ $product['id'] }}" name="product_id">
                                <button type="submit" class="register btn"> - </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p class="text-muted mt-4">Ничего не найдено.</p>
    @endif
</div>



<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous">
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('searchInput');
        const suggestions = document.getElementById('suggestions');
        const form = document.getElementById('searchForm');
        const url = form.dataset.searchUrl;

        function debounce(fn, delay) {
            let t;
            return function(...args) {
                clearTimeout(t);
                t = setTimeout(() => fn.apply(this, args), delay);
            };
        }

        let controller = null;

        async function fetchSuggestions(query) {
            if (!query.trim()) {
                suggestions.style.display = 'none';
                suggestions.innerHTML = '';
                return;
            }

            if (controller) controller.abort();
            controller = new AbortController();

            try {
                const res = await fetch(`${url}?q=${encodeURIComponent(query)}`, {
                    headers: {'X-Requested-With': 'XMLHttpRequest'},
                    signal: controller.signal
                });

                if (!res.ok) throw new Error('Network response not ok');

                const data = await res.json();

                if (!Array.isArray(data) || !data.length) {
                    suggestions.style.display = 'none';
                    suggestions.innerHTML = '';
                    return;
                }

                suggestions.innerHTML = '';
                data.forEach(product => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item list-group-item-action';
                    li.style.cursor = 'pointer';

                    const regex = new RegExp(`(${query})`, 'i');
                    li.innerHTML = (product.name || 'Без названия').replace(regex, '<strong>$1</strong>');

                    li.addEventListener('click', function() {
                        input.value = product.name;
                        suggestions.innerHTML = '';
                        suggestions.style.display = 'none';
                        form.submit();
                    });

                    suggestions.appendChild(li)
                });
                suggestions.style.display = 'block';
            } catch (err) {
                if (err.name !== 'AbortError') console.error(err);
                suggestions.style.display = 'none';
                suggestions.innerHTML = '';
            }
        }

        const debouncedFetch = debounce(e => fetchSuggestions(e.target.value), 200);
        input.addEventListener('input', debouncedFetch);

        document.addEventListener('click', e => {
            if (!form.contains(e.target)) {
                suggestions.style.display = 'none';
            }
        });
    });



</script>


<script>
    $("document").ready(function () {
        var form =  $('.increase-button');
        console.log(form);

        form.submit(function () {
            $.ajax({
                type: "POST",
                url: "{{route('addProductToCart')}}",
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    $('.cart-quantity').text(response.cartQuantity);
                    // $('.cart-total').text(response.sum + ' ₽');
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error('Ошибка при добавлении товара:', error);
                }
            });
        });
    });
</script>

<script>
    $("document").ready(function () {
        var form =  $('.decrease-button');
        console.log(form);

        form.submit(function () {
            $.ajax({
                type: "POST",
                url: "{{route('decreaseProductFromCart')}}",
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    $('.cart-quantity').text(response.cartQuantity);
                    // $('.cart-total').text(response.sum + ' ₽');
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error('Ошибка при добавлении товара:', error);
                }
            });
        });
    });
</script>

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
    }

    #suggestions {
        max-height: 250px;       /* ограничение по высоте */
        overflow-y: auto;        /* скролл при большом количестве */
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        margin-top: 5px;
        padding: 0;
    }

    #suggestions li {
        padding: 10px 15px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    #suggestions li:hover {
        background-color: #f0f0f0;
    }


</style>
