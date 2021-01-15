<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
| 
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller']         = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override']               = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes']       = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['session']                     		  = 'c_login/session';
$route['check']                               = 'c_session/checkSession';

if(!in_array($_SERVER['REMOTE_ADDR'], $this->config->item('maintenance_ips')) && $this->config->item('maintenance_mode')) {
	$route['default_controller'] = "c_login/maintenance";
	$route['(:any)']             = "c_login/maintenance";
} else{
	$route['default_controller'] = 'c_login/login';
}


$route['cerrar_sesion']                       = 'c_login/cerrar_sesion';
$route['log']                                 = 'c_login/log';
$route['inicio']                              = 'c_home/inicio';
$route['usuario/denegado']                    = 'c_denegado/denegado';
$route['404_override']                        = '';
$route['translate_uri_dashes']                = FALSE;
$route['perfil']                              = 'c_usuario/view_perfil';


$route['usuarios/configuracion']				= 'C_usuario/view_usuarios';
$route['usuarios/get_roles']					= 'C_usuario/get_roles';
$route['usuarios/get_usuario']					= 'C_usuario/get_usuarios';
$route['usuario/add_usu_rol']					= 'C_usuario/add_usuario';

$route['tabla_usurol/get_usuarios']				= 'C_usuario/get_usurol_sistema';
$route['usuario/get_roles']						= 'C_usuario/get_roles_json';
$route['usuario/get_organizaciones']			= 'C_usuario/get_organizaciones_json';

$route['usuario/get_usuorg']					= 'C_usuario/get_organizaciones_usuario';
$route['usuario/get_roluser']					= 'C_usuario/get_rol_usuario';

$route['usuario/upd_rol_usuario']				= 'C_usuario/upd_rol_usuario';
/*proveedor*/

$route['proveedor/registrar']					= 'C_proveedor/view_registrar';
$route['proveedor/listado']						= 'C_proveedor/view_todo';
$route['proveedor/get_vendors']					= 'C_proveedor/get_vendors';
$route['proveedor/add']							= 'C_proveedor/add';
$route['proveedor/upd']							= 'C_proveedor/edit';
$route['proveedor/del']							= 'C_proveedor/del';
$route['proveedor/get_organizaciones_prov']		= 'C_proveedor/get_org_proveedor';
$route['proveedor/get_servicios_proveedor']		= 'C_proveedor/get_servicios_proveedor';
$route['proveedor/get_proveedores_registrados']	= 'C_proveedor/get_proveedores_registrados';
$route['proveedor/get_proveedores_by_org']		= 'C_proveedor/get_proveedores_by_org';




/*servicio*/
$route['servicio/add']							= 'C_servicio/add';
$route['servicio/registrar']					= 'C_servicio/view_registrar';
$route['servicio/listado']						= 'C_servicio/view_todo';
$route['servicio/add']							= 'C_servicio/add';
$route['servicio/del']                   		= 'C_servicio/del';
$route['servicio/edi']                   		= 'C_servicio/edit';
$route['servicio/get_servicios']                = 'C_servicio/get_servicios';

/*concepto*/
$route['concepto/registrar']					= 'C_concepto/view_registrar';
$route['concepto/listado']						= 'C_concepto/view_todo';

$route['concepto/get_medidas']					= 'C_concepto/get_medidas';
$route['concepto/get_tipos_pago']				= 'C_concepto/get_tipos_pago';

$route['concepto/add']							= 'C_concepto/add';

$route['concepto/get_cuentas_contables']		= 'C_concepto/get_cuentas_contables';
$route['concepto/upd']							= 'C_concepto/upd';

$route['concepto/editar_precio']				= 'C_concepto/editar_precio';
$route['cambio_precio/aprobacion']				= 'C_concepto/view_aprobacion_solicitud';

$route['solicitud/aprobar']						= 'C_concepto/aprobar_cambio';
$route['solicitud/rechazar']					= 'C_concepto/rechazar_cambio';


$route['concepto/get_historial']				= 'C_concepto/get_historial_concepto';
$route['evento/view_eventos']					= 'C_eventos/view_eventos';
$route['evento/get_conceptos_by_servicio']		= 'C_eventos/get_conceptos_by_servicio';
$route['evento/registrar_evento']				= 'C_eventos/registrar_evento';
$route['eventos/buscador']						= 'C_eventos/view_todo';
$route['eventos/ver_evento/(:num)']				= 'C_eventos/ver_evento/$1';
$route['eventos/get_eventos']					= 'C_eventos/get_eventos';
$route['evento/eliminar']						= 'C_eventos/del_elemento';



/*apertura de mes*/
$route['apertura/mensual']						= 'C_apertura/view_registrar';
$route['apertura/add']							= 'C_apertura/add';
$route['apertura/cierre']						= 'C_apertura/cierre';
$route['apertura/edit']							= 'C_apertura/edit';
$route['apertura/get_apertura_mes']				= 'C_apertura/get_apertura_mes';



/*ajustes*/
$route['ajustes/registrar']						= 'C_ajustes/view_registrar';
$route['ajustes/listado']						= 'C_ajustes/view_todo';
$route['ajustes/get_ajustes']					= 'C_ajustes/get_ajustes';
$route['ajuste/registrar_ajuste']				= 'C_ajustes/add_ajuste';
$route['ajustes/ver_ajuste/(:num)']				= 'C_ajustes/ver_ajuste/$1';
$route['ajustes/del']							= 'C_ajustes/del';



/*pre-factura*/
$route['prefactura/informe']					= 'C_prefactura/view_prefactura';
$route['prefactura/get_proveedores_orgs']		= 'C_prefactura/get_proveedores_org';
$route['prefactura/get_servicios_proveedor']	= 'C_prefactura/get_servicios_pro';
$route['prefactura/get_informe_pre']			= 'C_prefactura/get_informe_pre';

$route['prefactura/agregar']					= 'C_prefactura/agregar';
$route['prefactura/aprobacion']					= 'C_prefactura/view_listado';
$route['prefactura/get_prefacturas']			= 'C_prefactura/get_prefacturas';

$route['prefactura/ver_prefactura/(:num)']		= 'C_prefactura/ver_prefactura/$1';

$route['prefactura/rechazar']					= 'C_prefactura/rechazar_prefactura';
$route['prefactura/aprobar']					= 'C_prefactura/aprobar_prefactura';




/*mantenedores mensuales por periodos*/

$route['mantenedor_datos/registrar']			= 'C_datos_periodo/view_registrar';
$route['mantenedor_datos/get_datos_org']		= 'C_datos_periodo/get_datos_org';
$route['mantenedor_datos/ingresar']				= 'C_datos_periodo/ingresar';
$route['mantenedor_datos/editar']				= 'C_datos_periodo/editar';

$route['mantenedor_datos/elimnar_registro']		= 'C_datos_periodo/eliminar_registro';

/*informe tableau*/
$route['tableau/informe']		= 'C_tableau/inicio';
