<template>
  <div class="stepper">

    <!-- Card header -->
    <div class="header uns">
      <!-- Steps -->
      <div class="steps d-flex">
        <div  v-for="step in steps" :key="step.order"
          @click="setStep(step.order)"
          class="step"
          v-bind:class="step.order == el ? 'active' : '' ">

          <span class="step-order">{{step.order}}</span>
          
        </div>
      </div>
      <!-- Steps -->
    </div>
    <!-- /.Card header -->

    <!-- Card body -->
    <div class="content">

      <!-- Content -->
      <form class="stepper-content" v-on:submit.prevent="newEvolution()">

            <!-- Step 1  -->
            <div class="step-content">
              <h3 class="h4-responsive mb-4 black-alpha-50">Signos vitales</h3>
              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                    <label>Temperatura</label>
                    <input type="number" min="1" step="0.1" v-model="temperature" class="form-control">
                  </div>
                </div>

                <div class="col-lg-4 offset-lg-2">
                  <div class="form-group">
                    <label>FC</label>
                    <input type="number" min="1" v-model="fc" class="form-control">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                    <label>TA Sistólica</label>
                    <input type="number" min="1" v-model="systolic_ta" class="form-control">
                  </div>
                </div>

                <div class="col-lg-4 offset-lg-2">
                  <div class="form-group">
                    <label>FR</label>
                    <input type="number" min="1" v-model="fr" class="form-control">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                    <label>TA Distólica</label>
                    <input type="number" min="1" v-model="diastolic_ta" class="form-control">
                  </div>
                </div>
              </div>

            </div>
            <!-- Step 2 -->
            <div class="step-content">
              <h3 class="h4-responsive mb-4 black-alpha-50">Sistema respiratorio</h3>

              <div class="row mb-3">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Mecánica ventilatoria</label>
                      <select class="browser-default custom-select">
                        <option selected disabled>Seleccionar</option>
                        <option value="1">Buena</option>
                        <option value="2">Regular</option>
                        <option value="3">Mal</option>
                      </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <switcher v-model="requires_oxigen" label="Requiere oxígeno"></switcher>
                  </div>
                </div>
              </div>

              <div v-if="requires_oxigen" class="row">
                <div class="col-12">
                  
                  <div class="row mb-2">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label>Tipo</label>
                        <select class="browser-default custom-select">
                          <option selected disabled>Seleccionar</option>
                          <option value="1">Canula nasal de oxígeno</option>
                          <option value="2">Máscara con reservorio</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label>Valor (0%-100%)</label>
                        <input type="number" min="0" max="100" v-model="oxigen_requirements_value" class="form-control">
                      </div>
                    </div>
                  </div>
                  <!-- /.Row -->

                  <div class="row mb-2 d-flex align-items-end">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <switcher v-model="pafi" label="PAFI (PaO2/FiO2)"></switcher>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label>Valor pafi</label>
                        <input type="number" min="0" max="100" v-model="oxigen_requirements_value" :disabled="!pafi" class="form-control">
                      </div>
                    </div>
                  </div>

                  <div class="row mb-2 d-flex align-items-end">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <switcher v-model="prone" label="Prono vigil"></switcher>
                      </div>
                    </div>
                  </div>

                  <div class="row mb-2 d-flex align-items-end">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <switcher v-model="cough" label="Tos"></switcher>
                      </div>
                    </div>
                  </div>

                  <div class="row mb-2 d-flex align-items-end">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label>Disnea</label>
                        <select class="browser-default custom-select">
                          <option selected disabled>Seleccionar</option>
                          <option value="0">0</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row mb-2 d-flex align-items-end">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <switcher v-model="respiratory_irregularities" label="Estabilidad/Desaparición de sintomas"></switcher>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

            </div>
            <!-- Step 3 -->
            <div class="step-content">
              <h3 class="h4-responsive mb-4 black-alpha-50">Otros sintomas</h3>

              <div class="row mb-2 d-flex align-items-end">
                <div class="col-lg-6">
                  <div class="form-group">
                    <switcher v-model="drowsiness" label="Somnolencia"></switcher>
                  </div>
                </div>
              </div>

              <div class="row mb-2 d-flex align-items-end">
                <div class="col-lg-6">
                  <div class="form-group">
                    <switcher v-model="anosmia" label="Anosmia"></switcher>
                  </div>
                </div>
              </div>

              <div class="row mb-2 d-flex align-items-end">
                <div class="col-lg-6">
                  <div class="form-group">
                    <switcher v-model="dysgeucia" label="Disgeusia"></switcher>
                  </div>
                </div>
              </div>

            </div>

            <!-- Step 4 -->
            <div class="step-content">
              <h3 class="h4-responsive mb-3 black-alpha-50">Estudios realizados hoy</h3>

              <div class="row mb-2 d-flex align-items-end">
                <div class="col-lg-6">
                  <div class="form-group">
                    <switcher v-model="rxtx" label="Rx Tx"></switcher>
                  </div>
                </div>
              </div>

              <div class="row mb-2 d-flex align-items-end">
                <div class="col-lg-6">
                  <div class="form-group">
                    <switcher v-model="tac" label="TAC de tórax"></switcher>
                  </div>
                </div>
              </div>

              <div class="row mb-2 d-flex align-items-end">
                <div class="col-lg-6">
                  <div class="form-group">
                    <switcher v-model="ecg" label="ECG"></switcher>
                  </div>
                </div>
              </div>

              <div class="row mb-2 d-flex align-items-end">
                <div class="col-lg-6">
                  <div class="form-group">
                    <switcher v-model="pcr" label="PCR Covid"></switcher>
                  </div>
                </div>
              </div>

              <div class="row mb-2 d-flex align-items-end">
                <div class="col-lg-6">
                  <div class="form-group">
                    <switcher v-model="laboratory" label="Laboratorio"></switcher>
                  </div>
                </div>
              </div>
            </div>

            <!-- Step 4 -->
            <div class="step-content">
              <h3 class="h4-responsive mb-3 black-alpha-50">Tratamientos actuales</h3>
              <div class="row mb-2 d-flex align-items-start">
                <div class="col-12">
                  <h3 class="h6-responsive mb-3 black-alpha-40">Alimentación</h3>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Tipo de alimentación</label>
                    <select class="browser-default custom-select">
                      <option selected disabled>Seleccionar</option>
                      <option value="0">Oral</option>
                      <option value="1">Enteral</option>
                      <option value="2">Parenteral</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Nota de Alimentación</label>
                    <textarea rows="2" class="form-control"></textarea>
                  </div>
                </div>

                <div class="col-12">
                  <hr>
                </div>

                <div class="col-12">
                  <h3 class="h6-responsive mb-3 black-alpha-40">ATB</h3>
                </div>

                <div class="col-lg-4">
                  <div class="form-group">
                    <label>Farmaco</label>
                    <textarea rows="1" class="form-control"></textarea>
                  </div>
                </div>

                <div class="col-lg-4">
                  <div class="form-group">
                    <label>Dósis</label>
                    <textarea rows="1" class="form-control"></textarea>
                  </div>
                </div>

                <div class="col-lg-4">
                  <div class="form-group">
                    <label>Numero de días</label>
                    <input type="number" v-model="day_number" class="form-control">
                  </div>
                </div>

                <div class="col-12">
                  <hr>
                </div>
              </div>

              <div class="row mb-2 d-flex align-items-center">
                <div class="col-lg-6">
                  <div class="form-group">
                    <switcher v-model="thromboprophylaxis" label="Tromboprofilaxis"></switcher>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <textarea rows="1" class="form-control" :disabled="!thromboprophylaxis" placeholder="Descripción"></textarea>
                  </div>
                </div>
              </div>

              <div class="row mb-2 d-flex align-items-center">
                <div class="col-lg-6">
                  <div class="form-group">
                    <switcher v-model="dexamethasone" label="Dexametasona "></switcher>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <textarea rows="1" class="form-control" :disabled="!dexamethasone" placeholder="Descripción"></textarea>
                  </div>
                </div>
              </div>

              <div class="row mb-2 d-flex align-items-center">
                <div class="col-lg-6">
                  <div class="form-group">
                    <switcher v-model="gastric_protection" label="Protección gástrica"></switcher>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <textarea rows="1" class="form-control" :disabled="!gastric_protection" placeholder="Descripción"></textarea>
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
                    <textarea rows="1" class="form-control" :disabled="!dialysis" placeholder="Descripción"></textarea>
                  </div>
                </div>
              </div>

              <div class="row mb-2 d-flex align-items-center">
                <div class="col-lg-6">
                  <div class="form-group">
                    <switcher v-model="research_study" label="Participa en Estudio de Investigación"></switcher>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <textarea rows="1" class="form-control" :disabled="!research_study" placeholder="Descripción"></textarea>
                  </div>
                </div>
              </div>
            </div>

            <!-- Step 4 -->
            <div class="step-content">
              <h3 class="h4-responsive mb-3 black-alpha-50">Observación</h3>
              <div class="row mb-2 d-flex align-items-center">
                <div class="col-lg-12">
                  <div class="form-group">
                    <textarea rows="4" class="form-control" v-model="observations" placeholder="Opcional"></textarea>
                  </div>
                </div>
              </div>
            </div>

      </form>
      <!-- /.Stepper content -->

      <!-- Stepper control -->
      <div class="stepper-control">
        <span v-if="el > 1" class="btn btn-grey" @click="back()" v-waves>
          <i class="fas fa-chevron-left mr-2"></i>
          Atrás
        </span>
      
        <span v-if="notFinished()" class="btn button-success float-right" @click="next()" v-waves>
          {{next_text}}
          <i class="fas fa-chevron-right ml-2"></i>
        </span>

        <button v-else type="submit" class="btn button-success float-right" v-waves>
          {{next_text}}
        </button>

      </div>
    </div>
    <!-- /.Card body -->

  </div>
