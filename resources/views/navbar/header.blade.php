<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="#"><img src="../../image/logo_1.png" srcset="../../image/logo_1.png 1x" width="147" height="50" alt="Precitech Turnings Logo" retina_logo_url=""></a>  		
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Collection of nav links, forms, and other content for toggling -->
    <div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
        <div class="navbar-nav ml-auto">
            <div class="navbar-form-wrapper">
            Welcome {{ Auth::user()->email }} &nbsp;&nbsp;&nbsp;
            </div>
            
            <a href="{{ route('form/logout') }}" class="nav-item nav-link"><i class="fa fa-sign-out"> Logout</i></a>
        </div>		
    </div>
</nav>