@php
    $subdomain = request()->route('subdomain');
    $user = auth()->user();
    $student = null;
    if (function_exists('currentStudent') && (!$user || $user->role !== 'owner')) {
        $student = currentStudent();
    }

    if ($user) {
        $displayName = explode(' ', $user->name)[0];
    } elseif ($student) {
        $displayName = explode(' ', $student->name)[0];
    } else {
        $displayName = 'Guest';
    }

    $hour = now()->hour;

    if ($hour >= 5 && $hour < 12) {
        $greeting = "Good morning, {$displayName} ☀️";
        $sub = "Hope you have a productive day ahead!";
    } elseif ($hour >= 12 && $hour < 14) {
        $greeting = "What a lovely afternoon, {$displayName} 🌤️";
        $sub = "Hope you've had lunch — you need the energy!";
    } elseif ($hour >= 14 && $hour < 17) {
        $greeting = "Good afternoon, {$displayName} 🌥️";
        $sub = "Keep pushing, you're doing great!";
    } elseif ($hour >= 17 && $hour < 20) {
        $greeting = "Good evening, {$displayName} 🌇";
        $sub = "It's past 6PM — hope you're not too exhausted!";
    } elseif ($hour >= 20 && $hour < 23) {
        $greeting = "Good evening, {$displayName} 🌙";
        $sub = "Wrapping up for the day? You've earned it!";
    } else {
        $greeting = "Burning the midnight oil, {$displayName}? 🌚";
        $sub = "Don't forget to rest — it's past midnight!";
    }
@endphp

<!-- Navbar -->
<nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all shadow-none duration-250 ease-soft-in rounded-2xl lg:flex-nowrap lg:justify-start"
     navbar-main navbar-scroll="true">
    <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
        <nav>
            <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
                <li class="text-sm leading-normal">
                    <a class="opacity-50 text-slate-700" href="javascript:;">Pages</a>
                </li>
                <li class="text-sm pl-2 capitalize leading-normal text-slate-700 before:float-left before:pr-2 before:text-gray-600 before:content-['/']"
                    aria-current="page">
                    Dashboard
                </li>
            </ol>

            <div>
                <h6 class="mb-0 font-bold capitalize">{{ $greeting }}</h6>
                <p class="mb-0 text-xs text-slate-400">
                    {{ now()->format('l, F j Y') }} &mdash; {{ $sub }}
                </p>

                <!-- School Info & Version -->
<div class="mt-1 space-y-1">
    {{-- School Name and Subdomain --}}
    <div class="inline-flex items-center gap-1.5">
        <!-- <span class="block font-semibold transition-all duration-200 ease-nav-brand">
            {{ app('tenant')->name ?? 'CoreDesk' }}
        </span> -->
        <span class="text-xs text-slate-400 font-normal">
            {{ $subdomain ?? '' }}.coredesk.com.ng
        </span>
    </div>

    {{-- Version Badge --}}
    <div class="inline-flex items-center gap-1.5">
        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-slate-100 text-slate-500 border border-slate-200">
            CoreDesk v2.0
        </span>
        <span class="text-xs text-slate-400 font-normal">Stable</span>
    </div>
</div>
        </nav>

        <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
            <div class="flex items-center md:ml-auto md:pr-4">
                <div class="relative flex flex-wrap items-stretch w-full transition-all rounded-lg ease-soft">
                    <span class="text-sm ease-soft leading-5.6 absolute z-50 -ml-px flex h-full items-center whitespace-nowrap rounded-lg rounded-tr-none rounded-br-none border border-r-0 border-transparent bg-transparent py-2 px-2.5 text-center font-normal text-slate-500 transition-all">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text"
                           class="pl-8.75 text-sm focus:shadow-soft-primary-outline ease-soft w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                           placeholder="Type here..." />
                </div>
            </div>
            <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full">
                {{-- bell icon --}}
