
<!-- content -->

<div class="lg:flex lg:items-center lg:justify-between">
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
        Pengajuan Mendatang
        </h2>
        <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">

            <form class="my-2 flex sm:flex-row flex-col">
                <select id="currency" name="tahun" class="focus:ring-indigo-500 focus:border-indigo-500 h-full py-0 pl-2 pr-7 bg-white text-gray-500 sm:text-sm border-gray-300 border rounded-l-md">
                    <?php
                        $tahun      = isset($_GET['tahun'])?$_GET['tahun']:date("Y");
                        for($x = 2020; $x<=date("Y")+4; $x++){
                            ?>
                            <option <?=$tahun==$x?"selected":""?> value="<?=$x?>"><?=$x?></option>
                            <?php
                        }
                    ?>
                </select>
                <select id="currency" name="field" class="focus:ring-indigo-500 focus:border-indigo-500 h-full py-0 pl-2 pr-7 bg-white text-gray-500 sm:text-sm border-gray-300 border">
                    <option <?=@$_GET["field"]=="nama"?"selected":""?> value="nama">Nama</option>
                    <option <?=@$_GET["field"]=="nip"?"selected":""?> value="nip">NIP</option>
                </select>
                <input type="text" name="keyword" value="<?=@$_GET["keyword"]?>" placeholder="Search" id="company_website" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none sm:text-sm border-gray-300 border px-4 py-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 border rounded-r-md border-gray-300   shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search -ml-1 mr-2 h-5 w-5 text-gray-500"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    Cari
                </button>
                
                
            </form>    
        </div>
    </div>
</div>

<div class="w-full">
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
