<template>
  <form class="stepper" @submit.prevent="newEvolution()">

    <!-- Stepper Header -->
    <stepper-header @stepChange="setStep" :steps="steps" :current="current"></stepper-header>
    <!-- /.Stepper Header -->

    <!-- Stepper content -->
    <div class="stepper-content">
      <!-- Step 1  -->
      <div v-if="current == 1" class="step-content">
        <stepper-title :text="steps[0].name"></stepper-title>
        <!-- Row -->
        <div class="row">
          <div class="col-lg-4">
            <div class="form-group">
              <label>Temperatura (*)</label>
              <input
                type="number"
                @keypress="isNumber($event)"
                min="1"
                step="0.1"
                v-model="evolution.temperature"
                class="form-control"
                placeholder="0.0 (1 decimal maximo)"
                required
              />
            </div>
          </div>

          <div class="col-lg-4 offset-lg-2">
            <div class="form-group">
              <label>Frecuencia Cardíaca (*)</label>
              <input
                type="number"
                @keypress="isNumber($event)"
                min="1"
                v-model="evolution.heart_rate"
                class="form-control"
                placeholder="0 (Sin decimales)"
                required
              />
            </div>
          </div>
        </div>
        <!-- /.Row -->

        <!-- Row -->
        <div class="row">
          <div class="col-lg-4">
            <div class="form-group">
              <label>TA Sistólica (*)</label>
              <input
                type="number"
                @keypress="isNumber($event)"
                min="1"
                v-model="evolution.systolic_ta"
                class="form-control"
                placeholder="0 (Sin decimales)"
                required
              />
            </div>
          </div>

          <div class="col-lg-4 offset-lg-2">
            <div class="form-group">
              <label>Frecuencia Respiratoria (*)</label>
              <input
                type="number"
                @keypress="isNumber($event)"
                min="1"
                v-model="evolution.breathing_rate"
                class="form-control"
                placeholder="0 (Sin decimales)"
                required
              />
            </div>
          </div>
        </div>
        <!-- /.Row -->

        <!-- Row -->
        <div class="row">
          <div class="col-lg-4">
            <div class="form-group">
              <label>TA Distólica (*)</label>
              <input
                type="number"
                @keypress="isNumber($event)"
                min="1"
                v-model="evolution.diastolic_ta"
                class="form-control"
                placeholder="0 (Sin decimales)"
                required
              />
            </div>
          </div>
        </div>
      </div>
      <!-- /.Step 1 -->

      <!-- Step 2 -->
      <div v-if="current == 2" class="step-content">
        <stepper-title :text="steps[1].name"></stepper-title>
        <!-- Row -->
        <div class="row mb-3">
          <div class="col-lg-5">
            <div class="form-group">
              <label>Mecánica ventilatoria</label>
              <select
                v-model="respiratory.ventilatory_mechanic_id"
                class="browser-default custom-select"
              >
                <option value="0" selected>Seleccionar</option>
                <option value="1">Buena</option>
                <option value="2">Regular</option>
                <option value="3">Mal</option>
              </select>
            </div>
          </div>
        </div>
        <!-- /.Row -->

        <!-- Row -->
        <div class="row">
          <div class="col-lg-5">
            <div class="form-group">
              <switcher
                v-model="respiratory.requires_oxigen"
                label="Requiere oxígeno"
              ></switcher>
            </div>
          </div>
        </div>
        <!-- /.Row -->

        <!-- Row -->
        <div v-if="respiratory.requires_oxigen" class="row">
          <div class="col-12">
            <hr>
          </div>
          <!-- Col -->
          <div class="col-12">
            <!-- Row -->
            <div class="row mb-2">
              <!-- Col -->
              <div class="col-lg-5">
                <div class="form-group">
                  <label>Tipo</label>
                  <select
                    v-model="respiratory.required_oxigen_type_id"
                    class="browser-default custom-select"
                  >
                    <option value="0" selected>Seleccionar</option>
                    <option value="1">Canula nasal de oxígeno</option>
                    <option value="2">Máscara con reservorio</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-3 offset-lg-1">
                <div class="form-group">
                  <label>Valor (%)</label>
                  <input
                    type="number"
                    min="0"
                    max="100"
                    v-model="respiratory.required_oxigen_value"
                    :disabled="respiratory.required_oxigen_type_id == 0"
                    placeholder="0-100 (Sin decimales)"
                    class="form-control"
                  />
                </div>
              </div>
            </div>
            <!-- /.Row -->

            <!-- Row -->
            <div class="row mb-2 d-flex align-items-end">
              <div class="col-lg-5">
                <div class="form-group">
                  <switcher v-model="respiratory.pafi" label="PAFI (PaO2/FiO2)"></switcher>
                </div>
              </div>
              <div class="col-lg-3 offset-lg-1">
                <div class="form-group">
                  <label>Valor pafi</label>
                  <input
                    type="number"
                    min="0"
                    max="100"
                    v-model="respiratory.pafi_value"
                    :disabled="!respiratory.pafi"
                    class="form-control"
                  />
                </div>
              </div>
            </div>

            <div class="row mb-2 d-flex align-items-end">
              <div class="col-lg-5">
                <div class="form-group">
                  <switcher v-model="respiratory.prone" label="Prono vigil"></switcher>
                </div>
              </div>
            </div>

            <div class="row mb-2 d-flex align-items-end">
              <div class="col-lg-5">
                <div class="form-group">
                  <switcher v-model="respiratory.cough" label="Tos"></switcher>
                </div>
              </div>
            </div>

            <div class="row mb-2 d-flex align-items-end">
              <div class="col-lg-5">
                <div class="form-group">
                  <label>Disnea</label>
                  <select
                    v-model="respiratory.dyspnoea_id"
                    class="browser-default custom-select"
                  >
                    <option value="0" selected>Seleccionar</option>
                    <option value="1">0</option>
                    <option value="2">1</option>
                    <option value="3">2</option>
                    <option value="4">3</option>
                    <option value="5">4</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row mb-2 d-flex align-items-end">
              <div class="col-lg-5">
                <div class="form-group">
                  <switcher
                    v-model="respiratory.respiratory_irregularities"
                    label="Estabilidad/Desaparición de sintomas"
                  ></switcher>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.Step 2 -->

      <!-- Step 3 -->
      <div v-if="current == 3" class="step-content">
        <stepper-title :text="steps[2].name"></stepper-title>

        <div class="row mb-2 d-flex align-items-end">
          <div class="col-lg-5">
            <div class="form-group">
              <switcher v-model="otherSymptoms.drowsiness" label="Somnolencia"></switcher>
            </div>
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-end">
          <div class="col-lg-5">
            <div class="form-group">
              <switcher v-model="otherSymptoms.anosmia" label="Anosmia"></switcher>
            </div>
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-end">
          <div class="col-lg-5">
            <div class="form-group">
              <switcher v-model="otherSymptoms.dysgeucia" label="Disgeusia"></switcher>
            </div>
          </div>
        </div>
      </div>
      <!-- /.Step 3 -->

      <!-- Step 4 -->
      <div v-if="current == 4" class="step-content">
        <stepper-title :text="steps[3].name"></stepper-title>

        <div class="row mb-2 d-flex align-items-end">
          <div class="col-lg-5">
            <div class="form-group">
              <switcher v-model="studies.rxtx" label="Rx Tx"></switcher>
            </div>
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-end">
          <div class="col-lg-5">
            <div class="form-group">
              <switcher v-model="studies.tac" label="TAC de tórax"></switcher>
            </div>
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-end">
          <div class="col-lg-5">
            <div class="form-group">
              <switcher v-model="studies.ecg" label="ECG"></switcher>
            </div>
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-end">
          <div class="col-lg-5">
            <div class="form-group">
              <switcher v-model="studies.pcr" label="PCR Covid"></switcher>
            </div>
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-end">
          <div class="col-lg-5">
            <div class="form-group">
              <switcher v-model="studies.laboratory" label="Laboratorio"></switcher>
            </div>
          </div>
        </div>
      </div>
      <!-- /.Step 4 -->

      <!-- Step 5 -->
      <div v-if="current == 5" class="step-content">
        <stepper-title :text="steps[4].name"></stepper-title>
        <!-- Row -->
        <div class="row mb-2 d-flex align-items-start">
          <!-- Col -->
          <div class="col-12">
            <h3 class="h6-responsive mb-3 black-alpha-40">Alimentación</h3>
          </div>
          <!-- Col -->
          <div class="col-lg-6">
            <div class="form-group">
              <label>Tipo de alimentación</label>
              <select
                v-model="actualTreatments.feeding_type_id"
                class="browser-default custom-select"
              >
                <option value="0" selected>Seleccionar</option>
                <option value="1">Oral</option>
                <option value="2">Enteral</option>
                <option value="3">Parenteral</option>
              </select>
            </div>
          </div>
          <div class="col-lg-6"></div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>Nota de Alimentación</label>
              <textarea
                rows="2"
                class="form-control"
                v-model="actualTreatments.feeding_note"
              ></textarea>
            </div>
          </div>

          <div class="col-12">
            <hr />
          </div>

          <div class="col-12">
            <h3 class="h6-responsive mb-3 black-alpha-40">ATB</h3>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label>Farmaco</label>
              <textarea rows="1" class="form-control" v-model="actualTreatments.drug"></textarea>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label>Dósis</label>
              <textarea
                rows="1"
                class="form-control"
                v-model="actualTreatments.drug_dosis"
              ></textarea>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label>Numero de días</label>
              <input type="number" v-model="actualTreatments.dosis_day_number" class="form-control" />
            </div>
          </div>

          <div class="col-12">
            <hr />
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-center">
          <div class="col-lg-6">
            <div class="form-group">
              <switcher
                v-model="actualTreatments.thromboprophylaxis"
                label="Tromboprofilaxis"
              ></switcher>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <textarea
                rows="1"
                class="form-control"
                :disabled="!actualTreatments.thromboprophylaxis"
                v-model="actualTreatments.thromboprophylaxis_data"
                placeholder="Descripción"
              ></textarea>
            </div>
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-center">
          <div class="col-lg-6">
            <div class="form-group">
              <switcher
                v-model="actualTreatments.dexamethasone"
                label="Dexametasona "
              ></switcher>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <textarea
                rows="1"
                class="form-control"
                :disabled="!actualTreatments.dexamethasone"
                v-model="actualTreatments.dexamethasone_data"
                placeholder="Descripción"
              ></textarea>
            </div>
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-center">
          <div class="col-lg-6">
            <div class="form-group">
              <switcher
                v-model="actualTreatments.gastric_protection"
                label="Protección gástrica"
              ></switcher>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <textarea
                rows="1"
                class="form-control"
                :disabled="!actualTreatments.gastric_protection"
                v-model="actualTreatments.gastric_protection_data"
                placeholder="Descripción"
              ></textarea>
            </div>
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-center">
          <div class="col-lg-6">
            <div class="form-group">
              <switcher v-model="actualTreatments.dialysis" label="Diálisis"></switcher>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <textarea
                rows="1"
                class="form-control"
                :disabled="!actualTreatments.dialysis"
                v-model="actualTreatments.dialysis_data"
                placeholder="Descripción"
              ></textarea>
            </div>
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-center">
          <div class="col-lg-6">
            <div class="form-group">
              <switcher
                v-model="actualTreatments.research_study"
                label="Participa en Estudio de Investigación"
              ></switcher>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <textarea
                rows="1"
                class="form-control"
                :disabled="!actualTreatments.research_study"
                v-model="actualTreatments.research_study_data"
                placeholder="Descripción"
              ></textarea>
            </div>
          </div>
        </div>
      </div>
      <!-- /.Step 5 -->

      <!-- Step 6 -->
      <div v-if="current == 6" class="step-content">
        <stepper-title :text="steps[5].name"></stepper-title>
        <div class="row mb-2 d-flex align-items-center">
          <div class="col-lg-12">
            <div class="form-group">
              <textarea
                rows="4"
                class="form-control"
                v-model="observations.observations"
                placeholder="En cuanto al paciente..."
              ></textarea>
            </div>
          </div>
        </div>
      </div>
      <!-- /.Step 6 -->

    </div>
    <!-- /.Stepper content -->

    <!-- Stepper footer -->
    <div class="stepper-footer">
      <button type="submit" :class="['btn btn-block', allowSubmit() ? 'btn-success' : 'btn-light disabled']">
        Guardar evolución
      </button>
    </div>
    <!-- /.Stepper footer -->
  </form>