<li class="relative">
    <a href="{{ route('tenant.admin.helpline.index', request()->route('subdomain')) }}" 
       class="relative block p-2 text-slate-500 hover:text-slate-700 transition">
        <i class="fa fa-bell text-lg"></i>
        <span id="unreadBadge" class="absolute -top-1 -right-1 bg-red-500 text-danger text-[10px] font-bold rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1 hidden">
            0
        </span>
    </a>
</li>
                <li class="relative flex items-center pr-2">
                    <p class="hidden transform-dropdown-show"></p>
                    <a href="javascript:;"
                       class="block p-0 text-sm transition-all ease-nav-brand text-slate-500"
                       dropdown-trigger
                       aria-expanded="false">
                        <div class="flex items-center">
                            <i class="cursor-pointer fa fa-user-circle text-lg"></i>
                            <span class="ml-2 hidden sm:inline-block font-semibold">{{ $displayName }}</span>
                            <i class="cursor-pointer fa fa-chevron-down text-xs ml-1"></i>
                        </div>
                    </a>

                    <ul dropdown-menu
                        class="text-sm transform-dropdown before:font-awesome before:leading-default before:duration-350 before:ease-soft lg:shadow-soft-3xl duration-250 min-w-44 before:sm:right-7.5 before:text-5.5 pointer-events-none absolute right-0 top-0 z-50 origin-top list-none rounded-lg border-0 border-solid border-transparent bg-white bg-clip-padding px-2 py-4 text-left text-slate-500 opacity-0 transition-all before:absolute before:right-2 before:left-auto before:top-0 before:z-50 before:inline-block before:font-normal before:text-white before:antialiased before:transition-all before:content-['\f0d8'] sm:-mr-6 lg:absolute lg:right-0 lg:left-auto lg:mt-2 lg:block lg:cursor-pointer">

                        {{-- Profile link --}}
                        @if($user)
                            <li class="relative mb-2">
                                <a class="ease-soft py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors"
                                   href="{{ route('profile.edit') }}">
                                    <div class="flex items-center">
                                        <i class="fa fa-user mr-2"></i>
                                        <span>Profile</span>
                                    </div>
                                </a>
                            </li>
                        @elseif($student)
                            <li class="relative mb-2">
                                <a class="ease-soft py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors"
                                   href="{{ route('student.profile', $subdomain) }}">
                                    <div class="flex items-center">
                                        <i class="fa fa-user mr-2"></i>
                                        <span>Profile</span>
                                    </div>
                                </a>
                            </li>
                        @endif

                        {{-- Divider --}}
                        <li class="relative my-2">
                            <hr class="my-2 border-gray-200">
                        </li>

                        {{-- Logout --}}
                        @if($user)
                            <li class="relative">
                                <form method="POST" action="{{ route('tenant.logout', $subdomain) }}" id="logout-form">
                                    @csrf
                                    <button type="submit"
                                            class="ease-soft py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors">
                                        <div class="flex items-center text-red-500">
                                            <i class="fa fa-sign-out-alt mr-2"></i>
                                            <span>Logout</span>
                                        </div>
                                    </button>
                                </form>
                            </li>
                        @elseif($student)
                            <li class="relative">
        <!-- ✅ FIXED: Use request()->route('subdomain') to match working version -->
        <form method="POST" action="{{ route('student.logout', request()->route('subdomain')) }}" id="student-logout-form">
            @csrf
            <button type="submit"
                    class="ease-soft py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors">
                <div class="flex items-center text-red-500">
                    <i class="fa fa-sign-out-alt mr-2"></i>
                    <span>Logout</span>
                </div>
            </button>
        </form>
    </li>
                        @else
                            <li class="relative">
                                <a class="ease-soft py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors"
                                   href="{{ route('student.login', $subdomain) }}">
                                    <div class="flex items-center text-blue-500">
                                        <i class="fa fa-sign-in-alt mr-2"></i>
                                        <span>Login</span>
                                    </div>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>