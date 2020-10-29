<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 include_once APPPATH.'/third_party/mpdf/mpdf.php';

class Pdf {
    public $pdf;

    public function __construct() {
      /**
       * Parametros para el constructor de mPDF, todos los parametros son 'casesensitive':
       * 1- Modo                Define el lenguaje y modo del documento (el lenguaje es espeficado en formato ISO en-US, es-CL, etc) y
       *                        el modo '-c' para Core Fonts o '-x' Para fuentes extras
       * 2- Formato:            Define tamaño de papel usado, las opciones son 'A4', 'Letter', 'Legal', 'Executive', 'Folio'
       * 3- Tamaño:             Setea el tamaño de letra (en puntos 'pt'), si es omitido utiliza la informacion del CSS
       * 4- Fuente:             Setea la familia de fuente para el documento, si es omitido utiliza la informacion del CSS
       * 5- lMargin:            Margen izquierdo del documento en milimetros
       * 6- rMargin:            Margen izquierdo del documento en milimetros
       * 7- tMargin:            Margen superior del documento en milimetros
       * 8- bMargin:            Margen inferior del documento en milimetros
       * 9- hMargin:            Margen header del documento en milimetros
       * 10- fMargin:           Margen footer del documento en milimetros
       * 11- Orientacion:       Orientacion de la pagina, las opciones son 'L' y 'P', por defecto se utiliza 'P' (Vertical o 'Portrait')
       */
       $modo='c';
       $formato='Letter';
       $params;

       if($params['orientacion'] === 'L'){
         $formato = $formato . '-' .$params['orientacion'];
       }

       // $param = ['orientacion' => 'L'];
       // $this->load->library('pdf', $param )

       $this->pdf = new mPDF($modo, $formato, "", "", 10, 10, 10, 10, 6, 3);
    }
}
