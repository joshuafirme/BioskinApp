@php
$page_title = 'Contact Us | Bioskin';
$categories = Utils::readCategories();
$data = json_decode(Cache::get('cache_contact_us'),true);
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
                    <div></div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="row pl-3 pr-3 pt-1 pb-1 category-container justify-content-center"
        style="margin-top: 11px; background-color: #EFF6EC;">
        @foreach ($categories as $item)
            <a class="p-1 ml-3 mr-3 text-center" href="{{ url('/shop/category/' . $item->id) }}">
                <div class="text-muted category-name" data-id="{{ $item->id }}" data-name="{{ $item->name }}">
                    {{ $item->name }}</div>
            </a>
        @endforeach

    </div>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-12">
                <div class="wrapper">
                    <div class="row mb-5">
                        <div class="col-md-4">
                            <div class="dbox w-100 text-center">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="fa fa-map-marker"></span>
                                </div>
                                <div class="text">
                                    <p> {{isset($data['location']) ? $data['location'] : ""}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dbox w-100 text-center">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="fa fa-phone"></span>
                                </div>
                                <div class="text">
                                    <p><span> {{isset($data['phone_number']) ? $data['phone_number'] : ""}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dbox w-100 text-center">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="fa fa-paper-plane"></span>
                                </div>
                                <div class="text">
                                    <p><a href="mailto: {{isset($data['email']) ? $data['email'] : ""}}" target="_blank"><span>{{isset($data['email']) ? $data['email'] : ""}}
                                            </span></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="contact-wrap w-100 p-md-5 p-4">
                                <h3 class="mb-2">Contact Us</h3>
                                <div id="form-message-warning" class="mb-4"></div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="label" for="name">Full Name</label>
                                                <input type="text" class="form-control" name="name" id="name"
                                                    placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group required">
                                                <label class="label" for="email">Email Address</label>
                                                <input type="email" class="form-control" name="email" id="email"
                                                    placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label" for="subject">Subject</label>
                                                <input type="text" class="form-control" name="subject" id="subject"
                                                    placeholder="Subject">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group required">
                                                <label class="label" for="#">Message</label>
                                                <textarea name="message" class="form-control" id="message" cols="30"
                                                    rows="4" placeholder="Message"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="submit" value="Send Message" id="btn-send-mail" class="btn btn-primary">
                                                <div class="submitting"></div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex align-items-stretch">
                            <img src="{{ asset('images/'.$data['image']) }}" alt=""
                                class="img-fluid mb-3 d-none d-md-block">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.content-wrapper -->

@include('footer')

<script>
    $(function() {
        $(document).on('click', '#btn-send-mail', function(){
            let btn = $(this);
            btn.html("Please wait...");
            btn.prop('disabled', true);

            let name = $('#name').val();
            let email = $('#email').val();
            let subject = $('#subject').val();
            let message = $('#message').val();
            
            $.ajax({
            url: '/contact-us/send-mail',
            type: 'POST',
            data: {
                name: name,
                email: email,
                subject: subject,
                message: message
            },
            success:function(data){ 
                data = JSON.parse(data);
                setTimeout(() => { 
                    if (data.response == "field_required") {
                        btn.prop('disabled', false);
                        $('#form-message-warning').html('<p class="text-danger">Please enter the required fields.</p>')
                        return;
                    }
                    btn.remove();
                    $('#form-message-warning').html('<p class="text-success">Your message was successfully sent!</p>')
                }, 300);
            }
        });
        });
    })
</script>
