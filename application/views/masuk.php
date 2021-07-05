<!-- Dark mode not enabled -->
<!DOCTYPE html>
<html>
<head>
    <title>Masuk</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <!-- <div class="fb-login-button" >Login with Facebook</div> -->
    <div class="min-h-screen flex items-center justify-center bg-blue-100 py-12 px-4 sm:px-6 lg:px-8">
        <img class="object-cover" src="/assets/images/login-background.jpeg" style="border:20px;margin:50px;float:left;width:500px;height: 500px;">
        <hr>
        <div class="max-w-md w-full space-y-8">
            <div>
                
                <h2 class="mt-6 text-center text-3xl font-bold text-gray-900">Masuk ke dasikapakberisi.id</h2>
                
            </div>
            <form action="<?=base_url("index.php/aplikasi/masuk")?>" class="mt-8 space-y-6" method="post">
                
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label class="sr-only" for="email-address">Username</label> 
                        <input autocomplete="email" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" id="email-address" name="username" placeholder="Username" required="" type="text">
                    </div>
                    <div>
                        <label class="sr-only" for="password">Password</label> 
                        <input autocomplete="current-password" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" id="password" name="password" placeholder="Password" required="" type="password">
                    </div>
                </div>
                
                <div>
                    <button aria-required="true" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-lightblue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-50" id="signin" type="submit"><span class="absolute left-0 inset-y-0 flex items-center pl-3 text-white"><!-- Heroicon name: lock-closed -->
                     <svg aria-hidden="true" class="h-5 w-5 text-white text-white" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path clip-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" fill-rule="evenodd"></path></svg></span> Masuk</button>
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>