<footer id="footer">
    <div class="container">
        <div class="row">

            <div id="ft_bottom_separator" class="col-sm-12 text-center bottom-separator">
                <img src="images/home/under.png" class="img-responsive inline" alt="">
            </div>
            <div class="col-xs-12">
                <div class="row" >
                    
                    <div class="col-md-6 col-sm-6">
                        <h1>Empieza a optimizar  tu restaurante gratis</h1>
                        <p style="font-size: 1.3em;"> Sin tiempo límite. Sin tarjetas de crédito requeridas.</p>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="contact-form bottom" style="margin-top:2.5rem;">
                            
                                <div class="form-group">
                                    <div class="input-group" style="display:table;">
                                        
                                        <input id="empieza-mail" type="text" name="name" class="form-control" required="required" placeholder="Ingresa tu correo">
                                        <span class="input-group-btn">
                                            <a class="btn btn-common btn-cta-landing-main form-control" style="" type="button" onclick="window.location.replace('register/'+$('#empieza-mail').val() )" >Empieza gratis</a>
                                        </span>
                                    </div>  
                                </div>
                                {{--<div class="form-group">
                                    <input type="email" name="email" class="form-control" required="required" placeholder="Email Id">
                                </div>
                                <div class="form-group">
                                    <textarea name="message" id="message" required="required" class="form-control" rows="8" placeholder="Your text here"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" class="btn btn-submit" value="Submit">
                                </div>--}}
                           
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <div id="ft_line_separator" class="col-sm-12 text-center line-separator">
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-md-6 ">
                        <h2>Contacto</h2>
                        <address>
                            E-mail: <a href="mailto:ventas@gal-da.com" style="color: #595959; font-weight: 900">ventas@gal-da.com</a> <br>
                            Celular: +51 976 009 012 <br>
                        </address>
                        <h2>Centro de Ayuda</h2>
                        <address>
                            <a href="{{route('helpCenter')}}" style="color: #595959; font-weight: 900">Ir al Centro de Ayuda <br></a>
                        </address>
                    </div>
                    {{--/*
                     <div class="col-md-6">
                        <h2>Dirección</h2>
                        <address>
                            Prolongación la castellana 1314, <br>
                            Surco, <br>
                            Lima, 15023 <br>
                            Perú <br>
                        </address>
                    </div>
                    */--}}
                    <div class="col-md-6">
                        <h2>Dirección</h2>
                        <address>
                            Lima, Perú <br>
                            Santiago de Surco <br>
                        </address>
                    </div>
                </div>
            </div>
            

            <div class="col-sm-12">
                <div class="copyright-text text-center">
                    <p>&copy; Gal-Da 2019. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--/#footer-->