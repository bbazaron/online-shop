
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4">Создать новый продукт</h2>

        <form method="POST" action="{{ route('post.createProductForm') }}">
            @csrf

            {{-- Название --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Название</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-200">
                @error('name')
                <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            {{-- Цена --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Цена</label>
                <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                       class="w-full border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-200">
                @error('price')
                <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            {{-- Описание --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Описание</label>
                <textarea name="description" rows="4"
                          class="w-full border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-200">{{ old('description') }}</textarea>
                @error('description')
                <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            {{-- Картинка --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">URL изображения</label>
                <input type="url" name="image" value="{{ old('image') }}"
                       class="w-full border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-200"
                       placeholder="https://example.com/image.jpg">
                @error('image_url')
                <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            {{-- Кнопки --}}
            <div class="flex justify-between">
                <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                    💾 Создать продукт
                </button>
            </div>
        </form>
    </div>
