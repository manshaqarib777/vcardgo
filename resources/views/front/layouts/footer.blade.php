<!-- start subscribe section -->
<section class="subscribe-section padding-t-100px padding-b-100px">
    <div class="container">
        <div class="subscribe-section__subscribe-inner position-relative rounded-20">
            <div class="position-relative subscribe-section__subscribe-block text-center mx-auto">
                <h2 class="text-white">{{__('auth.subscribe_here')}}</h2>
                <p class="text-blue-100 fs-18">
                    Receive latest news, update, and many other things every week.
                </p>
                <form action="{{route('email.sub')}}" method="post" id="addEmail">
                    @csrf()
                    <div class="subscribe-inputgrp position-relative">
                        <input name="email" type="email" class="form-control" placeholder="{{ __('messages.front.your_email_address') }}">
                        <div class="subscribe-btn d-flex align-items-center">
                            <button type="submit" class="btn btn-primary">{{ __('messages.subscribe') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- end subscribe section -->


<!-- start footer section -->
<footer>
    <div class="container text-center">
        <p class="mb-0 text-gray-100">©  <script>document.write(new Date().getFullYear())</script>
            {{__('auth.copyright_by')." "}} <span class="text-success">{{ $setting['app_name'] }}</span></p>
    </div>
</footer>
<!-- end footer section -->

