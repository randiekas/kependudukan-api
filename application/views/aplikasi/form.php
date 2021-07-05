
    <div>
        <h2 class="text-2xl font-semibold leading-tight">Form Pegawai</h2>
    </div>

    <form action="<?=base_url("index.php/aplikasi/simpan")?>" class="max-w-xl mt-4" method="post" enctype="multipart/form-data">
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                <label for="company_website" class="block text-sm font-medium text-gray-700">
                    <b>#Informasi Umum Pegawai</b>
                </label>
                <div class="grid grid-cols-6 gap-3">
                    <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                        <label for="company_website" class="block text-sm font-medium text-gray-700">
                            NIP
                        </label>
                        <input type="text" value="<?=@$detail->nip?>"  name="nip" id="street_address" autocomplete="street-address" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>
                    <div class="col-span-6 sm:col-span-6 lg:col-span-4">
                        <label for="company_website" class="block text-sm font-medium text-gray-700">
                            Nama
                        </label>
                        <input type="text" value="<?=@$detail->nama?>"  name="nama" id="street_address" autocomplete="street-address" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>
                </div>
                <div class="grid grid-cols-6 gap-3">
                    <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                        <label for="company_website" class="block text-sm font-medium text-gray-700">
                            Pangkat
                        </label>
                        <input type="text" value="<?=@$detail->pangkat?>"  name="pangkat" id="street_address" autocomplete="street-address" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                        <label for="company_website" class="block text-sm font-medium text-gray-700">
                            Jabatan
                        </label>
                        <input type="text" value="<?=@$detail->jabatan?>"  name="jabatan" id="street_address" autocomplete="street-address" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                        <label for="company_website" class="block text-sm font-medium text-gray-700">
                            Instansi
                        </label>
                        <select id="country" name="institusi" autocomplete="country" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option <?=@$detail->institusi=="Dinas Kesehatan"?"selected":""?>>Dinas Kesehatan</option>
                            <option <?=@$detail->institusi=="UPT Puskesmas Lafeu"?"selected":""?>>UPT Puskesmas Lafeu</option>
                            <option <?=@$detail->institusi=="UPT Puskesmas Wosu"?"selected":""?>>UPT Puskesmas Wosu</option>
                            <option <?=@$detail->institusi=="UPT Puskesmas Bahomote"?"selected":""?>>UPT Puskesmas Bahomote</option>
                        </select>
                    </div>
                </div>
                <hr/>
                <label for="company_website" class="block text-sm font-medium text-gray-700">
                    <b>#Kenaikan Pangkat</b>
                </label>
                <div class="grid grid-cols-6 gap-3">
                    <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                        <label for="company_website" class="block text-sm font-medium text-gray-700">
                            TMT Kenaikan Pangkat
                        </label>
                        <input type="date" value="<?=@$detail->tanggal_pengujian?>"  name="tanggal_pengujian" id="street_address" autocomplete="street-address" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="col-span-6 sm:col-span-6 lg:col-span-4">
                        <label for="company_website" class="block text-sm font-medium text-gray-700">
                            Jenis Jabatan
                        </label>
                        <select id="country" name="jenis_jabatan" autocomplete="country" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option>Fungsional Umum</option>
                            <option>Fungsional Tertentu</option>
                            <option>Struktural</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label for="company_website" class="block text-sm font-medium text-gray-700">
                        Persyaratan
                    </label>
                    <input value="<?=htmlentities(@$detail->file)?>" type="hidden" name="file_sebelumnya"/>
                    <input value="<?=@$detail->id?>" type="hidden" name="id"/>
                    <input type="file" multiple name="file[]" class="mt-2 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"/>
                </div>
                <?php
                if(@$detail->file && $detail->file!="[]"){
                ?>
                <div>
                    File Sebelumnya
                    <small>
                    <ul>
                        <?php
                        foreach(json_decode($detail->file) as $row){
                        ?>
                        <li><a href="<?=base_url("uploads/".$row)?>" target="_blank"> <?=$row?> [ Buka ]</a></li>
                        <?php
                        }
                        ?>
                    </ul>
                    </small>
                </div>
                <?php
                }
                ?>
                <hr/>
                <label for="company_website" class="block text-sm font-medium text-gray-700">
                    <b>#Kenaikan Gaji Berkala</b>
                </label>
                <div class="grid grid-cols-6 gap-3">
                    <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                        <label for="company_website" class="block text-sm font-medium text-gray-700">
                            TMT Gaji Berkala
                        </label>
                        <input type="date" value="<?=@$detail->tanggal_pengujian_berkala?>"  name="tanggal_pengujian_berkala" id="street_address" autocomplete="street-address" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="col-span-6 sm:col-span-6 lg:col-span-4">
                        <label for="company_website" class="block text-sm font-medium text-gray-700">
                            Persyaratan
                        </label>
                        <input value="<?=htmlentities(@$detail->file_berkala)?>" type="hidden" name="file_berkala_sebelumnya"/>
                        <input value="<?=@$detail->id?>" type="hidden" name="id"/>
                        <input type="file" multiple name="file_berkala[]" class="mt-2 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"/>
                    </div>
                </div>
                <?php
                if(@$detail->file_berkala && $detail->file_berkala!="[]"){
                ?>
                <div>
                    File Sebelumnya
                    <small>
                    <ul>
                        <?php
                        foreach(json_decode($detail->file_berkala) as $row){
                        ?>
                        <li><a href="<?=base_url("uploads/".$row)?>" target="_blank"> <?=$row?> [ Buka ]</a></li>
                        <?php
                        }
                        ?>
                    </ul>
                    </small>
                </div>
                <?php
                }
                ?>
            </div>


            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Simpan
                </button>
            </div>
        </div>
    </form>
    
<style>
ul li{
    list-style: decimal
}