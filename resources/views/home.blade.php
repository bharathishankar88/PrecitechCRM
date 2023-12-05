@extends('layouts.master')
@include('navbar.header')
@section('content')
@include('sidebar.dashboard')
<link rel="stylesheet" href="{{URL::to('assets/css/profile.css')}}">
              
<main class="col bg-faded py-3 flex-grow-1">
    <h3>Dashboard</h3>
    <br>
    
		@csrf
        <div class="container">
            <form action="{{ route('home/save') }}" method ="GET">
			    <div class="row">
				    <div class="container-fluid">                    
                        <div class="form-group row">
                          
							<div class="col-sm-2">
                            <input type="date" class="form-control input-sm" id="fromdate" name="fromdate" placeholder="from" required >
							</div>
                            
                            <div class="col-sm-2">
                            <input type="date" class="form-control input-sm" id="todate" name="todate" required>
							</div>
                            <!--<div class="col-sm-2">
                            <label for="date" class="col-form-label col-sm-2">Machine</label>
                            </div>-->
                            <div class="col-sm-2">
                            <input type="text" class="form-control input-sm" id="machine" name="machine" placeholder ="Machine">
							</div>
                            <div class="col-sm-2">
								<button type="submit" class="btn" name="search" title="Search"><img src="https://img.icons8.com/android/24/000000/search.png"/></button>
							</div>
                            
						</div>
                    </div>
                </div>
            </form>
                
                <!--<h2>PROFILE PHOTO</h2>-->
                
                <!--<div id="myCarousel" class="carousel slide" data-ride="carousel">
                    
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                    </ol>   
                    
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="img-box"><img src="/assets/image/logo.png" alt=""></div>
                            <p class="testimonial">The rawmaterial xxx have less than 500 kg</p>
                            <p class="overview"><b>Please Refill the stock</b>, Admin</p>
                        </div>
                        <div class="carousel-item">
                            <div class="img-box"><img src="/assets/image/logo.png" alt=""></div>
                            <p class="testimonial">Vestibulum quis quam ut magna consequat faucibus. Pellentesque eget nisi a mi suscipit tincidunt. Utmtc tempus dictum risus. Pellentesque viverra sagittis quam at mattis. Suspendisse potenti. Aliquam sit amet gravida nibh, facilisis gravida odio.</p>
                            <p class="overview"><b>Antonio Moreno</b>, Web Developer</p>
                        </div>
                        <div class="carousel-item">
                            <div class="img-box"><img src="/assets/image/logo.png" alt=""></div>
                            <p class="testimonial">Phasellus vitae suscipit justo. Mauris pharetra feugiat ante id lacinia. Etiam faucibus mauris id tempor egestas. Duis luctus turpis at accumsan tincidunt. Phasellus risus risus, volutpat vel tellus ac, tincidunt fringilla massa. Etiam hendrerit dolor eget rutrum.</p>
                            <p class="overview"><b>Michael Holz</b>, Seo Analyst</p>
                        </div>-->
          



                        
                        
    </div>
                   
   
        <br><br><br>                
<div class="container">
  <div class="row">
    <div class="col-sm">
    
    </div>
    <div class="col-sm">
    <canvas id="chart1"></canvas>
    <br>
    Displaying production percentage for the period from {{ date('d-m-Y', strtotime($fromdate))  }} to {{ date('d-m-Y', strtotime($todate))  }}
    </div>
    <div class="col-sm">
      
    </div>
  </div>
</div>
    
                    <!-- Carousel controls -->
                    <!--<a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a class="carousel-control-next" href="#myCarousel" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>-->
        
    <script>
        var ctx = document.getElementById('chart1').getContext('2d');
        var userChart = new Chart(ctx,{
            type:'bar',
            data:{
                labels: {!! json_encode($labels)!!},
                datasets: {!! json_encode($datasets)!!}
            },
        });
    </script>
</main>
@endsection