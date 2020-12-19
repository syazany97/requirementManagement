@extends('layouts.app')
@section('content')
    <div>
        <div class="text-center mt-24">

        </div>
        <div class="flex justify-center my-2 mx-4 md:mx-0">
            <form method="POST" action="{{ route('login') }}" class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-medium tracking-tight pb-4">
                    Sign in to your account
                </h2>
                @csrf
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-full px-3 mb-6">
                        <label class="block tracking-wide text-gray-700 text-sm font-medium mb-2" for='email'>Email
                        </label>
                        <input
                            class="appearance-none block w-full bg-white text-gray-900 font-medium border border-gray-400 rounded-lg py-3 px-3 leading-tight focus:outline-none"
                            type='email' name="email" id="email" required>
                    </div>
                    <div class="w-full md:w-full px-3 mb-6">
                        <label class="block tracking-wide text-gray-700 text-sm font-medium mb-2"
                               for='password'>Password</label>
                        <input
                            class="appearance-none block w-full bg-white text-gray-900 font-medium border border-gray-400 rounded-lg py-3 px-3 leading-tight focus:outline-none"
                            type='password' name='password' id='password' required>
                    </div>
                    <div class="w-full flex items-center justify-between px-3 mb-3 ">
                        <label for="remember" class="flex items-center w-1/2">
                            <input type="checkbox" name="remember" id="remember" class="mr-1 bg-white shadow">
                            <span class="text-sm text-gray-700 pt-1">Remember Me</span>
                        </label>
                    </div>
                    <div class="w-full md:w-full px-3 mb-6">
                        <button
                            class="appearance-none block w-full bg-blue-600 text-gray-100 font-bold border border-gray-200 rounded-lg py-3 px-3 leading-tight hover:bg-blue-500 focus:outline-none focus:bg-white focus:border-gray-500">
                            Continue
                        </button>
                    </div>

                    <div class="w-full text-center">
                        <a href="{{route('register')}}" class="text-blue-500 text-sm tracking-tight">Dont have an account? Register here</a>
                    </div>

                </div>
            </form>
        </div>
@endsection
