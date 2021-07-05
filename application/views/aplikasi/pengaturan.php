
    <div>
        <h2 class="text-2xl font-semibold leading-tight">Pengaturan Akun</h2>
    </div>

    <form action="<?=base_url("index.php/aplikasi/simpanPengaturan")?>" class="max-w-xl mt-4" method="post" enctype="multipart/form-data">
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                <div class="grid grid-cols-6 gap-3">
                    <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                        <label for="company_website" class="block text-sm font-medium text-gray-700">
                            Username
                        </label>
                        <input type="text" value="<?=@$this->session->userdata('username')?>"  name="username" id="street_address" autocomplete="street-address" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="col-span-6 sm:col-span-6 lg:col-span-4">
                        <label for="company_website" class="block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <input type="password" min="4" name="password" id="street_address" autocomplete="street-address" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Simpan
                </button>
            </div>
        </div>
    </form>
    