@extends('layouts.home.master')

@section('content')

    <section id="page-breadcrumb">
        <div class="vertical-center sun">
            <div class="container">
                <div class="row">
                    <div class="action">
                        <div class="col-sm-12">
                            <h1 class="title">Primeros Pasos</h1>
                            <p>Eres Nuevo? Nosotros te ayudamos!</p>
                        </div>
                    </div>
                </div>
                <a href="{{route('helpCenter')}}"><- Regresar</a>
            </div>
        </div>
    </section>

    <section id="shortcodes">
        <div class="container">
            <div id="accordion-container">
                <h2 class="page-header">Empecemos!</h2>
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    1. Configuraci&oacute;n de Datos de Empresa
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p class="p-help-center-justify">Antes de que empezar a realizar un Pedido con Gal-Da. Te recomendamos configurar en la Secci&oacute;n <b>Datos de Empresa</b> y completar toda la informaci&oacute;n requerida
                                    <br> Es muy importante configurar los impuestos, tipo de Moneda y entre otros.</p>
                                <br><br>

                                <div>
                                    <img style="margin-left: 30%;" src="https://media.giphy.com/media/w85OXBYiljzy1PWFDk/giphy.gif" alt="Datos Empresa" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                    2. Crear Usuarios
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p class="p-help-center-justify">
                                    <b>Estas listo para crear usuarios que har&aacute;n de tu negocio un lugar eficiente?.</b> Te invitamos a crear usuarios que desees en base al Perfil predetermindado que Gal-Da tiene como :
                                    <br>('<b>Cocinero</b>', '<b>Administrador</b>', '<b>Cajero</b>', '<b>Mozo</b>' y '<b>Multimozo</b>').
                                </p>
                                <p class="p-help-center-justify" >
                                    Crea todos los usuarios en base al Plan que tienes.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                    3. Crear Productos y Categor&iacute;as
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p class="p-help-center-justify">
                                   Es momento de Crear Productos!.
                                    <br>Para tus Productos primero creamos todas las Categorias que deseemoss. Como ('Bebidas','Grasas' y todo lo que tu negocio pueda brindar).<br>
                                    <br>Ahora a&ntilde;adale sus precios correspondientes o como en Gal-Da lo llamamos <b>"Presentaciones"</b>.

                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                                    4. Crear Insumos y Categor&iacute;as
                                </a>
                            </h4>
                        </div>
                        <div id="collapse4" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p class="p-help-center-justify">
                                    Es momento de Crear Insumos!.
                                    <br>Para tus Insumos crea todas las Categorias que desees. Como ('Carnes','Verduras' y todo lo que tu negocio pueda almacenar).<br>
                                    <br>Puedes controlarlo como parte de tu Stock y administrar tu Kardex mas adelante.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
                                    5. Configurar Caja
                                </a>
                            </h4>
                        </div>
                        <div id="collapse5" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p class="p-help-center-justify">
                                    Necesitamos aperturar una Caja para poder realizar pedidos!.
                                    <br>En Gal-Da, te brindamos una Caja gratis. En la cual lo usaras para Aperturar y/o Cerrar una Caja.
                                    <br><br>

                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">
                                    6. Configurar Sal&oacute;n y Mesas
                                </a>
                            </h4>
                        </div>
                        <div id="collapse6" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p class="p-help-center-justify">
                                    Ahora crearemos Salones para poder luego colocar las mesas.
                                    <br>
                                    <br>Podemos ver como se reflejan en la vista de Pedidos.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse7">
                                    7. Realizar un pedido
                                </a>
                            </h4>
                        </div>
                        <div id="collapse7" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p class="p-help-center-justify">
                                    Realiaremos un Pedido..
                                    <br><br>

                                </p>
                            </div>
                        </div>
                    </div>
                </div><!--/#accordion-->
            </div><!--/#accordion-container-->

            <div class="padding"></div>

        </div>
    </section>

@endsection('content')