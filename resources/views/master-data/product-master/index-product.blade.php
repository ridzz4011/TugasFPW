<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="container p-4 mx-auto">
    <div class="overflow-x-auto">
      <a href="{{ route('product-create') }}">
        <button class="px-6 py-4 text-white bg-green-500 border border-green-500 rounded-lg shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
          Add product data
        </button>
      </a>

      <table class="min-w-full border border-collapse border-gray-200 mt-4">
        <thead>
          <tr class="bg-gray-100">
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">ID</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Product Name</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Unit</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Type</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Information</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Qty</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Producer</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($data as $item)
            <tr class="bg-white">
              <td class="px-4 py-2 border border-gray-200">{{ $item->id }}</td>
              <td class="px-4 py-2 border border-gray-200">{{ $item->product_name }}</td>
              <td class="px-4 py-2 border border-gray-200">{{ $item->unit }}</td>
              <td class="px-4 py-2 border border-gray-200">{{ $item->type }}</td>
              <td class="px-4 py-2 border border-gray-200">{{ $item->information }}</td>
              <td class="px-4 py-2 border border-gray-200">{{ $item->qty }}</td>
              <td class="px-4 py-2 border border-gray-200">{{ $item->producer }}</td>
              <td class="px-4 py-2 border border-gray-200">
                <a href="{{ route('product-edit', $item->id) }}" class="px-2 text-blue-600 hover:text-blue-800">Edit</a>

                <!-- Delete: gunakan confirmDelete dan kirimkan URL delete -->
                <button
                  class="px-2 text-red-600 hover:text-red-800"
                  onclick="confirmDelete({{ $item->id }}, '{{ route('product-delete', $item->id) }}')"
                >
                  Hapus
                </button>
              </td>
            </tr>
          @empty
            <tr>
              <td class="px-4 py-6 text-center border border-gray-200" colspan="8">Tidak ada data produk.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <script>
    function confirmDelete(id, deleteUrl) {
      if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        // Membuat form dinamis untuk mengirim request DELETE dengan CSRF token
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = deleteUrl;

        // CSRF token
        let csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        // Method spoofing untuk DELETE
        let methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
      }
    }
  </script>
</x-app-layout>
