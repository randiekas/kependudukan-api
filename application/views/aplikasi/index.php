
<!-- content -->

<div class="lg:flex lg:items-center lg:justify-between">
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
        Dashboard
        </h2>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
            Daftar pegawai pengujian bulan <?=date("M")?>
        </p>
    </div>
</div>

<div class="w-full">
    <div class="grid grid-cols-8 gap-3">
        <div class="col-span-2 shadow sm:rounded-md sm:overflow-hidden bg-white px-4 py-5 mt-6">
            <span class="text-sm text-gray-500 font-medium">Total Pegawai</span>
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                <?=$total_pegawai?>
            </h2>
        </div>
        <div class="col-span-2 shadow sm:rounded-md sm:overflow-hidden bg-white px-4 py-5 mt-6">
            <span class="text-sm text-gray-500 font-medium">Periode April</span>
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                <?=$total_pengujian_bulan_kemarin?>
            </h2>
        </div>
        <div class="col-span-2 shadow sm:rounded-md sm:overflow-hidden bg-white px-4 py-5 mt-6">
            <span class="text-sm text-gray-500 font-medium">Periode Oktober</span>
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
            <?=$total_pengujian_bulan_sekarang?>
            </h2>
        </div>
        <div class="col-span-2 shadow sm:rounded-md sm:overflow-hidden bg-white px-4 py-5 mt-6">
            <span class="text-sm text-gray-500 font-medium">Periode Berkala</span>
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                <?=$total_pengujian_bulan_selanjutnya?>
            </h2>
        </div>
    </div>
    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-max w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Nama</th>
                    <th class="py-3 px-6 text-left">NIP</th>
                    <th class="py-3 px-6 text-center">TMT Pangkat</th>
                    <th class="py-3 px-6 text-center">TMT Berkala</th>
                    <th class="py-3 px-6 text-center">Instansi</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <?php
                foreach($list_pegawai as $row){
                ?>
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap text-sm font-medium text-gray-900">
                        <?=$row->nama?>
                    </td>
                    <td class="py-3 px-6 text-left">
                        <?=$row->nip?>
                    </td>
                    <td class="py-3 px-6 text-left">
                        <?=$row->tanggal_pengujian?>
                    </td>
                    <td class="py-3 px-6 text-left">
                        <?=$row->tanggal_pengujian_berkala?>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <span class="bg-purple-200 text-purple-600 py-1 px-3 rounded-full text-xs">
                            <?=$row->institusi?>
                        </span>
                    </td>
                    
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center">
                            
                            <a href="<?=base_url("index.php/aplikasi/form/".$row->id)?>" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                            <a href="<?=base_url("index.php/aplikasi/hapus/".$row->id)?>" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
