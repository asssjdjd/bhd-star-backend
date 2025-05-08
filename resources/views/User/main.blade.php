<!DOCTYPE html>
<html lang="en">

@include('User.layouts.head')
@yield('styles')

<body>
    <div class="wrapper" style="width: 100%;">

        {{-- narbar --}}
        @include('User.layouts.navbar')

        <!-- slide-header -->
        {{-- @include('User.layouts.slide-header') --}}
        @if(Route::current() && Route::current()->getName() == 'home')
            @include('User.layouts.slide-header')
        @endif

        <!-- main -->
        <div class="main mt-5" style="width: 100%;">
           @yield('content')
        </div>

        <!-- footer -->
        @include('User.layouts.footer')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="{{asset('asset/js/main.js')}}"></script>
    <script src ="{{asset('asset/js/swiper.js')}}"></script>
    @yield('scripts') 
    
    
</body>
</html>