<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="mb-5 text-2xl font-bold">Create New Product</h2>

                    <x-auth-session-status class="mb-4" :status="session('success')" />

                    <form action="{{ route('product-store')}}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label for="product_name" class="block text-sm">Product Name</label>
                            <input type="text" id="product_name" name="product_name" class="w-full p-2 border rounded" required>
                        </div>

                        <div>
                            <label for="unit" class="block text-sm">Unit</label>
                            <select id="unit" name="unit" class="w-full p-2 border rounded" required>
                                <option value="" disabled selected>Select a unit</option>
                                <option value="kg">Kilogram</option>
                                <option value="ltr">Liter</option>
                                <option value="pcs">Pieces</option>
                                <option value="box">Box</option>
                            </select>
                        </div>

                        <div>
                            <label for="type" class="block text-sm">Type</label>
                            <input type="text" id="type" name="type" class="w-full p-2 border rounded" required>
                        </div>

                        <div>
                            <label for="information" class="block text-sm">Information</label>
                            <textarea id="information" name="information" rows="3" class="w-full p-2 border rounded"></textarea>
                        </div>

                        <div>
                            <label for="qty" class="block text-sm">Quantity</label>
                            <input type="number" id="qty" name="qty" class="w-full p-2 border rounded" required>
                        </div>

                        <div>
                            <label for="producer" class="block text-sm">Producer</label>
                            <input type="text" id="producer" name="producer" class="w-full p-2 border rounded" required>
                        </div>

                        <button type="submit" class="px-4 py-2 text-black bg-indigo-600 rounded">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
