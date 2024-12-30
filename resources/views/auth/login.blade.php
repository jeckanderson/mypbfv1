<!DOCTYPE html>
<!--
Template Name: Rubick - HTML Admin Dashboard Template
Author: Left4code
Website: http://www.left4code.com/
Contact: muhammadrizki@left4code.com
Purchase: https://themeforest.net/user/left4code/portfolio
Renew Support: https://themeforest.net/user/left4code/portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en" class="light">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <link href="dist/pbflogo.png" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Rubick admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Rubick Admin Template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="LEFT4CODE">
    <title>Login - MyPBF</title>
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="dist/css/app.css" />
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->

<body class="login">
    <div class="container sm:px-10">
        <div class="block grid-cols-2 gap-4 xl:grid">
            <!-- BEGIN: Login Info -->
            <div class="flex-col hidden min-h-screen xl:flex">
                <a href="" class="flex items-center pt-5 -intro-x">
                    <img alt="Rubick Tailwind HTML Admin Template" class="w-32" src="dist/pbflogo.png">
                    {{-- <span class="ml-3 text-lg text-white"> MyPBF </span> --}}
                </a>
                <div class="my-auto">
                    <img alt="Rubick Tailwind HTML Admin Template" class="w-1/2 -mt-16 -intro-x"
                        src="dist/images/illustration.png">
                    <div class="mt-10 text-4xl font-medium leading-tight text-white -intro-x">
                        Login MyPBF
                    </div>
                    <div class="mt-5 text-lg text-white -intro-x text-opacity-70 dark:text-slate-400">Pedagang Besar
                        Farmasi Indonesia</div>
                </div>
            </div>
            <!-- END: Login Info -->
            <!-- BEGIN: Login Form -->
            <div class="flex h-screen py-5 my-10 xl:h-auto xl:py-0 xl:my-0">
                <div
                    class="w-full px-5 py-8 mx-auto my-auto bg-white rounded-md shadow-md xl:ml-20 dark:bg-darkmode-600 xl:bg-transparent sm:px-8 xl:p-0 xl:shadow-none sm:w-3/4 lg:w-2/4 xl:w-auto">
                    <h2 class="text-2xl font-bold text-center intro-x xl:text-3xl xl:text-left">
                        Sign In
                    </h2>
                    @if ($errors->any())
                        <div class="mt-5 alert alert-danger">
                            {{ $errors->first('email') }}
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mt-2 text-center intro-x text-slate-400 xl:hidden">A few more clicks to sign in to
                            your
                            account. Manage all your e-commerce accounts in one place</div>
                        <div class="mt-8 intro-x">
                            <input type="text" name="email" value="{{ old('email') }}"
                                class="block px-4 py-3 intro-x login__input form-control" placeholder="Email">
                            <input type="password" name="password"
                                class="block px-4 py-3 mt-4 intro-x login__input form-control" placeholder="Password">
                        </div>
                        <div
                            class="flex justify-end mt-4 text-xs intro-x text-slate-600 dark:text-slate-500 sm:text-sm">
                            {{-- <div class="flex items-center mr-auto">
                                <input id="remember-me" type="checkbox" class="mr-2 border form-check-input">
                                <label class="cursor-pointer select-none" for="remember-me">Remember me</label>
                            </div> --}}
                            <a href="">Forgot Password?</a>
                        </div>
                        <div class="mt-5 text-center intro-x xl:mt-8 xl:text-left">
                            <button class="w-full px-4 py-3 align-top btn btn-primary xl:w-32 xl:mr-3">Login</button>
                            <button
                                class="w-full px-4 py-3 mt-3 align-top btn btn-outline-secondary xl:w-32 xl:mt-0">Register</button>
                        </div>
                        <div class="mt-10 text-center intro-x xl:mt-24 text-slate-600 dark:text-slate-500 xl:text-left">
                            By
                            signin up, you agree to our <a class="text-primary dark:text-slate-200" href="">Terms
                                and
                                Conditions</a> & <a class="text-primary dark:text-slate-200" href="">Privacy
                                Policy</a> </div>
                    </form>
                </div>
            </div>
            <!-- END: Login Form -->
        </div>
    </div>

    <!-- BEGIN: JS Assets-->
    <script src="dist/js/app.js"></script>
    <!-- END: JS Assets-->
</body>

</html>
