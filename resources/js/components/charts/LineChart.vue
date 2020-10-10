<template>
  <mdb-container>
    <mdb-line-chart
      :data="lineChartData"
      :options="lineChartOptions"
      :width="600"
      :height="300"
      datalabels
    ></mdb-line-chart>
  </mdb-container>
</template>

<script>
  import { mdbLineChart, mdbContainer } from "mdbvue";
  export default {
    name: "ChartPage",
    components: {
      mdbLineChart,
      mdbContainer
    },
    data() {
      return {
        lineChartData: {
          labels: [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July"
          ],
          datasets: [
            {
              label: "Infectados",
              backgroundColor: "rgba(151,187,205,0.2)",
              borderColor: "rgba(151,187,205,1)",
              borderWidth: 0.7,
              data: [65, 59, 80, 81, 56, 55, 40]
            },
            {
              label: "Recuperados",
              backgroundColor: "rgba(0,219,51,0.2)",
              borderColor: "rgba(0,219,51,1)",
              borderWidth: 0.8,
              data: [28, 48, 40, 19, 86, 27, 90]
            },
            {
              label: "Fallecidos",
              backgroundColor: "rgba(255,20,20,0.2)",
              borderColor: "rgba(255,20,20,1)",
              borderWidth: 0.8,
              data: [6, 9, 32, 19, 14, 19, 9]
            }
          ]
        },
        lineChartOptions: {
          responsive: false,
          maintainAspectRatio: false,
          scales: {
            xAxes: [
              {
                gridLines: {
                  display: true,
                  color: "rgba(0, 0, 0, 0.1)"
                }
              }
            ],
            yAxes: [
              {
                gridLines: {
                  display: true,
                  color: "rgba(0, 0, 0, 0.1)"
                }
              }
            ]
          }
        }
      };
    }
  };
</script>