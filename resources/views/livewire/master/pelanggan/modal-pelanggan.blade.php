<div>
    <div data-tw-merge class="items-center block mt-3 sm:flex">
        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-32">
            Supervisor
        </label>
        <select data-tw-merge aria-label="Default select example" required name="supervisor" wire:model.live='spv'
            class="disabled:bg-slate-100 disabled:cursor-not-allowed disabled:dark:bg-darkmode-800/50 [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md py-2 px-3 pr-8 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 mt-2 sm:mr-2 mt-2 sm:mr-2">
            <option value="">Pilih</option>
            @foreach ($pegawais->where('jabatan', 'Supervisor') as $pegawai)
                <option value="{{ $pegawai->id }}"
                    {{ $pelanggan ? ($pelanggan->supervisor == $pegawai->id ? 'selected' : '') : '' }}>
                    {{ $pegawai->nama_pegawai }} - {{ $pegawai->jabatan }}</option>
            @endforeach
        </select>
    </div>
    <div data-tw-merge class="items-center block mt-3 sm:flex">
        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-32">
            Sales
        </label>
        <select data-tw-merge aria-label="Default select example" required name="sales"
            class="disabled:bg-slate-100 disabled:cursor-not-allowed disabled:dark:bg-darkmode-800/50 [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md py-2 px-3 pr-8 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 mt-2 sm:mr-2 mt-2 sm:mr-2">
            @if ($pelanggan)
                @foreach ($pegawais as $pegawai)
                    <option value="{{ $pegawai->id }}"
                        {{ $pelanggan ? ($pelanggan->sales == $pegawai->id ? 'selected' : '') : '' }}>
                        {{ $pegawai->nama_pegawai }} - {{ $pegawai->jabatan }}</option>
                @endforeach
            @else
                @forelse ($dataSales as $pegawai)
                    <option value="{{ $pegawai->sales }}"
                        {{ $pelanggan ? ($pelanggan->sales == $pegawai->sales ? 'selected' : '') : '' }}>
                        {{ $pegawai->pegawai_sales->nama_pegawai }} - {{ $pegawai->pegawai_sales->jabatan }}</option>
                @empty
                    <option value="">Pilih Supervisor Terlebih Dahulu</option>
                @endforelse
            @endif
        </select>
    </div>

    <div data-tw-merge class="items-center block mt-3 sm:flex">
        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-32">
            Kolektor
        </label>
        <select data-tw-merge aria-label="Default select example" required name="kolektor"
            class="disabled:bg-slate-100 disabled:cursor-not-allowed disabled:dark:bg-darkmode-800/50 [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md py-2 px-3 pr-8 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 mt-2 sm:mr-2 mt-2 sm:mr-2">
            @foreach ($pegawais->where('kolektor', 'on') as $pegawai)
                <option value="{{ $pegawai->id }}"
                    {{ $pelanggan ? ($pelanggan->kolektor == $pegawai->id ? 'selected' : '') : '' }}>
                    {{ $pegawai->nama_pegawai }} - {{ $pegawai->jabatan }}</option>
            @endforeach
        </select>
    </div>
    <div data-tw-merge class="items-center block mt-3 sm:flex">
        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-32">
            Area Rayon
        </label>
        <select data-tw-merge aria-label="Default select example" required name="area_rayon"
            class="disabled:bg-slate-100 disabled:cursor-not-allowed disabled:dark:bg-darkmode-800/50 [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md py-2 px-3 pr-8 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 mt-2 sm:mr-2 mt-2 sm:mr-2">
            @foreach ($rayons as $rayon)
                <option value="{{ $rayon->id }}"
                    {{ $pelanggan ? ($pelanggan->area_rayon == $rayon->id ? 'selected' : '') : '' }}>
                    {{ $rayon->area_rayon }}</option>
            @endforeach
        </select>
    </div>
    <div data-tw-merge class="items-center block mt-3 sm:flex">
        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-32">
            Sub Rayon
        </label>
        <select data-tw-merge aria-label="Default select example" required name="sub_rayon"
            class="disabled:bg-slate-100 disabled:cursor-not-allowed disabled:dark:bg-darkmode-800/50 [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md py-2 px-3 pr-8 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 mt-2 sm:mr-2 mt-2 sm:mr-2">
            @foreach ($sub_rayons as $rayon)
                <option value="{{ $rayon->id }}"
                    {{ $pelanggan ? ($pelanggan->sub_rayon == $rayon->id ? 'selected' : '') : '' }}>
                    {{ $rayon->sub_rayon }}</option>
            @endforeach
        </select>
    </div>
</div>
