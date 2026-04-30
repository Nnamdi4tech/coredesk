<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="apple-touch-icon"
      sizes="76x76"
      href="{{ asset('dashboard/build/assets/img/apple-icon.png') }}" /> 
    <link rel="icon" type="image/png" href="{{ asset('dashboard/build/assets/img/favicon.png') }}" />     
    <title>CoreDesk Dashboard</title>
    <!-- Fonts and icons -->
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"
      rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script
      src="https://kit.fontawesome.com/42d5adcbca.js"
      crossorigin="anonymous"></script>

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('dashboard/build/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard/build/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Popper -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    
    <!-- Main Styling -->
    <link
      href="{{ asset('dashboard/build/assets/css/soft-ui-dashboard-tailwind.css?v=1.0.5') }}"   
      rel="stylesheet" />
  </head>

  <body
    class="m-0 font-sans text-base antialiased font-normal leading-default bg-gray-50 text-slate-500">
    <!-- sidenav start here -->
     @include('layouts.sidebar')

     <!-- end sidenav -->


     <main
      class="ease-soft-in-out xl:ml-68.5 relative h-full max-h-screen rounded-xl transition-all duration-200">
      <!-- Navbar start here-->
       @include('layouts.navbar')
    
      <!-- end Navbar -->

      <!-- cards -->
       
       
      <div class="w-full px-6 py-6 mx-auto">
        @yield('content') <!-- this is where my admin template goes into -->
        <!-- row 1 start here-->
        
         
        <!-- row 1 ends here-->
        
           

        <!-- cards row 2 start here-->
        
        <!-- ends here -->




        <!-- cards row 3 start here -->

        <!--  cardrow3 ends here -->





        <!-- cards row 4 start here -->

        <!-- cardrow4 ends here -->

        <!-- footer start here -->
         @include('layouts.footer')

        <!-- footer ends here -->
      </div>
      <!-- end cards -->
    </main>

    <!-- plugin static setting icon start here -->
    <!-- ends here -->
  </body>
  
<script src="{{ asset('dashboard/build/assets/js/plugins/chartjs.min.js') }}"></script>
<script src="{{ asset('dashboard/build/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('dashboard/build/assets/js/soft-ui-dashboard-tailwind.js?v=1.0.5') }}"></script>
</html>
 