</template>

<script>
import axios from "axios";
import StepperHeader from "./Header";
import StepperTitle from "./Title";
export default {
  name: "Stepper",
  components: {
    'stepper-header': StepperHeader,
    'stepper-title': StepperTitle,
  },
  props: {
    patient_id: {
      type: String,
    }
  },
  data() {
    return {
      current: 1,
      loading: false,
      message: "",
      steps: [
        {
          order: 1,
          name: "Signos vitales",
          icon: "fad fa-heart-rate",
        },
        {
          order: 2,
          name: "Sistema respiratorio",
          icon: "fad fa-lungs",
        },
        {
          order: 3,
          name: "Otros síntomas",
          icon: "fad fa-thermometer",
        },
        {
          order: 4,
          name: "Estudios realizados hoy",
          icon: "fad fa-file-medical-alt",
        },
        {
          order: 5,
          name: "Tratamientos actuales",
          icon: "fad fa-capsules",
        },
        {
          order: 6,
          name: "Observación",
          icon: "fad fa-notes-medical",
        },
      ],
      date: Date.now(),
      time: "",
      // Step 1
      evolution: {
        temperature: '',
        heart_rate: '',
        breathing_rate: '',
        systolic_ta: '',
        diastolic_ta: '',
      },
      // Step 2
      respiratory: {
        ventilatory_mechanic_id: 0,
        requires_oxigen: false,
        required_oxigen_type_id: 0,
        required_oxigen_value: null,
        pafi: false,
        pafi_value: 0,
        prone: false,
        cough: false,
        dyspnoea_id: 0,
        respiratory_irregularities: false,
      },
      // Step 3
      otherSymptoms: {
        drowsiness: false,
        anosmia: false,
        dysgeucia: false,
      },
      studies: {
        // Step 4
        rxtx: false,
        tac: false,
        ecg: false,
        pcr: false,
        laboratory: false,
      },
      // Step 5
      actualTreatments: {
        feeding_type_id: 0,
        feeding_note: '',
        drug: '',
        drug_dosis: '',
        dosis_day_number: null,
        thromboprophylaxis: false,
        thromboprophylaxis_data: '',
        dexamethasone: false,
        dexamethasone_data: '',
        gastric_protection: false,
        gastric_protection_data: '',
        dialysis: false,
        dialysis_data: '',
        research_study: false,
        research_study_data: '',
      },
      // Step 6
      observations: {
        observations: "",
      }
    };
  },
  methods: {
    setStep(value) {
      this.current = value;
    },

    back() {
      if (this.current > 1) {
        this.setStep(--this.current);
      }
    },

    next() {
      if (this.current < this.steps.length) {
        this.setStep(++this.current);
      }
    },

    notFinished() {
      return this.current < this.steps.length;
    },

    allowSubmit () {
      return true;
      // return (
      //   this.evolution.temperature != '' &&
      //   this.evolution.heart_rate != '' &&
      //   this.evolution.breathing_rate != '' &&
      //   this.evolution.systolic_ta != '' &&
      //   this.evolution.diastolic_ta != ''
      // );
    },

    newEvolution() {
      const path = "/api/evolution/store";
      const AuthStr = "Bearer "+localStorage.getItem("access_token").toString();
      const jsonData = JSON.stringify({
        patient_id: parseInt(this.patient_id),
        evolution: this.evolution,
        respiratory: this.respiratory,
        otherSymptoms: this.otherSymptoms,
        studies: this.studies,
        actualTreatments: this.actualTreatments,
        observations: this.observations,
      });


      axios.post(path, jsonData, {
          headers: {
            'Accept': 'application/json',
            'Authorization': AuthStr,
          }
        }).then((res) => {
          this.new_alert(res.data);
          // if (res.data.status == 'success') {
            // this.$emit("reload-data");
          // }
          console.log(res);
        }).catch((err) => {
          console.log(err)
        });
    }
  },
};
</script>

<style scoped>
/* Content */
.stepper-content {
  /* min-height: 500px; */
  padding: 1em 5vw;
  margin: 2em 0;
}

/* Transition */
.stepper .steps,
.stepper .step {
  transition: 0.05s all !important;
}
</style>
