<section class="w-full min-h-screen bg-[#0a3c78] pt-34 pb-24">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-12">
      <div
        class="text-white flex flex-col justify-center space-y-2 lg:pt-24"
      >
        <h1 class="text-4xl md:text-6xl font-extrabold leading-tight">
          UMKM SASUMA.
        </h1>
        <p class="text-lg md:text-xl opacity-90 leading-relaxed">
          Temukan berbagai jenis usaha lokal, dari kuliner, kerajinan, sampai
          layanan jasa. Gunakan peta interaktif untuk mencari lokasi UMKM
          terdekat dan dukung perekonomian di sekitar kita.
        </p>
      </div>

      <div
        class="flex justify-center md:justify-end order-2 md:order-none lg:justify-end order-2 lg:order-none lg:row-span-2"
      >
        <img
          src="https://wia-mamung-nine.vercel.app/assets/logoumkm-B9AUVb8-.jpeg"
          class="rounded-lg shadow-2xl w-full max-w-md h-[188px] sm:h-80 md:h-[550px] object-cover"
        />
      </div>

      <div class="order-3 lg:order-none max-w-7xl md:col-span-2 lg:col-span-1">
        <div
          class="bg-white rounded-2xl p-6 shadow-xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6"
          x-data="{
            currentIndex: 0,
            items: [
              {
                id: 1,
                title: 'Tebing UMKM',
                category: 'Fashion',
                description: 'Pecel lele, daun singkong, dan lontong sayur',
                sales: 'Rp. 10.000.000',
                image: 'https://images.unsplash.com/photo-1523381294911-8d3cead13475?auto=format&fit=crop&w=800&q=60'
              },
              {
                id: 2,
                title: 'Warung Seblak',
                category: 'Kuliner',
                description: 'Seblak ceker, bakso, sosis, dan original pedas',
                sales: 'Rp. 5.000.000',
                image: 'https://images.unsplash.com/photo-1523381294911-8d3cead13475?auto=format&fit=crop&w=800&q=60'
              },
              {
                id: 3,
                title: 'Java Craft',
                category: 'Kerajinan',
                description: 'Tas anyam premium dan dompet kulit asli',
                sales: 'Rp. 8.000.000',
                image: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=800&q=60'
              }
            ]
          }"
        >
          <div class="flex-1 space-y-1">
            <p class="text-sm font-medium text-gray-600">
              UMKM SASUMA - PENGASINAN
            </p>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
              <span x-text="items[currentIndex].title"></span>
              <span
                class="text-xs bg-yellow-400 px-2 py-1 rounded-md"
                x-text="items[currentIndex].category"
              ></span>
            </h2>
            <p
              class="text-gray-600 text-sm"
              x-text="items[currentIndex].description"
            ></p>
            <p
              class="text-gray-800 font-semibold"
              x-text="'Omset Penjualan - ' + items[currentIndex].sales"
            ></p>
            <a
              href="#"
              class="hidden sm:block text-center text-blue-600 font-medium hover:underline text-sm pt-1 block"
            >
              Lihat Lokasi →
            </a>
          </div>

         <div class="flex-shrink-0 relative w-full sm:w-48 md:w-72 lg:w-48 h-32 md:w-48 lg:h-32">
            <img
              x-bind:src="items[currentIndex].image"
              class="w-full h-full object-cover rounded-lg shadow-md"
              alt="Gambar Produk UMKM"
            />

            <button
              x-on:click="currentIndex = (currentIndex - 1 + items.length) % items.length"
              class="absolute top-1/2 cursor-pointer -translate-y-1/2 -left-4 sm:left-0 sm:-translate-x-4 bg-blue-600 text-white p-2 rounded-full opacity-85 hover:opacity-100 transition-all"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M15 19l-7-7 7-7"
                />
              </svg>
            </button>

            <button
              x-on:click="currentIndex = (currentIndex + 1) % items.length"
              class="absolute top-1/2 cursor-pointer -translate-y-1/2 -right-4 sm:right-0 sm:translate-x-4 bg-blue-600 text-white p-2 rounded-full opacity-85 hover:opacity-100 transition-all"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M9 5l7 7-7 7"
                />
              </svg>
            </button>
          </div>
          <div class="w-full block sm:hidden -mt-2">
    <a
      href="#"
      class="text-blue-600 font-medium hover:underline text-sm block text-center"
    >
      Lihat Lokasi →
    </a>
  </div>
        </div>
      </div>
    </div>
  </div>
</section>