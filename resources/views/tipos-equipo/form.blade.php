<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control campo-mayusculas campo-solo-letras @error('nombre') is-invalid @enderror" value="{{ old('nombre', $tiposEquipo?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>

<script>

    // SCRIPT PARA CONVERTIR A MAYUSCULAS
    document.querySelectorAll('.campo-mayusculas').forEach(function (campo) {
        campo.addEventListener('input', function () {
            const start = this.selectionStart;
            const end = this.selectionEnd;
            this.value = this.value.toUpperCase();
            this.setSelectionRange(start, end);
        });
    });

</script>
<script id="fix-tipo-cantidad-order">
(function() {
  function aplicarOrdenMayorAMenor() {
    const table = document.querySelector("table");
    if (!table) return false;

    const headers = Array.from(table.querySelectorAll("thead th"));
    const qtyIdx = headers.findIndex(th => th.innerText.trim().toUpperCase().includes("CANTIDAD"));
    if (qtyIdx === -1) return false;

    table.querySelectorAll("tbody tr").forEach(tr => {
      const td = tr.children[qtyIdx];
      if (td) {
        const val = parseInt(td.innerText.replace(/[^0-9-]/g, ""), 10) || 0;
        td.setAttribute("data-order", val);
      }
    });

    if (window.jQuery && $.fn && $.fn.DataTable && $.fn.DataTable.isDataTable(table)) {
      const dt = $(table).DataTable();
      const current = dt.order();
      if (!current.length || current[0][0] !== qtyIdx || current[0][1] !== "desc") {
        dt.order([qtyIdx, "desc"]).draw();
      }
      return true;
    }
    return false;
  }

  document.addEventListener("DOMContentLoaded", function() {
    if (!aplicarOrdenMayorAMenor()) {
      let intentos = 0;
      const timer = setInterval(function() {
        intentos++;
        if (aplicarOrdenMayorAMenor() || intentos >= 20) {
          clearInterval(timer);
        }
      }, 100);
    }
  });
})();
</script>