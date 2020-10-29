<script type='text/javascript' src='https://tableau.pfalimentos.cl/javascripts/api/tableau_v8.js'></script>

<div class="container-fluid" >
  <div id="id_text"></div>
</div>



<script>
  $(document).ready(function() {
    $('.sidebar-mini').addClass('sidebar-collapse');
  });
  var placeholderDiv = document.getElementById ("id_text");
  console.log('<?php echo $ticket; ?>');
  //var url = "http://tableautest.pf100.cl/trusted/<?php echo $ticket; ?>/#/views/TestWeb/Hoja1?:embed=yes&:tabs=yes";

  var ancho = screen.width;
  var alto = screen.height;
  console.log(ancho);
  console.log(alto);
  //http://tableauprod/#/views/ProgramapersonalizadoDashboard/Dashboard?:iid=3   
  //http://tableauprod/#/views/InformeSistemaPre-Factura/Resumeninformacon?:iid=3
  
  var url = "https://tableau.pfalimentos.cl/trusted/<?php echo $ticket; ?>/views/InformeSistemaPre-Factura/Resumeninformacon?iframeSizedToWindow=true&:embed=y&:showAppBanner=false&:display_count=no&:showVizHome=no&:origin=viz_share_link&:revert=all&:refresh=yes";
  var options = {
    hideTabs: false,
    hideToolbar: true,
    width: ancho+ "px",
    height: alto+"px",
    device: "desktop"
  };

  // if(ancho > 1024) {
  //   options.device = "desktop";
  // } else if(ancho > 375) {
  //   options.device = "tablet";
  // } else {
  //   options.device = "phone";
  // }

  var viz = new tableauSoftware.Viz(placeholderDiv, url, options);
  //setInterval (function () {viz.refreshDataAsync()}, 5000);
</script>