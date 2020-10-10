<template>
  <mdb-datatable
    striped
    bordered
    arrows
    reactive
    data="http://127.0.0.1:8000/api/patient/index"
    :time="3000"
    :tfoot="false"
  />
</template>

<script>
  import { mdbDatatable } from 'mdbvue';
  export default {
    name: 'DatatablePage',
    components: {
      mdbDatatable
    },
    props: {
      columns: {
        type: Array,
      },
      rows: {
        type: Array,
      }
    },
    // created () {
    //   this.setColumns();
    //   this.setRows();
    // },
    data() {
      return {
        data: {
          columns: [],
          rows: []
        }
      }
    },
    methods: {
      setColumns () {
        this.data.columns = this.columns;
      },

      setRows () {
        this.data.rows = this.rows;
      }
    }
  }
</script>
