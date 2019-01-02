<?php

    Breadcrumbs::register('', function ($breadcrumbs) {
        $breadcrumbs->push('', route('home'));  
    });

    Breadcrumbs::register('inicio', function ($breadcrumbs) {
        if( \Auth::user()->plan_id == 1)
        $breadcrumbs->push('Inicio', route('tableroF'));
        else
        $breadcrumbs->push('Inicio', route('tablero'));
    });

    Breadcrumbs::register('apercaja', function ($breadcrumbs) {
        $breadcrumbs->parent('inicio');
        $breadcrumbs->push('Apertura y Cierre de Caja', route('apercaja'));
    });

    Breadcrumbs::register('egrcaja', function ($breadcrumbs) {
        $breadcrumbs->parent('inicio');
        $breadcrumbs->push('Egresos de caja', route('egrcaja'));
    });
    
    Breadcrumbs::register('ingcaja', function ($breadcrumbs) {
        $breadcrumbs->parent('inicio');
        $breadcrumbs->push('Ingresos de caja', route('ingcaja'));
    });

    Breadcrumbs::register('compras', function ($breadcrumbs) {
        $breadcrumbs->parent('inicio');
        $breadcrumbs->push('Compras', route('compras'));
    });

    Breadcrumbs::register('proveedores', function ($breadcrumbs) {
        $breadcrumbs->parent('inicio');
        $breadcrumbs->push('Proveedores', route('proveedores'));
    });

    Breadcrumbs::register('nproveedor', function ($breadcrumbs) {
        $breadcrumbs->parent('inicio');
        $breadcrumbs->push('Nuevo Proveedor', route('NuevoProveedor'));
    });

    Breadcrumbs::register('eproveedor', function ($breadcrumbs) {
        $breadcrumbs->parent('inicio');
        $breadcrumbs->push('Editar Proveedor');
    });

    Breadcrumbs::register('clientes', function ($breadcrumbs) {
        $breadcrumbs->parent('inicio');
        $breadcrumbs->push('Clientes', route('clientes'));
    });
    
    Breadcrumbs::register('ncliente', function ($breadcrumbs) {
        $breadcrumbs->parent('clientes');
        $breadcrumbs->push('Nuevo Cliente', route('cucliente'));
    });

    Breadcrumbs::register('ecliente', function ($breadcrumbs) {
        $breadcrumbs->parent('clientes');
        $breadcrumbs->push('Editar Cliente', route('cucliente'));
    });

    Breadcrumbs::register('pedidos', function ($breadcrumbs) {
        $breadcrumbs->parent('inicio');
        $breadcrumbs->push('Pedidos', route('produccion'));
    });

    Breadcrumbs::register('creditosCompra', function ($breadcrumbs) {
        $breadcrumbs->parent('inicio');
        $breadcrumbs->push('Créditos');
        $breadcrumbs->push('Compras', route('creditosCompra'));
    });    
    //Informes
    Breadcrumbs::register('informes', function ($breadcrumbs) {
        $breadcrumbs->parent('inicio');
        $breadcrumbs->push('Informes',route('config.Informes'));
    });

    Breadcrumbs::register('inf_compras', function ($breadcrumbs) {
        $breadcrumbs->parent('informes');
        $breadcrumbs->push('Compras',route('inf_compras'));
    });
    Breadcrumbs::register('inf_proveedores', function ($breadcrumbs) {
        $breadcrumbs->parent('informes');
        $breadcrumbs->push('Proveedores',route('inf_proveedores'));
    });
    Breadcrumbs::register('inf_kardex', function ($breadcrumbs) {
        $breadcrumbs->parent('informes');
        $breadcrumbs->push('Kárdex',route('inf_kardex'));
    });
    Breadcrumbs::register('inf_apercaja', function ($breadcrumbs) {
        $breadcrumbs->parent('informes');
        $breadcrumbs->push('Apertura y Cierre de Caja',route('inf_apercaja'));
    });
    Breadcrumbs::register('inf_ingcaja', function ($breadcrumbs) {
        $breadcrumbs->parent('informes');
        $breadcrumbs->push('Todos los ingresos',route('inf_ingcaja'));
    });
    Breadcrumbs::register('inf_remu', function ($breadcrumbs) {
        $breadcrumbs->parent('informes');
        $breadcrumbs->push('Egresos por remuneración',route('inf_remu'));
    });
    Breadcrumbs::register('inf_egrcaja', function ($breadcrumbs) {
        $breadcrumbs->parent('informes');
        $breadcrumbs->push('Todos los egresos',route('inf_egrcaja'));
    });
    Breadcrumbs::register('inf_fpago', function ($breadcrumbs) {
        $breadcrumbs->parent('informes');
        $breadcrumbs->push('Formas de Pago',route('inf_fpago'));
    });
    Breadcrumbs::register('inf_mozos', function ($breadcrumbs) {
        $breadcrumbs->parent('informes');
        $breadcrumbs->push('Ventas por Mesero',route('inf_mozos'));
    });
    Breadcrumbs::register('inf_productos', function ($breadcrumbs) {
        $breadcrumbs->parent('informes');
        $breadcrumbs->push('Ventas por productos',route('inf_productos'));
    });
    Breadcrumbs::register('inf_ventas', function ($breadcrumbs) {
        $breadcrumbs->parent('informes');
        $breadcrumbs->push('Todas las Ventas',route('inf_ventas'));
    });

    //Ajustes
    Breadcrumbs::register('ajustes', function ($breadcrumbs) {
        $breadcrumbs->parent('inicio');
        $breadcrumbs->push('Ajustes',route('ajustes'));
    });    

    Breadcrumbs::register('config.Cajas', function ($breadcrumbs) {
        $breadcrumbs->parent('ajustes');
        $breadcrumbs->push('Cajas',route('config.Cajas'));
    });    

    Breadcrumbs::register('config.Almacen', function ($breadcrumbs) {
        $breadcrumbs->parent('ajustes');
        $breadcrumbs->push('Almacenes y Areas de Producción',route('config.Almacen'));
    });
    Breadcrumbs::register('config.MesasSalones', function ($breadcrumbs) {
        $breadcrumbs->parent('ajustes');
        $breadcrumbs->push('Salones Y Mesas',route('config.SalonesMesas'));
    });
    Breadcrumbs::register('config.Productos', function ($breadcrumbs) {
        $breadcrumbs->parent('ajustes');
        $breadcrumbs->push('Productos',route('config.Productos'));
    });
    Breadcrumbs::register('config.Insumos', function ($breadcrumbs) {
        $breadcrumbs->parent('ajustes');
        $breadcrumbs->push('Productos Insumos',route('config.Insumos'));
    });
    Breadcrumbs::register('config.DatosEmpresa', function ($breadcrumbs) {
        $breadcrumbs->parent('ajustes');
        $breadcrumbs->push('Datos Empresa',route('config.DatosEmpresa'));
    });
    Breadcrumbs::register('config.TiposdeDocumentos', function ($breadcrumbs) {
        $breadcrumbs->parent('ajustes');
        $breadcrumbs->push('Tipos de Documento',route('config.TiposdeDocumentos'));
    });
    //Usuario
    Breadcrumbs::register('config.Usuarios', function ($breadcrumbs) {
        $breadcrumbs->parent('ajustes');
        $breadcrumbs->push('Usuarios',route('config.Usuarios'));
    });

    Breadcrumbs::register('config.nuevo_usuario', function ($breadcrumbs) {
        $breadcrumbs->parent('config.Usuarios');
        $breadcrumbs->push('Nuevo usuario',route('config.Usuarios'));
    });

    Breadcrumbs::register('config.editar_usuario', function ($breadcrumbs) {
        $breadcrumbs->parent('config.Usuarios');
        $breadcrumbs->push('Editar usuario',route('config.Usuarios'));
    });
    //-----
    Breadcrumbs::register('config.Sucursal', function ($breadcrumbs) {
        $breadcrumbs->parent('ajustes');
        $breadcrumbs->push('Sucursales',route('config.Sucursal'));
    });
    Breadcrumbs::register('config.Turnos', function ($breadcrumbs) {
        $breadcrumbs->parent('ajustes');
        $breadcrumbs->push('Turnos',route('config.Turnos'));
    });
?>
