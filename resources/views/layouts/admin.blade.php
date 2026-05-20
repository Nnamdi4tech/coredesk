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

      <style>
    /* Spinner overlay styles */
.spinner-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    backdrop-filter: blur(3px);
}

.spinner {
    width: 50px;
    height: 50px;
    border: 5px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: #3b82f6;
    animation: spin 1s ease-in-out infinite;
}

.spinner-text {
    color: white;
    margin-top: 20px;
    font-size: 1rem;
    text-align: center;
}

.spinner-container {
    background: rgba(0, 0, 0, 0.9);
    padding: 30px;
    border-radius: 12px;
    text-align: center;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

</style>  
  </head>

  <body
    class="m-0 font-sans text-base antialiased font-normal leading-default bg-gray-50 text-slate-500">
    <!-- Spinner Overlay (Global) -->
    <div id="spinnerOverlay" class="spinner-overlay">
        <div class="spinner-container">
            <div class="spinner"></div>
            <div class="spinner-text">Processing... Please wait</div>
        </div>
    </div>
    
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

<script>
    // Global spinner functions
    window.showSpinner = function(text = 'Processing... Please wait') {
        const spinner = document.getElementById('spinnerOverlay');
        if (spinner) {
            const textEl = spinner.querySelector('.spinner-text');
            if (textEl) textEl.textContent = text;
            spinner.style.display = 'flex';
        }
    };
    
    window.hideSpinner = function() {
        const spinner = document.getElementById('spinnerOverlay');
        if (spinner) spinner.style.display = 'none';
    };
    
    // Auto show spinner on any form submit
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function() {
                // Find the submit button to change its text
                const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                if (submitBtn && !submitBtn.disabled) {
                    const originalHtml = submitBtn.innerHTML;
                    submitBtn.dataset.originalHtml = originalHtml;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Please wait...';
                }
                window.showSpinner('Processing... Please wait');
            });
        });
    });
</script>

</html>
 

