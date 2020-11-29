<template>
      <mdb-datatable
        :data="myData"
        class="mt-4 uns"
        responsive
        arrows
        defaultRow="No hay información"
        noFoundMessage="No hay resultados"
        searchPlaceholder="Buscar"
        :tfoot="false"
        showingText="Mostrando"
        striped
        bordered
        focus
      ></mdb-datatable>
</template>

<script>
import { mdbDatatable } from 'mdbvue'
export default {
  name: 'DatatablePage',
  components: {
    mdbDatatable
  },
  props: {
    'columnas': [],
    'filas': []
  },
  data () {
    return {
      myData: {
        columns: [],
        rows: []
      }
    }
  },
  methods: {
    loadTableData () {
      this.myData.columns = this.columnas
      this.myData.rows = this.filas
    }
  },
  created () {
    this.loadTableData()
  }
}
</script>

<style>

@media (min-width: 1500px) {
  .dataTables_filter input {
    min-width: 300px !important;
  }
}
@media (min-width: 992px) {
  .dataTables_filter input {
    min-width: 300px !important;
  }
}
/* .dataTables_length label {
  display: none !important;
} */
</style>
