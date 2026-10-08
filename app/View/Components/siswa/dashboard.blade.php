<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Peserta
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Menampilkan Pesan Sukses -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <!-- KOTAK 1: Form Pendaftaran Lomba -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-l-4 border-blue-500">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Form Pendaftaran Lomba</h3>
                <form action="{{ route('siswa.daftar') }}" method="POST">
                    @csrf
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Mata Lomba yang Ingin Diikuti:</label>
                    <select name="lomba_id" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm w-full mb-4" required>
                        <option value="">-- Silakan Pilih Mata Lomba --</option>
                        @foreach($lombas as $lomba)
                            <option value="{{ $lomba->id }}">{{ $lomba->nama_lomba }} - ({{ $lomba->deskripsi }})</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition duration-300">
                        Daftar Sekarang
                    </button>
                </form>
            </div>

            <!-- KOTAK 2: Tracking Status (Riwayat Pendaftaran) -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Tracking Status Pendaftaran Saya</h3>
                
                @if($riwayat->isEmpty())
                    <p class="text-gray-500 italic">Anda belum mendaftar lomba apapun. Silakan mendaftar melalui form di atas.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($riwayat as $item)
                            <div class="border border-gray-200 p-4 rounded-lg shadow-sm hover:shadow-md transition bg-gray-50">
                                <h4 class="font-bold text-lg text-blue-700 mb-1">{{ $item->lomba->nama_lomba }}</h4>
                                <p class="text-sm text-gray-500 mb-3">Terdaftar pada: {{ $item->created_at->format('d M Y') }}</p>
                                
                                <div class="flex items-center">
                                    <span class="text-sm font-medium mr-2">Status Saat Ini:</span>
                                    <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-bold border border-indigo-200">
                                        {{ $item->status }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

