<div class="modal" id="modalUpdateEvento" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Actualizar mi Evento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form name="formEventoUpdate" id="formEventoUpdate" action="calendario/UpdateEvento.php" class="form-horizontal"
        method="POST">
        <input type="hidden" class="form-control" name="idEvento" id="idEvento">
        <div class="form-group">
          <label for="evento" class="col-sm-12 control-label">Nombre del Evento</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="evento" id="evento" placeholder="Nombre del Evento"
              required />
          </div>
        </div>
        <div class="form-group">
          <label for="fecha_inicio" class="col-sm-12 control-label">Fecha</label>
          <div class="col-sm-10">
            <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" placeholder="Fecha Inicio">
          </div>
        </div>

        <div class="form-group">
          <label for="hora_inicio" class="col-sm-12 control-label">Hora Inicio</label>
          <div class="col-sm-4">
            <input type="time" class="form-control" name="hora_inicio" id="hora_inicio" placeholder="Hora de inicio">
          </div>
        </div>

        <div class="form-group">
          <label for="hora_fin" class="col-sm-12 control-label">Hora Final</label>
          <div class="col-sm-4">
            <input type="time" class="form-control" name="hora_fin" id="hora_fin" placeholder="Hora de finalización">
          </div>
        </div>

        <div class="form-group">
          <label for="observaciones" class="col-sm-12 control-label">Observaciones</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="observaciones" id="observaciones"
              placeholder="Máximo 50 carácteres">
          </div>
        </div>

        <div class="col-md-12 activado">

          <input type="radio" name="color_evento" id="orangeUpd" value="#FF5722" checked>
          <label for="orangeUpd" class="circu" style="background-color: #FF5722;"> </label>

          <input type="radio" name="color_evento" id="amberUpd" value="#FFC107">
          <label for="amberUpd" class="circu" style="background-color: #FFC107;"> </label>

          <input type="radio" name="color_evento" id="limeUpd" value="#8BC34A">
          <label for="limeUpd" class="circu" style="background-color: #8BC34A;"> </label>

          <input type="radio" name="color_evento" id="tealUpd" value="#009688">
          <label for="tealUpd" class="circu" style="background-color: #009688;"> </label>

          <input type="radio" name="color_evento" id="blueUpd" value="#2196F3">
          <label for="blueUpd" class="circu" style="background-color: #2196F3;"> </label>

          <input type="radio" name="color_evento" id="indigoUpd" value="#9c27b0">
          <label for="indigoUpd" class="circu" style="background-color: #9c27b0;"> </label>

        </div>


        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar Cambios de mi Evento</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        </div>
      </form>

    </div>
  </div>
</div>