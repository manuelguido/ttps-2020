<template>
  <mdb-datatable
    :data="myData"
    class="custom-table"
    responsive
    arrows
    striped
    
    defaultRow="No hay información"
    noFoundMessage="No hay resultados"
    searchPlaceholder="Buscar"
    :tfoot="false"
    showingText="Mostrando"
  ></mdb-datatable>
</template>

<script>
import { mdbDatatable } from "mdbvue";
export default {
  name: "DataTable",
  components: {
    mdbDatatable,
  },
  props: {
    columns: {
      type: Array,
      default: [],
    },
    rows: {
      type: Array,
      default: [],
    },
  },
  data() {
    return {
      myData: {
        columns: [],
        rows: [],
      },
    };
  },
  methods: {
    loadTableData() {
      this.myData.columns = this.columns;
      this.myData.rows = this.rows;
    },
  },
  created() {
    this.loadTableData();
  },
};
</script>

<style>
.custom-table table {
  border: 1px solid #eee !important;
  margin-top: 40px !important;
}

.table-button {
  display: block !important;
  margin: auto !important;
  max-width: 80% !important;
}

.dataTables_wrapper input,
.dataTables_wrapper select {
  height: 45px !important;
  border-radius: 8px !important;
}

.dataTables_wrapper select {
  width: 300px !important;
}

.dataTables_wrapper .dataTables_filter{
  width: 100% !important;
}

.dataTables_wrapper input {
  padding: 0 1.5em;
}
</style>
