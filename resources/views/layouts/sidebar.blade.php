<!-- sidenav  -->
 @php
$subdomain = request()->route('subdomain');
@endphp
    <aside
      class="max-w-62.5 ease-nav-brand z-990 fixed inset-y-0 my-4 ml-4 block w-full -translate-x-full flex-wrap items-center justify-between  rounded-2xl border-0 bg-white p-0 antialiased shadow-none transition-transform duration-200 xl:left-0 xl:translate-x-0 xl:bg-transparent">
      <div class="h-19.5">
        <i
          class="absolute top-0 right-0 hidden p-4 opacity-50 cursor-pointer fas fa-times text-slate-400 xl:hidden"
          sidenav-close></i>
        <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap text-slate-700" href="#">
           <img src="{{ asset('dashboard/build/assets/img/logo-ct.png') }}"  
         class="inline h-full max-w-full transition-all duration-200 ease-nav-brand max-h-8"
         alt="main_logo" />
         <div class="inline-block ml-2">
          <span class="block font-semibold transition-all duration-200 ease-nav-brand">
            {{ app('tenant')->name ?? 'CoreDesk' }} Dashboard
          </span>
          <!-- domain link start here -->
           <!-- <span class="text-xs text-slate-400 font-normal">
            {{ $subdomain ?? '' }}.coredesk.local
          </span> -->

          <!-- ends here -->


           </div>
        </a>
      </div>

      <hr
        class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent" />

      <div
        class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
        <ul class="flex flex-col pl-0 mb-0">
          <!-- new route start here -->
           @php
$user = auth()->user();
@endphp

