<!-- subscription area start -->
<section class="subscription-area">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-sm-12">
                <div class="subscription-left">
                    <span>get update from our panel</span>
                    <h2>Subscribe For Updates</h2>
                </div>
            </div>
            <div class="col-md-7 col-sm-12">
                <div class="subscription-form">
                    <div class="form-wrappe">
                        <form action="{{route('subscribe')}}" method="post">
                            @csrf
                            <input type="text" name="email" placeholder="Enter Your Email Address ....">
                            <input type="submit" value="Subscribe">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- subscription area end -->