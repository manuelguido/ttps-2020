<template>
  <mdb-datatable
    striped
    bordered
    arrows
    reactive
    :data="api_url"
    :time="1000"
    :tfoot="false"
    focus
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
      api_url: {
        type: String,
      },
      columns: {
        type: Array,
      },
      rows: {
        type: Array,
      }
    },
    data() {
      return {
        data: {
          columns: [],
          rows: []
        }
      }
    },
    methods: {
      goTo() {
        alert();
      }
    }
  }
</script>
