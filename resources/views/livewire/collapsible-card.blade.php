<div class="space-y-2">
  <p class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Data History</p>
  <ul class="space-y-2 w-full">
    @foreach (array_reverse($getState()) as $item)
    <div class="bg-white ring-1 rounded-lg ring-gray-200" x-data="{ expanded: false }">
      <div class="p-4 flex border-b-2 border-black cursor-pointer">
        <div class="flex-1">
          <p class="text-base font-medium">{{ $item['title'] }}</p>
          <p class="text-sm font-light">Tanggal Modifikasi: {{ $item['modify_at'] }}</p>
        </div>
        <button class="" @click="expanded = ! expanded">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
      </div>
      <div class="border-t border-gray-200 p-4 space-y-4" x-show="expanded" x-collapse>
        <div class="flex w-full">
          <div class="flex-1">
            <p class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Tanggal Modifikasi</p>
            <p class="inline-flex items-center gap-1.5 text-sm leading-6 text-gray-950 dark:text-white capitalize">{{
              $item['modify_at'] }}</p>
          </div>
          <div class="flex-1">
            <p class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Dimodifikasi Oleh</p>
            <p class="inline-flex items-center gap-1.5 text-sm leading-6 text-gray-950 dark:text-white capitalize">{{
              $item['stakeholder_id'] }}</p>
          </div>
        </div>
        <div class="flex w-full">
          <div class="flex-1">
            <p class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Kategori</p>
            <p class="inline-flex items-center gap-1.5 text-sm leading-6 text-gray-950 dark:text-white capitalize">
              {{ $item['article_category'] }}</p>
          </div>
          <div class="flex-1">
            <p class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Tags</p>
            <div class="grid gap-y-2">
              <dd class="">
                <div class="fi-in-affixes flex fi-in-text">

                  <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-1">
                      @forelse ($item['tags'] as $data)
                      <div>
                        <div
                          style="--c-50:var(--primary-50);--c-300:var(--primary-300);--c-400:var(--primary-400);--c-600:var(--primary-600);"
                          class="fi-badge flex items-center justify-center gap-x-1 whitespace-nowrap rounded-md  text-xs font-medium ring-1 ring-inset px-2 min-w-[theme(spacing.6)] py-1 bg-custom-50 text-custom-600 ring-custom-600/10 dark:bg-custom-400/10 dark:text-custom-400 dark:ring-custom-400/30">
                          <span>
                            {{ $data }}
                          </span>
                        </div>
                      </div>
                      @empty
                      <p class="text-sm font-medium">Kosong</p>
                      @endforelse
                    </div>
                  </div>
                </div>
              </dd>
            </div>
          </div>
        </div>
        <div class="flex w-full">
          <div class="flex-1">
            <p class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Judul Artikel</p>
            <p class="inline-flex items-center gap-1.5 text-sm leading-6 text-gray-950 dark:text-white capitalize">{{
              $item['title'] }}</p>
          </div>
          <div class="flex-1">
            <p class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Slug Artikel</p>
            <p class="inline-flex items-center gap-1.5 text-sm leading-6 text-gray-950 dark:text-white capitalize">{{
              $item['slug'] }}</p>
          </div>
        </div>
        <div class="flex w-full gap-4">
          <div class="flex-1">
            <p class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Gambar</p>
            <img src="{{ url('storage/',$item['thumbnail']) }}" class="w-full h-auto" alt="">

          </div>
          <div class="flex-1">
            <p class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Keterangan Gambar</p>
            <p class="inline-flex items-center gap-1.5 text-sm leading-6 text-gray-950 dark:text-white capitalize">{{
              $item['thumbnail_alt'] }}</p>
          </div>
        </div>
        <div class="flex w-full">
          <div class="flex-1">
            <p class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Kumpulan Gambar</p>
            <div class="flex gap-4" style="display: flex; overflow-x: auto; flex-direction: row;">
              @forelse ($item['images'] as $data)
              <img src="{{ url('storage/',$data) }}" class="w-auto h-32" alt="{{
                $item['title'] }}">
              @empty
              <p>Kosong</p>
              @endforelse
            </div>

          </div>
        </div>
        <p class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Konten</p>
        <div class="text-sm space-y-2">
          {!!$item['content']!!}
        </div>
      </div>
    </div>
    @endforeach
  </ul>
</div>