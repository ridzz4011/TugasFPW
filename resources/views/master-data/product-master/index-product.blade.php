<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="container p-4 mx-auto">
    <div class="overflow-x-auto">
      @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 text-green-500">
            {{ session('success') }}
        </div>
      @elseif (session('error'))
        <div class="mb-4 rounded-lg bg-red-40 p-4 text-red-500">
            {{ session('error') }}
        </div>
      @endif

      <form method="GET" action="{{ route('product-index') }}" class="mb-4 flex items-center">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Produk..." class="w-1/4 rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
        <button class="ml-2 rounded-lg bg-green-500 px-4 py-2 text-white shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Cari</button>
      </form>

      <a href="{{ route('product-create') }}">
        <button class="px-6 py-4 text-white bg-green-500 border border-green-500 rounded-lg shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
          Add product data
        </button>
      </a>
      <a href="{{ route('product-export-excel') }}">
        <button class="px-6 py-4 text-white bg-green-500 border border-green-500 rounded-lg shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
            Export Excel
        </button>
      </a>

      <a href="{{ route('product-export-pdf') }}">
        <button class="px-6 py-4 text-white bg-green-500 border border-green-500 rounded-lg shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
            Export PDF
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
              <td class="px-4 py-2 border border-gray-200">
                <a href="{{ route('product-details', $item->id) }}">
                    {{ $item->product_name }}
                </a>
              </td>
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
                  onclick="confirmDelete('{{ route('product-delete', $item->id) }}')"
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
      <div class="mt-4">
        {{ $data->appends(['search' => request('search')])->links() }}
      </div>
    </div>
  </div>

  <script>
    function confirmDelete(deleteUrl) {
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
