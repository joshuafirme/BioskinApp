@php
  $page_title =  "About Us | Bioskin";
  $categories = Utils::readCategories();
@endphp

@include('header')


  <!-- Navbar -->
  @include('nav')
  <!-- /.navbar -->
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div ></div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

  <div class="row pl-3 pr-3 pt-1 pb-1 category-container justify-content-center" style="margin-top: 11px; background-color: #EFF6EC;">
    @foreach ($categories as $item)
    <a class="p-1 ml-3 mr-3 text-center" href="{{ url('/shop/category/'.$item->id) }}">
           <div class="text-muted category-name"  data-id="{{ $item->id }}" 
             data-name="{{ $item->name }}" >
             {{ $item->name }}</div> 
           </a>
       @endforeach
 
     </div> 

     <div class="container">
        <div class="mt-5 mb-5">
          <div style="height:150px; background-image: url('{{asset('images/img-header.jpg')}}')" class="img-header"></div>
          <div style="margin:90px;">
            <p>Davao Bioskin Tech Laboratories Inc., with its trade name, Bioskin, started as a subsidiary company on April 2002 and started as an independent company on January 2006.</p>
            <p>We are an FDA-approved and ISO-certified toll manufacturer of skin care and beauty products which also offers a wide-range of packaging materials based in Davao City, Philippines. We provide custom formulation and contract manufacturing services. Technology transfer from lab to production, documentation, filling and assembling finished goods, production standards and quality control. We are full service manufacturer for retail, wholesalers, salons, fashion- and private label brands.</p>
            <p>We work with clients in the beauty business at every stage of their growth, including startups and small beauty brands. We develop, produce, and manufacture natural skincare products and formulations, and we do it exceptionally well. We implement quality control throughout the entire manufacturing process, from acquiring ingredients through production, to product distribution. The final product quality is tested in our own laboratories. We use production machines delivered by renowned global manufacturers. Our original, innovative formulas are based on the highest-quality ingredients from reliable providers.</p>
          </div>
        </div>
      </div>
  <!-- /.content-wrapper -->

@include('footer')


