<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Registro de Pedidos</title>

<script>

function validar(formulario)
{

if (formulario.txtPe_Estado.value == '') {
  alert('Seleccione un estado');
  formulario.txtPe_Estado.focus();
  return false;
}


if(formulario.txtPe_Producto.value=='')
{
alert('Sr Usuario debe ingresar el estado del producto');
formulario.txtPe_Producto.focus();
return false;
}

if(formulario.txtPe_Cantidad.value=='')
{
alert('Sr Usuario debe ingresar la cantidad');
formulario.txtPe_Cantidad.focus();
formulario.txtPe_Cantidad='';
return false;
}

if(formulario.txtPe_Precio.value=='')
{
alert('Sr Usuario debe ingresar el precio del producto');
formulario.txtPe_Precio.focus();
formulario.txtPe_Precio.value='';
return false;
}

if(formulario.txtPe_Fechaentrega.value=='')
{
alert('Sr Usuario debe ingresar la fecha de entrega');
formulario.txtPe_Fechaentrega.focus();
return false;
}

if(formulario.txtPe_Fechapedido.value=='')
{
alert('Sr Usuario debe ingresar la fecha del pedido');
formulario.txtPe_Fechapedido.focus();
return false;
}

if(formulario.txtPe_Cliente.value=='')
{
alert('Sr Usuario debe seleccionar al cliente');
formulario.txtPe_Cliente.focus();
return false;
}

if(formulario.txtPe_Observacion.value=='')
{
alert('Sr Usuario debe ingresar una observacion del pedido');
formulario.txtPe_Observacion.focus();
return false;
}
return true;
}

</script>
<h1 ALIGN=CENTER>Entrada de Pedidos</h1>

</head>
<center>

<h2>FORMULARIO</h2>
</center>
<body>

<center>

<form id="form1" name="form1" method=post onsubmit="return validar(this)" action="grabarpedido.php">


  <table width="400" border="1">
    <tr>
      <td width=50%>Codigo</td>
      <td>
        <input name="txtPe_Codigo" type="text" id="txtPe_Codigo"size=10/>
      </td>
    </tr>
    <tr>
      <td>Estado</td>
      <td>
        <select name="txtPe_Estado" id="txtPe_Estado">
      <option value="">Seleccione un estado</option>
      <option value="1">Nuevo</option>
        <option value="2">Confirmado</option>
        <option value="3">En proceso</option>
        <option value="4">Terminado</option>
        <option value="5">Entregado</option>
        <option value="6">Cancelado</option>
        <option value="7">Devuelto</option>
    </select>
      </td>
    </tr>
	<tr>
      <td>Producto</td>
      <td>
        <input name="txtPe_Producto" type="text" id="txtPe_Producto"  size=5/>
      </td>
    </tr>
	<tr>
      <td>Cantidad</td>
      <td>
        <input name="txtPe_Cantidad" type="text" id="txtPe_Cantidad" size=20/>
      </td>
    </tr>
	<tr>
      <td>Precio</td>
      <td>
        <input name="txtPe_Precio" type="text" id="txtPe_Precio" size=20/>
      </td>
    </tr>
	<tr>
      <td>Fecha de Entrega</td>
      <td>
      <input name="txtPe_Fechaentrega" type="date" id="txtPe_Fechaentrega" />
      </td>
    </tr>
	
    <tr>
      <td>Fecha de Pedido</td>
      <td>
        <input name="txtPe_Fechapedido" type="date" id="txtPe_Fechapedido">
      </td>
    </tr>

    <tr>
      <td>Cliente</td>
      <td>
        <input name="txtPe_Cliente" type="text" id="txtPe_Cliente" size=20/>
      </td>
    </tr>
	<tr>
      <td>Observaciones</td>
      <td>
        <input name="txtPe_Observacion" type="text" id="txtPe_Observacion" size=50/>
      </td>
    </tr>
     
    <tr>
    
      <td> 
    <?php
		include("..\..\conexion.php");
		
		?>
    </td>
    </tr>
	
    <td>
     
	<center>
        <input type="submit" name="Submit" value="Enviar" />
	</center>
      </td>
      <td>
	<center>
        <input type="reset" name="Submit2" value="Restablecer" />
	</center>
      </td>
    </tr>
  </table>
</form>
</center>


</body>
</html>