</template>

<script>
  import axios from 'axios'
  export default {
    name: 'Stepper',
    data () {
      return {
        el: 1,
        next_text: 'Siguiente',
        loading: false,
        message: '',
        steps: [
          {
            order: 1,
            name: 'Signos vitales',
          },
          {
            order: 2,
            name: 'Sistema respiratorio',
          },
          {
            order: 3,
            name: 'Otros síntomas',
          },
          {
            order: 4,
            name: 'Estudios realizados hoy',
          },
          {
            order: 5,
            name: 'Tratamientos actuales',
          },
          {
            order: 6,
            name: 'Observación',
          }
        ],
        date: Date.now(),
        time: '',
        temperature: 36.0,
        systolic_ta: 1,
        diastolic_ta: 1,
        fc: 1,
        fr: 1,
        ventilatory_mechanic_id: 1,
        ventilatory_mechanics: [],
        oxigen_requirement_id: 1,
        requires_oxigen: true,
        oxigen_requirements: [],
        oxigen_requirements_value: 0,
        oxigen_saturation: 1,
        pafi: false,
        pafi_value: 0,
        prone: false,
        cough: false,
        dyspnoea: 0,
        respiratory_irregularities: false,
        drowsiness: false,
        anosmia: false,
        dysgeucia: false,
        rxtx: false,
        tac: false,
        ecg: false,
        pcr: false,
        laboratory: false,
        thromboprophylaxis: false,
        dexamethasone: false,
        gastric_protection: false,
        dialysis: false,
        research_study: false,
        observations: '',
      }
    },
    methods: {
      setStep (val) {
        this.el = val
        this.next_text = (this.el == this.steps.length) ? 'Guardar evolución' : 'Siguiente';
        let steps = document.querySelectorAll('.step-content');
        for (var i = 0; i < steps.length; i++) {
          steps[i].classList.add('d-none')
        }
        steps[val - 1].classList.remove('d-none')
      },
      back () {
        if (this.el > 1) {
          this.setStep(--this.el)
        }
      },
      next () {
        if (this.el < this.steps.length) {
          this.setStep(++this.el)
        }
      },
      notFinished () {
        return (this.el < this.steps.length)
      },

      // resetForm () {
        // this.name = '';
      // },

      newEvolution () {
        const path = '/api/evolution/store'
        const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString()

        axios.post(path,
        {
          'patient_id': parseInt(this.patient_id),
          'vital_signs': this.vital_signs,
          'respiratory_system': this.respiratory_system,
          'other_sintoms': this.other_sintoms,
          'studies_of_the_day': this.studies_of_the_day,
          'current_treatments': this.current_treatments,
          'observations': this.observations,
        },
        {
          headers: {
            'Accept': 'application/json',
            'Authorization': AuthStr,
          }
        }).then((res) => {
          this.new_alert(res.data)
          if (res.data.status == 'success') {
            // this.resetForm();
            this.modal = false;
            this.$emit('reload-data');
          }
          console.log(res)
        }).catch((err) => {
          console.log(err)
        })
      }
    
    },
    mounted () {
      this.setStep(1)
    }
  }
</script>

<style scoped>
/*------------------------------------
  Stepper header
------------------------------------*/
.stepper .header {
  padding: 0;
  overflow: hidden;
}
.stepper .steps {
  text-align: center;
  justify-content: center;
  margin: 0 !important;
}
.stepper .step {
  cursor: pointer;
  display: inline-block;
  flex: 1;
  flex-grow: 1;
  padding: 20px .1em;
  width: auto;
}
.stepper .step-order {
  background: #f4f4f4;
  border-radius: 50px;
  display: inline-block;
  height: 30px !important;
  width: 30px !important;
  padding: 3px;
}
@media (max-width: 992px) {
  .stepper .step-name {
    display: block !important;
  }
}

/* Step hover & active */
.step:hover {
  background: #f7f9fa;
}
.step:active {
  background: #efefef;
}

/* Active step */
.stepper .step.active .step-order {
  background-color: var(--success);
  color: #fff;
}

/*------------------------------------
  Stepper content
------------------------------------*/

.stepper .stepper-content {
  min-height: 500px;
  padding: 2em .5em 1em .5em;
}

/*------------------------------------
  Transition
------------------------------------*/
.stepper .steps, .stepper .step {
  transition: .1s all !important;
}
</style>
