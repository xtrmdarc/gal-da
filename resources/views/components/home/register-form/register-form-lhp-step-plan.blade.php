<div class="background-gray-auth register-form-step-plan {{ $class_active or '' }}">


    <h1 {!! Route::currentRouteName() == 'prices' ? '' : 'style="display: none;"' !!} class="title_plan">Seleccion tu Plan</h1>

    <div class="price-table">
        <div class="row pricing-table">


                <div class="card-pricing col-sm-6 col-md-6">
                    <div class="single-price price-one">
                        <div class="table-heading">
                            <p class="plan-name">Free Plan</p>
                            <p class="plan-price"><span class="dollar-sign">$</span><span class="price">0</span><span class="month">/ for ever</span></p>
                        </div>
                        <ul>
                            <li>Lorem ipsum dolor <span><i class="fa fa-check"></i></span></li>
                            <li>Consectetur adipiscing <span><i class="fa fa-times"></i></span></li>
                            <li>Nulla pellentesque <span><i class="fa fa-times"></i></span> </li>
                            <li> Integer quis risus <span><i class="fa fa-check"></i></span></li>
                            <li>Phasellus et metus <span><i class="fa fa-times"></i></span></li>
                            <li>Duis nec massa inter <span><i class="fa fa-check"></i></span></li>
                        </ul>
                        <input type="hidden" name="plan_id" value="1" />
                        <button id="btn-register-payment-free" type="button" class="btn btn-buynow" style="width: 100%;">Buy Now</button>
                    </div>
                </div>

            <div style="display: none">
                <form method="POST" action="">
                    {{ csrf_field() }}
                    <div class="card-pricing col-sm-6 col-md-6">
                        <div class="single-price price-two">
                            <div class="table-heading">
                                <p class="plan-name">Lite Plan</p>
                                <p class="plan-price"><span class="dollar-sign">$</span><span class="price">80</span><span class="month">/ Month</span></p>
                            </div>
                            <ul>
                                <li>Lorem ipsum dolor <span><i class="fa fa-check"></i></span></li>
                                <li>Consectetur adipiscing <span><i class="fa fa-times"></i></span></li>
                                <li>Nulla pellentesque <span><i class="fa fa-times"></i></span> </li>
                                <li> Integer quis risus <span><i class="fa fa-check"></i></span></li>
                                <li>Phasellus et metus <span><i class="fa fa-times"></i></span></li>
                                <li>Duis nec massa inter <span><i class="fa fa-check"></i></span></li>
                            </ul>
                            <input type="hidden" name="plan-id" value="2" />
                            <button type="submit" class="btn btn-buynow" style="width: 100%;">Buy Now</button>
                        </div>
                    </div>
                </form>
            </div>


            {{--/*<div class="col-sm-6 col-md-3">
                <div class="single-price price-three">
                    <div class="table-heading">
                        <p class="plan-name">Glod Plan</p>
                        <p class="plan-price"><span class="dollar-sign">$</span><span class="price">29</span><span class="month">/ Month</span></p>
                    </div>
                    <ul>
                        <li>Lorem ipsum dolor <span><i class="fa fa-check"></i></span></li>
                        <li>Consectetur adipiscing <span><i class="fa fa-times"></i></span></li>
                        <li>Nulla pellentesque <span><i class="fa fa-times"></i></span> </li>
                        <li> Integer quis risus <span><i class="fa fa-check"></i></span></li>
                        <li>Phasellus et metus <span><i class="fa fa-times"></i></span></li>
                        <li>Duis nec massa inter <span><i class="fa fa-check"></i></span></li>
                    </ul>
                    <a href="#" class="btn btn-buynow">Buy Now</a>
                </div>
            </div>*/--}}
        </div>
    </div>
</div>