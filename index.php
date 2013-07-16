<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'input_submit.php';
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tucano Tours - TKT Compare</title>
<link rel="shortcut icon" href="img/tucano.ico" type="image/x-icon" />
<link href="tkt_compare.css" rel="stylesheet" type="text/css" />
</head>

<body>
        <div id="wrapper">
		<div id="nav">
            <a href="#arriba" class="btn verda">Buscar</a> 
            <a href="#sabre" class="btn verda">Sabre</a> 
            <a href="#sabrevoid" class="btn verda">Sabre Void</a> 
            <a href="#amadeus" class="btn verda">Amadeus</a>
            <a href="#amadeusvoid" class="btn verda">Amadeus Void</a>
        </div>
        <div id="content">
            <a id="arriba"></a>
            <div id="head">
                <div id="nombre-herr"><img alt="Herramienta de Comparación de Tickets" src="img/herramienta.png" /></div>
                <div id="logos">
                    <a href="http://tucanotours.com.ar" target="_blank"><img id="tucano" alt="Tucano Tours" src="img/tucano-tours.png" width="187"/></a>
                    <a href="http://sci.tucanotours.com.ar" target="_blank"><img id="sci" alt="Sistema de Consolidación Integrada" src="img/sci.png" width="250"/></a>
                </div>
            </div>
    		<img alt="" src="img/line_red.png" />
			<form id="buscar" method="post" action="" enctype="multipart/form-data">
		        <input name="files[]" id="files" type="file" multiple="" />
		        <input type="submit" value="Comparar" class="btn primary" >
	    	</form>
            <a name="sabre"></a>
        	<div id="sabre">
        		<table width="800" align="center" cellspacing="0" cellpadding="0" class="shadow_inset" >
        			<thead>
        				<tr>
        					<td>Fecha</td>
        					<td>Aerolínea</td>
        					<td>Ticket</td>
        					<td>PNR</td>
        					<td>Nombre</td>
        					<td>Apellido</td>
        					<td>Ruta</td>
        					<td>Clase</td>
        					<td>TourCode</td>
        					<td>Impuestos</td>
                            <td>Comisión</td>
                            <td>Total TKT</td>
                            <td>Monto Cash</td>
                            <td>Monto Tarjeta</td>
                            <td>FOP</td>
                            <td>FOP Detallada</td>
                            <td>Base de Tarifa</td>
                            <td>Sine</td>
                            <td>Hora</td>
                            <td>Descripción</td>
        				</tr>
        			</thead>
        			<tbody>
                    <?php
                        foreach ($missing['missing_sabre'] as $key => $ticket) {
                            echo "<tr>";
                                foreach ($ticket as $key => $value) {
                                    echo "<td>".$value."</td>";
                                }
                            echo "</tr>";
                        }
                    ?>
        			</tbody>
        		</table>
        	</div>
        	<a name="sabrevoid"></a>
        	<div id="sabrevoid">
        		<table width="800" align="center" cellspacing="0" cellpadding="0" border="0" class="shadow_inset" >
        			<thead>
        				<tr>
                            <td>Fecha</td>
                            <td>Aerolínea</td>
                            <td>Ticket</td>
                            <td>PNR</td>
                            <td>Nombre</td>
                            <td>Apellido</td>
                            <td>Ruta</td>
                            <td>Clase</td>
                            <td>TourCode</td>
                            <td>Impuestos</td>
                            <td>Comisión</td>
                            <td>Total TKT</td>
                            <td>Monto Cash</td>
                            <td>Monto Tarjeta</td>
                            <td>FOP</td>
                            <td>FOP Detallada</td>
                            <td>Base de Tarifa</td>
                            <td>Sine</td>
                            <td>Hora</td>
                            <td>Descripción</td>
        				</tr>
        			</thead>
        			<tbody>
                    <?php
                        foreach ($voids['void_sabre'] as $key => $ticket) {
                            echo "<tr>";
                                foreach ($ticket as $key => $value) {
                                    echo "<td>".$value."</td>";
                                }
                            echo "</tr>";
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            <a name="amadeus"></a>
            <div id="amadeus">
                <table width="800" align="center" cellspacing="0" cellpadding="0" border="0" class="shadow_inset" >
                    <thead>
                        <tr>
                            <td>Aerolínea</td>
                            <td>Ticket</td>
                            <td>Total</td>
                            <td>Impuestos</td>
                            <td>Fee</td>
                            <td>Comisión</td>
                            <td>FOP</td>
                            <td>Pasajero</td>
                            <td>Sine</td>
                            <td>PNR</td>
                            <td>Transacción</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($missing['missing_amadeus'] as $key => $ticket) {
                            echo "<tr>";
                                foreach ($ticket as $key => $value) {
                                    echo "<td>".$value."</td>";
                                }
                            echo "</tr>";
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            <a name="amadeusvoid"></a>
            <div id="amadeusvoid">
                <table width="800" align="center" cellspacing="0" cellpadding="0" border="0" class="shadow_inset" >
                    <thead>
                        <tr>
                            <td>Aerolínea</td>
                            <td>Ticket</td>
                            <td>Total</td>
                            <td>Impuestos</td>
                            <td>Fee</td>
                            <td>Comisión</td>
                            <td>FOP</td>
                            <td>Pasajero</td>
                            <td>Sine</td>
                            <td>PNR</td>
                            <td>Transacción</td>
                        </tr>
                    </thead>                    
                    <tbody>
                    <?php
                        foreach ($voids['void_amadeus'] as $key => $ticket) {
                            echo "<tr>";
                                foreach ($ticket as $key => $value) {
                                    echo "<td>".$value."</td>";
                                }
                            echo "</tr>";
                        }
                    ?>
        			</tbody>
        		</table>
        	</div>
        </div>
    </div>

</body>
</html>