<ul class="flex flex-col pl-0 mb-0 list-none">
    {{-- SUPER ADMIN ONLY --}}
    @if($user && $user->role === 'super_admin')

    <!-- dashboard -->
     <li class="mt-0.5 w-full">
            <a
              class="py-2.7 shadow-soft-xl text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg bg-white px-4 font-semibold text-slate-700 transition-colors"
              href="{{ route('tenant.admin.dashboard', $subdomain) }}"> 
              
              
              <div
                class="bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                <svg
                  width="12px"
                  height="12px"
                  viewBox="0 0 45 40"
                  version="1.1"
                  xmlns="#"
                  xmlns:xlink="#">
                  <title>shop</title>
                  <g
                    stroke="none"
                    stroke-width="1"
                    fill="none"
                    fill-rule="evenodd">
                    <g
                      transform="translate(-1716.000000, -439.000000)"
                      fill="#FFFFFF"
                      fill-rule="nonzero">
                      <g transform="translate(1716.000000, 291.000000)">
                        <g transform="translate(0.000000, 148.000000)">
                          <path
                            class="opacity-60"
                            d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z"></path>
                          <path
                            class=""
                            d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z"></path>
                        </g>
                      </g>
                    </g>
                  </g>
                </svg>
              </div>
              <span
                class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft"
                >Dashboard</span
              >
            </a>
          </li>
          <!-- ends here -->

    {{-- Teachers --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('tenant.teachers.index', $subdomain) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center text-center xl:p-2.5">
              <i class="fa fa-chalkboard-teacher text-slate-700 text-sm"></i>
           </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Staff Management</span>
        </a>
    </li>

    {{-- Subject --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('tenant.subjects.index', $subdomain) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center text-center xl:p-2.5">
                <i class="fa fa-book-open text-slate-700 text-sm"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Subject Management</span>
        </a>
    </li>

    {{-- Classes --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('tenant.classes.index', $subdomain) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center text-center xl:p-2.5">
                <i class="fa fa-school text-slate-700 text-sm"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Class Management</span>
        </a>
    </li>

    

    {{-- Student --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('tenant.students.index', $subdomain) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center text-center xl:p-2.5">
                <i class="fa fa-user-graduate text-slate-700 text-sm"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Student Management</span>
        </a>
    </li>

    {{-- Staff Lecture notes --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('tenant.admin.lecture_note.index', $subdomain) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center text-center xl:p-2.5">
                <i class="fa fa-book-open text-slate-700 text-sm"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Staff Lecture Notes</span>
        </a>
    </li>

    

    {{-- Upgrade Plan --}}
    <!-- <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('tenant.billing', $subdomain) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center text-center xl:p-2.5">
                <i class="fa fa-crown text-slate-700 text-sm"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Upgrade Plan</span>
        </a>
    </li> -->

    {{-- Results --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('tenant.admin.results.index', $subdomain) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center text-center xl:p-2.5">
                <i class="fa fa-poll text-slate-700 text-sm"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Result Management</span>
        </a>
    </li>

    {{-- Reports Cards --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('tenant.admin.results.filter', $subdomain) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center text-center xl:p-2.5">
                <i class="fa fa-id-card text-slate-700 text-sm"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Report Cards</span>
        </a>
    </li>

    

    {{-- Class Timetable --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('tenant.timetable.index', $subdomain) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center text-center xl:p-2.5">
                <i class="fa fa-calendar-alt text-slate-700 text-sm"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Class Timetable</span>
        </a>
    </li>

    {{-- Assessment Timetable --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('tenant.test.index', $subdomain) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center text-center xl:p-2.5">
                <i class="fa fa-pencil-alt text-slate-700 text-sm"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Assessment Timetable</span>
        </a>
    </li>

    {{-- Exam Timetable --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('tenant.exam.index', $subdomain) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center text-center xl:p-2.5">
                <i class="fa fa-file-alt text-slate-700 text-sm"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Examination Timetable</span>
        </a>
    </li>

    {{-- Users --}}
    <!-- <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="/admin/users">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center fill-current stroke-0 text-center xl:p-2.5">
                <svg width="12px" height="12px" viewBox="0 0 44 44" version="1.1"
                     xmlns="#">
                    <title>users</title>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g fill-rule="nonzero">
                            <path class="fill-slate-800 opacity-60"
                                  d="M16,20 C20.418278,20 24,16.418278 24,12 C24,7.581722 20.418278,4 16,4 C11.581722,4 8,7.581722 8,12 C8,16.418278 11.581722,20 16,20 Z"/>
                            <path class="fill-slate-800"
                                  d="M0,40 C0,30.6112698 7.16344137,23 16,23 C24.8365586,23 32,30.6112698 32,40 L0,40 Z M30,18 C33.3137085,18 36,15.3137085 36,12 C36,8.6862915 33.3137085,6 30,6 M30,21 C36.627,21 42,26.9 42,34.5 L36,34.5"/>
                        </g>
                    </g>
                </svg>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Users</span>
        </a>
    </li> -->

    {{-- Settings --}}
    <!-- <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="/admin/settings">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center fill-current stroke-0 text-center xl:p-2.5">
                <svg width="12px" height="12px" viewBox="0 0 44 44" version="1.1"
                     xmlns="#">
                    <title>settings</title>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g fill-rule="nonzero">
                            <path class="fill-slate-800 opacity-60"
                                  d="M22,28 C25.3137085,28 28,25.3137085 28,22 C28,18.6862915 25.3137085,16 22,16 C18.6862915,16 16,18.6862915 16,22 C16,25.3137085 18.6862915,28 22,28 Z"/>
                            <path class="fill-slate-800"
                                  d="M38.5,15.7 L36.3,14.4 C36.7,13.6 37,12.8 37,12 C37,11.2 36.7,10.4 36.3,9.6 L38.5,8.3 C39.3,7.8 39.5,6.8 39,6 L37,2.5 C36.5,1.7 35.5,1.5 34.7,2 L32.5,3.3 C31.3,2.5 30,2 28.5,1.7 L28.5,0 C28.5,-0.8 27.8,-1.5 27,-1.5 L23,-1.5 C22.2,-1.5 21.5,-0.8 21.5,0 L21.5,1.7 C20,2 18.7,2.5 17.5,3.3 L15.3,2 C14.5,1.5 13.5,1.7 13,2.5 L11,6 C10.5,6.8 10.7,7.8 11.5,8.3 L13.7,9.6 C13.3,10.4 13,11.2 13,12 C13,12.8 13.3,13.6 13.7,14.4 L11.5,15.7 C10.7,16.2 10.5,17.2 11,18 L13,21.5 C13.5,22.3 14.5,22.5 15.3,22 L17.5,20.7 C18.7,21.5 20,22 21.5,22.3 L21.5,24 C21.5,24.8 22.2,25.5 23,25.5 L27,25.5 C27.8,25.5 28.5,24.8 28.5,24 L28.5,22.3 C30,22 31.3,21.5 32.5,20.7 L34.7,22 C35.5,22.5 36.5,22.3 37,21.5 L39,18 C39.5,17.2 39.3,16.2 38.5,15.7 Z"/>
                        </g>
                    </g>
                </svg>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Settings</span>
        </a>
    </li> -->

    @endif

    {{-- TEACHER --}}
    @if($user && $user->role === 'teacher')

    <!-- dashboard -->
     <li class="mt-0.5 w-full">
            <a
              class="py-2.7 shadow-soft-xl text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg bg-white px-4 font-semibold text-slate-700 transition-colors"
              href="{{ route('tenant.teacher.dashboard', $subdomain) }}"> 
              
              
              <div
                class="bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                <svg
                  width="12px"
                  height="12px"
                  viewBox="0 0 45 40"
                  version="1.1"
                  xmlns="#"
                  xmlns:xlink="#">
                  <title>shop</title>
                  <g
                    stroke="none"
                    stroke-width="1"
                    fill="none"
                    fill-rule="evenodd">
                    <g
                      transform="translate(-1716.000000, -439.000000)"
                      fill="#FFFFFF"
                      fill-rule="nonzero">
                      <g transform="translate(1716.000000, 291.000000)">
                        <g transform="translate(0.000000, 148.000000)">
                          <path
                            class="opacity-60"
                            d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z"></path>
                          <path
                            class=""
                            d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z"></path>
                        </g>
                      </g>
                    </g>
                  </g>
                </svg>
              </div>
              <span
                class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft"
                >Dashboard</span
              >
            </a>
          </li>
          <!-- ends here -->

          {{-- Lecture Notes --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('teacher.lecture_note.index', $subdomain) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center text-center xl:p-2.5">
                <i class="fa fa-book text-slate-700 text-sm"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">My Lecture Notes</span>
        </a>
    </li>

    {{-- My Classes --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('tenant.teacher.classes.index', $subdomain) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center text-center xl:p-2.5">
                <i class="fa fa-book text-slate-700 text-sm"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">My Classes & Student</span>
        </a>
    </li>


    {{-- My Students --}}
    <!-- <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('tenant.teacher.students', $subdomain) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center text-center xl:p-2.5">
                <i class="fa fa-user text-slate-700 text-sm"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">My Students</span>
        </a>
    </li> -->


    {{-- My Timetable --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('teacher.timetable', $subdomain) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center text-center xl:p-2.5">
                <i class="fa fa-calendar text-slate-700 text-sm"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">My Timetable</span>
        </a>
    </li>

    {{-- Record Attendance --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('teacher.attendance.index', $subdomain) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center text-center xl:p-2.5">
                <i class="fa fa-check-circle text-slate-700 text-sm"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Record Attendance</span>
        </a>
    </li>

    {{-- Results Entry--}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('tenant.teacher.results.index', $subdomain) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center text-center xl:p-2.5">
                <i class="fa fa-file-alt text-slate-700 text-sm"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Results Entry</span>
        </a>
    </li>

    {{-- Assignments --}}
    <!-- <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="#">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center text-center xl:p-2.5">
                <i class="fa fa-tasks text-slate-700 text-sm"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Assignments</span>
        </a>
    </li> -->

    @endif

    {{-- ACCOUNTANT --}}
    @if($user && $user->role === 'accountant')

    {{-- Finance Dashboard --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="#">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center fill-current stroke-0 text-center xl:p-2.5">
                <svg width="12px" height="12px" viewBox="0 0 45 45" version="1.1"
                     xmlns="#">
                    <title>finance-dashboard</title>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g fill-rule="nonzero">
                            <path class="fill-slate-800 opacity-60"
                                  d="M0,2 C0,0.9 0.9,0 2,0 L18,0 C19.1,0 20,0.9 20,2 L20,18 C20,19.1 19.1,20 18,20 L2,20 C0.9,20 0,19.1 0,18 Z"/>
                            <path class="fill-slate-800"
                                  d="M25,2 C25,0.9 25.9,0 27,0 L43,0 C44.1,0 45,0.9 45,2 L45,18 C45,19.1 44.1,20 43,20 L27,20 C25.9,20 25,19.1 25,18 Z M0,27 C0,25.9 0.9,25 2,25 L18,25 C19.1,25 20,25.9 20,27 L20,43 C20,44.1 19.1,45 18,45 L2,45 C0.9,45 0,44.1 0,43 Z M25,27 C25,25.9 25.9,25 27,25 L43,25 C44.1,25 45,25.9 45,27 L45,43 C45,44.1 44.1,45 43,45 L27,45 C25.9,45 25,44.1 25,43 Z"/>
                        </g>
                    </g>
                </svg>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Finance Dashboard</span>
        </a>
    </li>

    {{-- Payments --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="#">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center fill-current stroke-0 text-center xl:p-2.5">
                <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1"
                     xmlns="#">
                    <title>payments</title>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                            <g transform="translate(1716.000000, 291.000000)">
                                <g transform="translate(453.000000, 454.000000)">
                                    <path class="fill-slate-800 opacity-60"
                                          d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"/>
                                    <path class="fill-slate-800"
                                          d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"/>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Payments</span>
        </a>
    </li>

    {{-- Finance Reports --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="#">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center fill-current stroke-0 text-center xl:p-2.5">
                <svg width="12px" height="12px" viewBox="0 0 40 44" version="1.1"
                     xmlns="#">
                    <title>finance-reports</title>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g fill-rule="nonzero">
                            <path class="fill-slate-800 opacity-60"
                                  d="M10,0 L30,0 L40,10 L40,42 C40,43.1045695 39.1045695,44 38,44 L2,44 C0.8954305,44 0,43.1045695 0,42 L0,2 C0,0.8954305 0.8954305,0 2,0 Z"/>
                            <path class="fill-slate-800"
                                  d="M10,0 L10,10 L40,10 Z M10,22 L30,22 M10,30 L24,30"/>
                        </g>
                    </g>
                </svg>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Reports</span>
        </a>
    </li>

    @endif



    {{-- STUDENT — uses session auth, not Laravel auth --}}
@php $student = currentStudent(); @endphp
@if(!$user && $student)

<!-- dashboard -->
     <li class="mt-0.5 w-full">
            <a
              class="py-2.7 shadow-soft-xl text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg bg-white px-4 font-semibold text-slate-700 transition-colors"
              href="{{ route('student.dashboard', $subdomain) }}"> 
              
              
              <div
                class="bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                <svg
                  width="12px"
                  height="12px"
                  viewBox="0 0 45 40"
                  version="1.1"
                  xmlns="#"
                  xmlns:xlink="#">
                  <title>shop</title>
                  <g
                    stroke="none"
                    stroke-width="1"
                    fill="none"
                    fill-rule="evenodd">
                    <g
                      transform="translate(-1716.000000, -439.000000)"
                      fill="#FFFFFF"
                      fill-rule="nonzero">
                      <g transform="translate(1716.000000, 291.000000)">
                        <g transform="translate(0.000000, 148.000000)">
                          <path
                            class="opacity-60"
                            d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z"></path>
                          <path
                            class=""
                            d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z"></path>
                        </g>
                      </g>
                    </g>
                  </g>
                </svg>
              </div>
              <span
                class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft"
                >Dashboard</span
              >
            </a>
          </li>
          <!-- ends here -->

          {{-- My Lecture notes --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('student.lecture_note.index', $subdomain) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center fill-current stroke-0 text-center xl:p-2.5">
                <svg width="12px" height="12px" viewBox="0 0 45 45" version="1.1" xmlns="#">
                    <title>My Lecture Notes</title>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g fill-rule="nonzero">
                            <path class="fill-slate-800 opacity-60"
                                  d="M0,2 C0,0.9 0.9,0 2,0 L18,0 C19.1,0 20,0.9 20,2 L20,18 C20,19.1 19.1,20 18,20 L2,20 C0.9,20 0,19.1 0,18 Z"/>
                            <path class="fill-slate-800"
                                  d="M25,2 C25,0.9 25.9,0 27,0 L43,0 C44.1,0 45,0.9 45,2 L45,18 C45,19.1 44.1,20 43,20 L27,20 C25.9,20 25,19.1 25,18 Z M0,27 C0,25.9 0.9,25 2,25 L18,25 C19.1,25 20,25.9 20,27 L20,43 C20,44.1 19.1,45 18,45 L2,45 C0.9,45 0,44.1 0,43 Z M25,27 C25,25.9 25.9,25 27,25 L43,25 C44.1,25 45,25.9 45,27 L45,43 C45,44.1 44.1,45 43,45 L27,45 C25.9,45 25,44.1 25,43 Z"/>
                        </g>
                    </g>
                </svg>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">My Lecture Notes</span>
        </a>
    </li>


    {{-- My Results --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('student.results.index', request()->route('subdomain')) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center fill-current stroke-0 text-center xl:p-2.5">
                <svg width="12px" height="12px" viewBox="0 0 45 45" version="1.1" xmlns="#">
                    <title>My Result</title>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g fill-rule="nonzero">
                            <path class="fill-slate-800 opacity-60"
                                  d="M0,2 C0,0.9 0.9,0 2,0 L18,0 C19.1,0 20,0.9 20,2 L20,18 C20,19.1 19.1,20 18,20 L2,20 C0.9,20 0,19.1 0,18 Z"/>
                            <path class="fill-slate-800"
                                  d="M25,2 C25,0.9 25.9,0 27,0 L43,0 C44.1,0 45,0.9 45,2 L45,18 C45,19.1 44.1,20 43,20 L27,20 C25.9,20 25,19.1 25,18 Z M0,27 C0,25.9 0.9,25 2,25 L18,25 C19.1,25 20,25.9 20,27 L20,43 C20,44.1 19.1,45 18,45 L2,45 C0.9,45 0,44.1 0,43 Z M25,27 C25,25.9 25.9,25 27,25 L43,25 C44.1,25 45,25.9 45,27 L45,43 C45,44.1 44.1,45 43,45 L27,45 C25.9,45 25,44.1 25,43 Z"/>
                        </g>
                    </g>
                </svg>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">My Result</span>
        </a>
    </li>



    {{-- My Subjects --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('student.subjects', request()->route('subdomain')) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center fill-current stroke-0 text-center xl:p-2.5">
                <svg width="12px" height="12px" viewBox="0 0 45 45" version="1.1" xmlns="#">
                    <title>My Subject</title>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g fill-rule="nonzero">
                            <path class="fill-slate-800 opacity-60"
                                  d="M0,2 C0,0.9 0.9,0 2,0 L18,0 C19.1,0 20,0.9 20,2 L20,18 C20,19.1 19.1,20 18,20 L2,20 C0.9,20 0,19.1 0,18 Z"/>
                            <path class="fill-slate-800"
                                  d="M25,2 C25,0.9 25.9,0 27,0 L43,0 C44.1,0 45,0.9 45,2 L45,18 C45,19.1 44.1,20 43,20 L27,20 C25.9,20 25,19.1 25,18 Z M0,27 C0,25.9 0.9,25 2,25 L18,25 C19.1,25 20,25.9 20,27 L20,43 C20,44.1 19.1,45 18,45 L2,45 C0.9,45 0,44.1 0,43 Z M25,27 C25,25.9 25.9,25 27,25 L43,25 C44.1,25 45,25.9 45,27 L45,43 C45,44.1 44.1,45 43,45 L27,45 C25.9,45 25,44.1 25,43 Z"/>
                        </g>
                    </g>
                </svg>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">My Subject</span>
        </a>
    </li>

    {{-- My Teachers --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('student.teachers', request()->route('subdomain')) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center fill-current stroke-0 text-center xl:p-2.5">
                <svg width="12px" height="12px" viewBox="0 0 45 45" version="1.1" xmlns="#">
                    <title>My Teacher</title>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g fill-rule="nonzero">
                            <path class="fill-slate-800 opacity-60"
                                  d="M0,2 C0,0.9 0.9,0 2,0 L18,0 C19.1,0 20,0.9 20,2 L20,18 C20,19.1 19.1,20 18,20 L2,20 C0.9,20 0,19.1 0,18 Z"/>
                            <path class="fill-slate-800"
                                  d="M25,2 C25,0.9 25.9,0 27,0 L43,0 C44.1,0 45,0.9 45,2 L45,18 C45,19.1 44.1,20 43,20 L27,20 C25.9,20 25,19.1 25,18 Z M0,27 C0,25.9 0.9,25 2,25 L18,25 C19.1,25 20,25.9 20,27 L20,43 C20,44.1 19.1,45 18,45 L2,45 C0.9,45 0,44.1 0,43 Z M25,27 C25,25.9 25.9,25 27,25 L43,25 C44.1,25 45,25.9 45,27 L45,43 C45,44.1 44.1,45 43,45 L27,45 C25.9,45 25,44.1 25,43 Z"/>
                        </g>
                    </g>
                </svg>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">My Teacher</span>
        </a>
    </li>



    {{-- My Timetables --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('student.timetable', request()->route('subdomain')) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center fill-current stroke-0 text-center xl:p-2.5">
                <svg width="12px" height="12px" viewBox="0 0 45 45" version="1.1" xmlns="#">
                    <title>My Timetable</title>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g fill-rule="nonzero">
                            <path class="fill-slate-800 opacity-60"
                                  d="M0,2 C0,0.9 0.9,0 2,0 L18,0 C19.1,0 20,0.9 20,2 L20,18 C20,19.1 19.1,20 18,20 L2,20 C0.9,20 0,19.1 0,18 Z"/>
                            <path class="fill-slate-800"
                                  d="M25,2 C25,0.9 25.9,0 27,0 L43,0 C44.1,0 45,0.9 45,2 L45,18 C45,19.1 44.1,20 43,20 L27,20 C25.9,20 25,19.1 25,18 Z M0,27 C0,25.9 0.9,25 2,25 L18,25 C19.1,25 20,25.9 20,27 L20,43 C20,44.1 19.1,45 18,45 L2,45 C0.9,45 0,44.1 0,43 Z M25,27 C25,25.9 25.9,25 27,25 L43,25 C44.1,25 45,25.9 45,27 L45,43 C45,44.1 44.1,45 43,45 L27,45 C25.9,45 25,44.1 25,43 Z"/>
                        </g>
                    </g>
                </svg>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">My Timetable</span>
        </a>
    </li>



    {{-- My Test Timetable --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('student.tests', request()->route('subdomain')) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center fill-current stroke-0 text-center xl:p-2.5">
                <svg width="12px" height="12px" viewBox="0 0 45 45" version="1.1" xmlns="#">
                    <title>My Test Timetable</title>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g fill-rule="nonzero">
                            <path class="fill-slate-800 opacity-60"
                                  d="M0,2 C0,0.9 0.9,0 2,0 L18,0 C19.1,0 20,0.9 20,2 L20,18 C20,19.1 19.1,20 18,20 L2,20 C0.9,20 0,19.1 0,18 Z"/>
                            <path class="fill-slate-800"
                                  d="M25,2 C25,0.9 25.9,0 27,0 L43,0 C44.1,0 45,0.9 45,2 L45,18 C45,19.1 44.1,20 43,20 L27,20 C25.9,20 25,19.1 25,18 Z M0,27 C0,25.9 0.9,25 2,25 L18,25 C19.1,25 20,25.9 20,27 L20,43 C20,44.1 19.1,45 18,45 L2,45 C0.9,45 0,44.1 0,43 Z M25,27 C25,25.9 25.9,25 27,25 L43,25 C44.1,25 45,25.9 45,27 L45,43 C45,44.1 44.1,45 43,45 L27,45 C25.9,45 25,44.1 25,43 Z"/>
                        </g>
                    </g>
                </svg>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">My Assessment Timetable</span>
        </a>
    </li>



    {{-- My Exam Timetable --}}
    <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="{{ route('student.exams', request()->route('subdomain')) }}">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center fill-current stroke-0 text-center xl:p-2.5">
                <svg width="12px" height="12px" viewBox="0 0 45 45" version="1.1" xmlns="#">
                    <title>My Exam Timetable</title>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g fill-rule="nonzero">
                            <path class="fill-slate-800 opacity-60"
                                  d="M0,2 C0,0.9 0.9,0 2,0 L18,0 C19.1,0 20,0.9 20,2 L20,18 C20,19.1 19.1,20 18,20 L2,20 C0.9,20 0,19.1 0,18 Z"/>
                            <path class="fill-slate-800"
                                  d="M25,2 C25,0.9 25.9,0 27,0 L43,0 C44.1,0 45,0.9 45,2 L45,18 C45,19.1 44.1,20 43,20 L27,20 C25.9,20 25,19.1 25,18 Z M0,27 C0,25.9 0.9,25 2,25 L18,25 C19.1,25 20,25.9 20,27 L20,43 C20,44.1 19.1,45 18,45 L2,45 C0.9,45 0,44.1 0,43 Z M25,27 C25,25.9 25.9,25 27,25 L43,25 C44.1,25 45,25.9 45,27 L45,43 C45,44.1 44.1,45 43,45 L27,45 C25.9,45 25,44.1 25,43 Z"/>
                        </g>
                    </g>
                </svg>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">My Exam Timetable</span>
        </a>
    </li>

    {{-- Payments --}}
    <!-- <li class="mt-0.5 w-full">
        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
           href="#">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center fill-current stroke-0 text-center xl:p-2.5">
                <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="#">
                    <title>payments</title>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                            <g transform="translate(1716.000000, 291.000000)">
                                <g transform="translate(453.000000, 454.000000)">
                                    <path class="fill-slate-800 opacity-60"
                                          d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"/>
                                    <path class="fill-slate-800"
                                          d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"/>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Payments</span>
        </a>
    </li> -->

    <!-- profile -->
     <li class="w-full mt-4">
            <h6
              class="pl-6 ml-2 text-xs font-bold leading-tight uppercase opacity-60">
              My Profile
            </h6>
          </li>

          <li class="mt-0.5 w-full">
            <a
              class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
              href="{{ route('student.profile', request()->route('subdomain')) }}">
              <div
                class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                <svg
                  width="12px"
                  height="12px"
                  viewBox="0 0 46 42"
                  version="1.1"
                  xmlns="#"
                  xmlns:xlink="#">
                  <title>customer-support</title>
                  <g
                    stroke="none"
                    stroke-width="1"
                    fill="none"
                    fill-rule="evenodd">
                    <g
                      transform="translate(-1717.000000, -291.000000)"
                      fill="#FFFFFF"
                      fill-rule="nonzero">
                      <g transform="translate(1716.000000, 291.000000)">
                        <g transform="translate(1.000000, 0.000000)">
                          <path
                            class="fill-slate-800 opacity-60"
                            d="M45,0 L26,0 C25.447,0 25,0.447 25,1 L25,20 C25,20.379 25.214,20.725 25.553,20.895 C25.694,20.965 25.848,21 26,21 C26.212,21 26.424,20.933 26.6,20.8 L34.333,15 L45,15 C45.553,15 46,14.553 46,14 L46,1 C46,0.447 45.553,0 45,0 Z"></path>
                          <path
                            class="fill-slate-800"
                            d="M22.883,32.86 C20.761,32.012 17.324,31 13,31 C8.676,31 5.239,32.012 3.116,32.86 C1.224,33.619 0,35.438 0,37.494 L0,41 C0,41.553 0.447,42 1,42 L25,42 C25.553,42 26,41.553 26,41 L26,37.494 C26,35.438 24.776,33.619 22.883,32.86 Z"></path>
                          <path
                            class="fill-slate-800"
                            d="M13,28 C17.432,28 21,22.529 21,18 C21,13.589 17.411,10 13,10 C8.589,10 5,13.589 5,18 C5,22.529 8.568,28 13,28 Z"></path>
                        </g>
                      </g>
                    </g>
                  </g>
                </svg>
              </div>
              <span
                class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft"
                >Profile</span
              >
            </a>
          </li>

@endif

</ul>

          <!-- ends here -->

          

          
          <!-- signin and sign out -->

          {{-- ✅ Logout --}}
@auth
<li class="mt-0.5 w-full">
    <form method="POST" action="{{ route('tenant.logout', $subdomain) }}">
        @csrf
        <button type="submit"
            class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors w-full text-left bg-transparent border-0 cursor-pointer">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center fill-current stroke-0 text-center xl:p-2.5">
                <svg width="12px" height="12px" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg" fill="none">
                    <path class="fill-slate-800" fill-rule="evenodd" clip-rule="evenodd"
                          d="M15,6 L5,6 C3.9,6 3,6.9 3,8 L3,32 C3,33.1 3.9,34 5,34 L15,34 L15,30 L7,30 L7,10 L15,10 Z M28,8 L22,2 L10,14 L22,26 L28,20 L22,14 Z M28,14 L37,14 L37,26 L28,26 L28,32 L40,20 L28,8 Z"
                          fill="#344767"/>
                </svg>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft text-slate-700">
                Sign Out ({{ auth()->user()->name }})
            </span>
        </button>
    </form>
</li>
@endauth

{{-- ✅ Student Logout --}}
@if(!$user && currentStudent())
<li class="mt-0.5 w-full">
    <form method="POST" action="{{ route('student.logout', request()->route('subdomain')) }}" class="w-full">
        @csrf
        <button type="submit"
            class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors w-full text-left cursor-pointer bg-transparent border-0">
            <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center fill-current stroke-0 text-center xl:p-2.5">
                <svg width="12px" height="12px" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg" fill="none">
                    <path class="fill-slate-800" fill-rule="evenodd" clip-rule="evenodd"
                          d="M15,6 L5,6 C3.9,6 3,6.9 3,8 L3,32 C3,33.1 3.9,34 5,34 L15,34 L15,30 L7,30 L7,10 L15,10 Z M28,8 L22,2 L10,14 L22,26 L28,20 L22,14 Z M28,14 L37,14 L37,26 L28,26 L28,32 L40,20 L28,8 Z"
                          fill="#344767"/>
                </svg>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft text-slate-700">
                Sign Out ({{ currentStudent()->name }})
            </span>
        </button>
    </form>
</li>
@endif
<!-- ends here -->

        </ul>
      </div>
      {{-- SUPER ADMIN ONLY --}}
    @if($user && $user->role === 'super_admin')
<!-- document start here -->
      <div class="mx-4">
    <div class="after:opacity-65 after:bg-gradient-to-tl after:from-slate-600 after:to-slate-300 relative flex min-w-0 flex-col items-center break-words rounded-2xl border-0 border-solid border-blue-900 bg-white bg-clip-border shadow-none after:absolute after:top-0 after:bottom-0 after:left-0 after:z-10 after:block after:h-full after:w-full after:rounded-2xl after:content-['']"
         sidenav-card>
        <div class="mb-7.5 absolute h-full w-full rounded-2xl bg-cover bg-center"
             style="background-image: url('{{ asset('dashboard/build/assets/img/curved-images/white-curved.jpeg') }}');"></div>

        <div class="relative z-20 flex-auto w-full p-4 text-left text-white">

            {{-- Plan Badge --}}
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold uppercase tracking-wide text-white opacity-80">Current Plan</span>
                <span class="text-xs font-bold uppercase px-2 py-1 rounded-full
                    {{ $tenant->plan === 'free' ? 'bg-white text-slate-700' : 'bg-yellow-400 text-slate-900' }}">
                    {{ ucfirst($tenant->plan) }}
                </span>
            </div>

            {{-- Plan expiry if not free --}}
            @if($tenant->plan !== 'free' && $tenant->expires_at)
                <p class="text-xs text-white opacity-70 mb-3">
                    <i class="fa fa-clock mr-1"></i>
                    Expires {{ \Carbon\Carbon::parse($tenant->expires_at)->format('M d, Y') }}
                </p>
            @endif

            {{-- Upgrade CTA --}}
            @if($tenant->plan === 'free')
                <h6 class="mb-1 text-white font-bold">Upgrade Your Plan</h6>
                <p class="mt-0 mb-3 text-xs font-semibold leading-tight opacity-80">
                    Unlock unlimited students, teachers & more.
                </p>
                <a href="{{ route('tenant.billing', $subdomain) }}"
                   class="inline-block w-full px-4 py-2 mb-2 text-xs font-bold text-center text-slate-800 uppercase transition-all ease-in bg-white border-0 rounded-lg shadow-soft-md hover:shadow-soft-2xl hover:scale-102">
                    <i class="fa fa-crown mr-1 text-yellow-500"></i> Upgrade Now
                </a>
            @else
                <h6 class="mb-1 text-white font-bold">Need Support?</h6>
                <p class="mt-0 mb-3 text-xs font-semibold leading-tight opacity-80">
                    Our team is here to help you.
                </p>
            @endif

            {{-- Support & Docs --}}
            <a href="{{ route('tenant.admin.helpline.index', request()->route('subdomain')) }}"
               class="inline-block w-full px-4 py-2 mb-2 text-xs font-bold text-center text-slate-800 uppercase transition-all ease-in bg-white border-0 rounded-lg shadow-soft-md hover:shadow-soft-2xl hover:scale-102">
                <i class="fa fa-headset mr-1 text-blue-500"></i> Contact Support
            </a>

            <a href="#"
               class="inline-block w-full px-4 py-2 text-xs font-bold text-center text-white uppercase transition-all ease-in bg-transparent border border-white rounded-lg hover:bg-white hover:text-slate-800">
                <i class="fa fa-book mr-1"></i> Read Docs
            </a>

        </div>
    </div>
</div>
@endif


 {{-- teacher and student --}}
    
<!-- Teacher & Student Card -->
<div class="mx-4">
        <!-- load phantom colors for card after: -->
        <p
          class="invisible hidden text-gray-800 text-red-500 text-red-600 after:bg-gradient-to-tl after:from-gray-900 after:to-slate-800 after:from-blue-600 after:to-cyan-400 after:from-red-500 after:to-yellow-400 after:from-green-600 after:to-lime-400 after:from-red-600 after:to-rose-400 after:from-slate-600 after:to-slate-300 text-lime-500 text-cyan-500 text-slate-400 text-fuchsia-500"></p>
        <div
          class="after:opacity-65 after:bg-gradient-to-tl after:from-slate-600 after:to-slate-300 relative flex min-w-0 flex-col items-center break-words rounded-2xl border-0 border-solid border-blue-900 bg-white bg-clip-border shadow-none after:absolute after:top-0 after:bottom-0 after:left-0 after:z-10 after:block after:h-full after:w-full after:rounded-2xl after:content-['']"
          sidenav-card>
          <div
            class="mb-7.5 absolute h-full w-full rounded-2xl bg-cover bg-center"
            style="background-image: url('{{ asset('dashboard/build/assets/img/curved-images/white-curved.jpeg') }}');"></div>
            
          <div class="relative z-20 flex-auto w-full p-4 text-left text-white">
            <div
              class="flex items-center justify-center w-8 h-8 mb-4 text-center bg-white bg-center rounded-lg icon shadow-soft-2xl">
              <i class="fa fa-chalkboard-user mr-1"></i> 
            </div>
            <div class="transition-all duration-200 ease-nav-brand">
              <h6 class="mb-0 text-white">Need help?</h6>
              <p class="mt-0 mb-4 text-xs font-semibold leading-tight">
                Please contact your school
              </p>
              <a
                href="#"
                class="inline-block w-full px-8 py-2 mb-0 text-xs font-bold text-center text-black uppercase transition-all ease-in bg-white border-0 border-white rounded-lg shadow-soft-md bg-150 leading-pro hover:shadow-soft-2xl hover:scale-102"
                >Adminitrator</a
              >
            </div>
          </div>
        </div>
      </div>
<!-- document ends here -->
    </aside>

    <!-- end sidenav -->


