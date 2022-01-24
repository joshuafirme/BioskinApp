@php
    $page_title = "Dashboard | Bioskin";
@endphp
@include('admin.header')

@include('admin.nav')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-4 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>₱{{number_format($total_sales_today,2,".",",")}}</h3>
                  <p>Total sales today</p>
                </div>
                <div class="icon">
                  <i class="ion ion-cash"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$orders_today_count}}</h3>
                    <p>Orders today</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{$users_count}}</h3>
                  <p>Total user registrations</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->

          <div class="col-sm-12 col-md-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Sales</h3>
                
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">₱18,230.00</span>
                    <span>Sales Over Time</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 33.1%
                    </span>
                    <span class="text-muted">Since last month</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="240"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> This year
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Last year
                  </span>
                </div>
              </div>
            </div>
          </div>

          

          <div class="col-sm-12 col-md-6">
            
            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Best Selling Products this month</h3>
             <!--   <div class="card-tools">
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a>
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-bars"></i>
                  </a>
                </div>-->
              </div>
              <div class="card-body table-responsive p-0" style="height:400px;">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty Sold</th>
                    <th>Sales</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($best_selling as $item)
                  <tr>
                    @php
                        $src = Utils::readImage($item->sku);
                    @endphp
                    <td width="45%">
                      <img src="{{asset($src)}}" alt="Product 1" class="img-circle img-size-32 mr-2">
                      {{$item->name}} {{$item->size}}
                    </td>
                    <td>₱{{$item->price}}</td>
                    <td>{{number_format($item->total_qty, 0, '', ',')}}</td>
                    <td>
                      ₱{{number_format($item->total_sales, 2, '.', ',')}} Sold
                    </td>
                  </tr>                      
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  

  @include('admin.footer')

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
  <script>
  $(function(){
    'use strict'

    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
    }

    var mode = 'index';
    var intersect = true;

    var $salesChart = $('#sales-chart')

    $.ajax({
            url: '/dashboard/salesoverview',
            type: 'GET',
            success:function(data){  
              data = JSON.parse(data);
            
              var salesChart = new Chart($salesChart, {
              type: 'bar',
              data: {
                labels: ['JAN','FEB','MAR', 'APR','MAY','JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
                datasets: [
                  {
                    backgroundColor: '#007bff',
                    borderColor: '#007bff',
                    data: data.total_sales
                  },
                  {
                    backgroundColor: '#ced4da',
                    borderColor: '#ced4da',
                    data: data.total_sales_last_yr
                  }
                ]
              },
              options: {
                maintainAspectRatio: false,
                tooltips: {
                  mode: mode,
                  intersect: intersect
                },
                hover: {
                  mode: mode,
                  intersect: intersect
                },
                legend: {
                  display: false
                },
                scales: {
                  yAxes: [{
                    // display: false,
                    gridLines: {
                      display: true,
                      lineWidth: '4px',
                      color: 'rgba(0, 0, 0, .2)',
                      zeroLineColor: 'transparent'
                    },
                    ticks: $.extend({
                      beginAtZero: true,

                      // Include a dollar sign in the ticks
                      callback: function (value) {
                        if (value >= 1000) {
                          value /= 1000
                          value += 'k'
                        }

                        return '₱' + value
                      }
                    }, ticksStyle)
                  }],
                  xAxes: [{
                    display: true,
                    gridLines: {
                      display: false
                    },
                    ticks: ticksStyle
                  }]
                }
              }
            })
            }
        });

  })
  </script>