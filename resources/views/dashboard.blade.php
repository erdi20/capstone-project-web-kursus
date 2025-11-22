<x-app-layout>
<div class="max-w-6xl mx-auto px-4">
      <section class="hero-bg rounded-lg mt-8 p-6 md:p-12 flex flex-col md:flex-row items-center gap-8">
        <div class="md:w-1/2">
          <h1 class="text-3xl md:text-4xl font-extrabold leading-tight mb-4">
            Tempat Terbaik untuk Mulai Perjalanan Belajarmu
          </h1>
          <p class="text-gray-600 mb-6">
            Saatnya bijak memilih sumber belajar, tak hanya materi yang terjamin.
          </p>
          <div class="flex gap-3">
            <a href="#" class="inline-block bg-yellow-400 text-black px-4 py-2 rounded font-semibold">Jelajahi Kelas</a>
            <a href="#" class="inline-block border border-gray-300 text-gray-700 px-4 py-2 rounded">Pelajari Lebih Lanjut</a>
          </div>
        </div>

        <div class="md:w-1/2">
          <img src="{{ asset('asset/6ded78e402afe633b1ad32e1d18e4c62.jpg') }}" alt="Ilustrasi belajar" class="w-full rounded-lg shadow-sm hero-image">
        </div>
      </section>

      <!-- deskripsi singkaadsadasat (dibatasi kanan-kiri agar sejajar dengan hero text) -->
      <section class="mt-6">
        <div class="mx-auto px-4 max-w-xl text-center">
          <h2 class="text-2xl font-bold mb-2">KENAPA KAMI BISA DIANDALKAN</h2>
          <p class="text-gray-600 mb-2 text-sm leading-relaxed">
            Saatnya bijak memilih sumber belajar, tak hanya materi yang terjamin.
          </p>
          <p class="text-gray-600 mb-2 text-sm leading-relaxed">
            meningkatkan pengalaman belajar sebagaimana pendidikan formal.
          </p>
        </div>`
      </section>

      <!-- Banner statis menggantikan slideshow -->
      <section class="py-10">
        <div class="mx-auto max-w-4xl">
          <img src="{{ asset('asset/wp5522970.jpg') }}" alt="Banner statis" class="w-full rounded-lg shadow-lg object-cover h-64 md:h-96">
        </div>
      </section>

      <!-- CTA Daftar -->
      <section class="mt-12 mb-12 bg-yellow-400 rounded-lg p-8 text-center">
        <h3 class="text-2xl font-bold mb-2">Ayo Daftar Sekarang, tunggu Apa lagi?</h3>
        <p class="text-gray-800 mb-4">Dapatkan akses ke materi, sertifikat, dan komunitas pembelajar.</p>
        <a href="#" class="inline-block bg-black text-white px-6 py-3 rounded font-semibold">Daftar</a>
      </section>
    </div>
</x-app-layout>
