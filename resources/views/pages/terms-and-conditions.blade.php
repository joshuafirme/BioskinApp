@php
  $page_title =  "Terms and Conditions | Bioskin";
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
        <div class="card mt-5 p-3">
          <b class="text-center">PRIVATE LABEL TERMS AND CONDITIONS</b>
          <ol>
              <li><b>Job order</b> <p>All details in the Job Order form are checked by customer and are verified correct. All details are deemed final and no changes shall be honored.
                For customized orders of 500pcs and up, a small batch production shall be conducted prior 	the bulk production to ensure that final product have met customer's expectation.</p>
                <p>For generic and Bioskin existing products, no small batch production shall be done as it is 	expected that customer have tested and approve these existing products as well.</p>
                </li>
                <li><b>Mode of Payment</b> <p>It is company policy that the customer shall pay 80% Down Payment and 20% payment of balance prior delivery of Product.</p></li>

                <li><b>Stock Return</b> <p>Bioskin entitles the customer to return defective products within 7days upon receipt of the items. Shipping cost shall be shouldered by Bioskin if investigation showed that defect is factory-related and replacement of product shall be processed minimum of 7 days depending on the concern/issue.</p></li>
	
                <li><b>Product Delivery</b> <p>All products purchased by the customer is FOB Davao (Bioskin Head Office). All shipping costs and delivery charges shall be shouldered by Customer but may be assisted/faciliated by Bioskin.</p></li>

                <li><b>Leadtime</b> <p>After the checking the availability of materials, the products are to be delivered to customer on ________________________________________. Kindly take note that this will vary depending on the delivery of customer owned materials (if applicable). Customer shall also be required to proof read sticker label intended for his ordered products. Label Approval Form shall be received and signed by customer.</p></li>

                <li><b>Cancellation</b> <p>Cancellation shall only be allowed without charges two (2) days after the Job Order has been approved by Customer. Afterwhich, a 40% cancellation fee or actual computed cost (whichever is higher) shall be deducted. This is to cover the actual cost incurred for the processing, possible production of the product itself.</p></li>

                <li><b>Materials provided by customer</b><p>The customer may request to provide specific active ingredient or packaging materials of his/her preference. However, it is highly advised that these materials are immediately provided to Bioskin to avoid delay. For Packaging materials, a 10% excess or extra number is highly requested as damages during production and materials inspection may occur. Full liquidation and disclosure of quantity of damaged materials shall be reported to customer.</p></li>

                <li><b>Retention sample</b> <p>Bioskin is required to retain samples of Private Label products thus also the need for extra number of packaging materials. This will serve as basis for next production, during customer complaints and product improvement.</p></li>

                <li><b>Other Services</b> <p>Product Sampling may be requested from Bioskin. Also, Bioskin may assist customer for his FDA License to Operate (P60,000) application and so as Product Notification (6,000/product).</p></li>

          </ol>
        </div>
      </div>
  <!-- /.content-wrapper -->

@include('footer')


