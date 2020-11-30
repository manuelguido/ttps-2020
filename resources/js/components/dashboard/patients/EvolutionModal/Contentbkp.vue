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
                v-model="temperature"
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
                v-model="heart_rate"
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
                v-model="systolic_ta"
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
                v-model="breathing_rate"
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
                v-model="diastolic_ta"
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
                v-model="ventilatory_mechanic_id"
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
                v-model="requires_oxigen"
                label="Requiere oxígeno"
              ></switcher>
            </div>
          </div>
        </div>
        <!-- /.Row -->

        <!-- Row -->
        <div v-if="requires_oxigen" class="row">
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
                    v-model="required_oxigen_type_id"
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
                    v-model="required_oxigen_value"
                    :disabled="required_oxigen_type_id == 0"
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
                  <switcher v-model="pafi" label="PAFI (PaO2/FiO2)"></switcher>
                </div>
              </div>
              <div class="col-lg-3 offset-lg-1">
                <div class="form-group">
                  <label>Valor pafi</label>
                  <input
                    type="number"
                    min="0"
                    max="100"
                    v-model="pafi_value"
                    :disabled="!pafi"
                    class="form-control"
                  />
                </div>
              </div>
            </div>

            <div class="row mb-2 d-flex align-items-end">
              <div class="col-lg-5">
                <div class="form-group">
                  <switcher v-model="prone" label="Prono vigil"></switcher>
                </div>
              </div>
            </div>

            <div class="row mb-2 d-flex align-items-end">
              <div class="col-lg-5">
                <div class="form-group">
                  <switcher v-model="cough" label="Tos"></switcher>
                </div>
              </div>
            </div>

            <div class="row mb-2 d-flex align-items-end">
              <div class="col-lg-5">
                <div class="form-group">
                  <label>Disnea</label>
                  <select
                    v-model="dyspnoea_id"
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
                    v-model="respiratory_irregularities"
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
              <switcher v-model="drowsiness" label="Somnolencia"></switcher>
            </div>
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-end">
          <div class="col-lg-5">
            <div class="form-group">
              <switcher v-model="anosmia" label="Anosmia"></switcher>
            </div>
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-end">
          <div class="col-lg-5">
            <div class="form-group">
              <switcher v-model="dysgeucia" label="Disgeusia"></switcher>
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
              <switcher v-model="rxtx" label="Rx Tx"></switcher>
            </div>
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-end">
          <div class="col-lg-5">
            <div class="form-group">
              <switcher v-model="tac" label="TAC de tórax"></switcher>
            </div>
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-end">
          <div class="col-lg-5">
            <div class="form-group">
              <switcher v-model="ecg" label="ECG"></switcher>
            </div>
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-end">
          <div class="col-lg-5">
            <div class="form-group">
              <switcher v-model="pcr" label="PCR Covid"></switcher>
            </div>
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-end">
          <div class="col-lg-5">
            <div class="form-group">
              <switcher v-model="laboratory" label="Laboratorio"></switcher>
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
                v-model="feeding_type_id"
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
                v-model="feeding_note"
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
              <textarea rows="1" class="form-control" v-model="drug"></textarea>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label>Dósis</label>
              <textarea
                rows="1"
                class="form-control"
                v-model="drug_dosis"
              ></textarea>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label>Numero de días</label>
              <input type="number" v-model="dosis_day_number" class="form-control" />
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
                v-model="thromboprophylaxis"
                label="Tromboprofilaxis"
              ></switcher>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <textarea
                rows="1"
                class="form-control"
                :disabled="!thromboprophylaxis"
                v-model="thromboprophylaxis_data"
                placeholder="Descripción"
              ></textarea>
            </div>
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-center">
          <div class="col-lg-6">
            <div class="form-group">
              <switcher
                v-model="dexamethasone"
                label="Dexametasona "
              ></switcher>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <textarea
                rows="1"
                class="form-control"
                :disabled="!dexamethasone"
                v-model="dexamethasone_data"
                placeholder="Descripción"
              ></textarea>
            </div>
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-center">
          <div class="col-lg-6">
            <div class="form-group">
              <switcher
                v-model="gastric_protection"
                label="Protección gástrica"
              ></switcher>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <textarea
                rows="1"
                class="form-control"
                :disabled="!gastric_protection"
                v-model="gastric_protection_data"
                placeholder="Descripción"
              ></textarea>
            </div>
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-center">
          <div class="col-lg-6">
            <div class="form-group">
              <switcher v-model="dialysis" label="Diálisis"></switcher>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <textarea
                rows="1"
                class="form-control"
                :disabled="!dialysis"
                v-model="dialysis_data"
                placeholder="Descripción"
              ></textarea>
            </div>
          </div>
        </div>

        <div class="row mb-2 d-flex align-items-center">
          <div class="col-lg-6">
            <div class="form-group">
              <switcher
                v-model="research_study"
                label="Participa en Estudio de Investigación"
              ></switcher>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <textarea
                rows="1"
                class="form-control"
                :disabled="!research_study"
                v-model="research_study_data"
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
                v-model="observations"
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
      current: 5,
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
      temperature: '',
      heart_rate: '',
      breathing_rate: '',
      systolic_ta: '',
      diastolic_ta: '',
      // Step 2
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
      // Step 3
      drowsiness: false,
      anosmia: false,
      dysgeucia: false,
      // Step 4
      rxtx: false,
      tac: false,
      ecg: false,
      pcr: false,
      laboratory: false,
      // Step 5
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
      // Step 6
      observations: "",
    };
  },
  methods: {
    isNumber: function(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        evt.preventDefault();;
      } else {
        return true;
      }
    },

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
      return (this.temperature != '' &&
        this.heart_rate != '' &&
        this.breathing_rate != '' &&
        this.systolic_ta != '' &&
        this.diastolic_ta != '');
    },

    newEvolution() {
      const path = "/api/evolution/store";
      const AuthStr = "Bearer "+localStorage.getItem("access_token").toString();
      const jsonData = JSON.stringify({ answer: 42 });
      axios
        .post(
          path,
          {
            patient_id: parseInt(this.patient_id),
            // Step 1
            temperature: this.temperature,
            heart_rate: this.heart_rate,
            breathing_rate: this.breathing_rate,
            systolic_ta: this.systolic_ta,
            diastolic_ta: this.diastolic_ta,
            // Step 2
            ventilatory_mechanic_id: this.ventilatory_mechanic_id,
            requires_oxigen: this.requires_oxigen,
            required_oxigen_type_id: this.required_oxigen_type_id,
            required_oxigen_value: this.required_oxigen_value,
            pafi: this.pafi,
            pafi_value: this.pafi_value,
            prone: this.prone,
            cough: this.cough,
            dyspnoea_id: this.dyspnoea_id,
            respiratory_irregularities: this.respiratory_irregularities,
            // Step 3
            drowsiness: this.drowsiness,
            anosmia: this.anosmia,
            dysgeucia: this.dysgeucia,
            // Step 4
            rxtx: this.rxtx,
            tac: this.tac,
            ecg: this.ecg,
            pcr: this.pcr,
            laboratory: this.laboratory,
            // Step 5
            feeding_type_id: this.feeding_type_id,
            feeding_note: this.feeding_note,
            drug: this.drug,
            drug_dosis: this.drug_dosis,
            dosis_day_number: this.dosis_day_number,
            thromboprophylaxis: this.thromboprophylaxis,
            thromboprophylaxis_data: this.thromboprophylaxis_data,
            dexamethasone: this.dexamethasone,
            dexamethasone_data: this.dexamethasone_data,
            gastric_protection: this.gastric_protection,
            gastric_protection_data: this.gastric_protection_data,
            dialysis: this.dialysis,
            dialysis_data: this.dialysis_data,
            research_study: this.research_study,
            research_study_data: this.research_study_data,
            // Step 6
            observations: this.observations,
          },
          {
            headers: {
              Accept: "application/json",
              Authorization: AuthStr,
            },
          }
        )
        .then((res) => {
          this.new_alert(res.data);
          if (res.data.status == "success") {
            this.$emit("reload-data");
          }
          console.log(res);
        })
        .catch((err) => {
          console.log(err);
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
