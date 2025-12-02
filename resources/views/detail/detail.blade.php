<x-app-layout>

    <div class="max-w-[450px] mx-auto px-4 py-6">

        {{-- Judul Tengah --}}
        <h1 class="text-center font-bold text-2xl mb-6">Naratif Teknis</h1>

        {{-- Subjudul --}}
        <h2 class="text-left text-xl font-bold mb-2">Naratif Teknis</h2>

        {{-- Paragraf 1 --}}
        <p class="text-sm text-gray-700 leading-relaxed mb-6">
            Naratif teknis adalah suatu penulisan berbentuk narasi (cerita) yang digunakan untuk
            menjelaskan proses, prosedur, atau teknologi secara sistematis.
        </p>

        {{-- Video 1 --}}
        <div class="w-full max-w-[350px] h-[180px] bg-gray-300 mx-auto rounded-md mb-2"></div>
        <p class="text-center text-xs text-gray-600 mb-6">Video pengenalan youtube</p>

        {{-- Paragraf 2 --}}
        <p class="text-sm text-gray-700 leading-relaxed mb-6">
            Naratif teknis adalah teks atau penulisan berbentuk narasi (cerita) yang digunakan
            untuk menjelaskan proses, prosedur, atau teknologi secara sistematis. Naratif teknis
            membantu pembaca memahami langkah kerja secara runtut. Naratif teknis adalah teks atau penulisan berbentuk narasi (cerita) yang digunakan
            untuk menjelaskan proses, prosedur, atau teknologi secara sistematis. Naratif teknis
            membantu pembaca memahami langkah kerja secara runtut.
        </p>

        {{-- Video 2 --}}
        <div class="w-full max-w-[350px] h-[180px] bg-gray-300 mx-auto rounded-md mb-2"></div>
        <p class="text-center text-xs text-gray-600 mb-6">Video pengenalan youtube 2</p>

        {{-- Paragraf 3 --}}
        <p class="text-sm text-gray-700 leading-relaxed mb-6">
            Naratif teknis juga digunakan dalam pendidikan dan industri untuk menjelaskan alur
            kerja secara terstruktur dan jelas. Naratif teknis juga digunakan dalam pendidikan dan industri untuk menjelaskan alur
            kerja secara terstruktur dan jelas. Naratif teknis juga digunakan dalam pendidikan dan industri untuk menjelaskan alur
            kerja secara terstruktur dan jelas. 
        </p>

        {{-- Garis kiri-kanan --}}
        <div class="flex justify-between mb-8">
            <div class="w-[40%] border-b border-gray-400"></div>
            <div class="w-[40%] border-b border-gray-400"></div>
        </div>

        {{-- Tombol Quiz --}}
        <button class="w-full bg-gray-300 text-gray-900 font-semibold py-3 mb-4 rounded-md">
            quiz
        </button>

        {{-- Tombol Esai --}}
        <button class="w-full bg-gray-300 text-gray-900 font-semibold py-3 mb-10 rounded-md">
            esai
        </button>

    </div>

    {{-- Navigasi bawah --}}
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-300 
                px-6 py-4 flex justify-between items-center">

        <button class="bg-[#00c896] text-white font-semibold px-8 py-2 rounded-full shadow-md">
            Back
        </button>

        <button class="bg-[#00c896] text-white font-semibold px-8 py-2 rounded-full shadow-md">
            Next
        </button>

    </div>

</x-app-layout>
