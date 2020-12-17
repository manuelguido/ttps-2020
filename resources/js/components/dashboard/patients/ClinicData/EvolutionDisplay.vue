<template>
  <div>
    <mdb-btn color="primary" class="p-1" @click.native="modal = true"
      ><i class="fad fa-external-link-alt mr-3"></i>Ver</mdb-btn
    >
    <mdb-modal :show="modal" @close="modal = false" size="lg" scrollable>
      <mdb-modal-header>
        <mdb-modal-title>Evolución</mdb-modal-title>
      </mdb-modal-header>
      <mdb-modal-body>
        <h1 class="h5 black-alpha-30 mb-5 text-center">
          {{ evolution.created_at | formatDateFull }} -
          {{ evolution.created_at | moment("h:mm a") }}
        </h1>

        <div class="row justify-content-center">
          <div class="col-12 col-lg-10 col-xl-7">
            <!-- Signos vitales -->
            <div class="mb-5">
              <p class="h5 black-alpha-40">Signos vitales</p>
              <info-data data="Temperatura" :value="evolution.temperature" />
              <info-data data="TA Sistólica" :value="evolution.systolic_ta" />
              <info-data data="TA Distólica" :value="evolution.diastolic_ta" />
              <info-data data="Frecuencia Cardíaca" :value="evolution.heart_rate" />
              <info-data data="Frecuencia Respiratoria" :value="evolution.breathing_rate" />
            </div>
            <!-- /.Signos vitales -->

            <!-- Sistema respiratorio -->
            <div class="mb-5">
              <p class="h5 black-alpha-40">Sistema respiratorio</p>
              <info-data data="Mecánica respiratoria" :value="formatNullable(evolution.ventilatory_mechanic)" />
              <info-data data="Requiere oxígeno" :value="formatNullable(evolution.requires_oxigen)" />
              <div v-if="!evolution.requires_oxigen">
                <info-data data="Tipo de oxigeno requerido" :value="formatNullable(evolution.oxigen_requirement_type)" />
                <info-data data="Valor (Tipo de oxigeno requerido)" :value="formatNullable(evolution.oxigen_requirement_value)" />
                <info-data data="Saturación de oxégeno" :value="formatNullable(evolution.oxigen_saturation)" />
                <info-data data="PaFi" :value="formatNullable(evolution.pafi)" />
                <info-data data="Valor de PaFi" :value="formatNullable(evolution.pafi_value)" />
                <info-data data="Prono" :value="formatNullable(evolution.prone)" />
                <info-data data="Tos" :value="formatNullable(evolution.cough)" />
                <info-data data="Disnea" :value="formatNullable(evolution.dyspnoea)" />
                <info-data data="Estabilidad/Desaparición de sintomas" :value="formatNullable(evolution.respiratory_irregularities)" />
              </div>
            </div>
            <!-- /.Sistema respiratorio -->

            <!-- Otros síntomas -->
            <div class="mb-5">
              <p class="h5 black-alpha-40">Otros síntomas</p>
              <info-data data="Somnolencia" :value="formatNullable(evolution.drowsiness)" />
              <info-data data="Anosmia" :value="formatNullable(evolution.anosmia)" />
              <info-data data="Disgeusia" :value="formatNullable(evolution.dysgeucia)" />
            </div>
            <!-- /.Otros síntomas -->

            <!-- Estudios realizados en el día -->
            <div class="mb-5">
              <p class="h5 black-alpha-40">Estudios realizados en el día</p>
              <info-data data="RxTx" :value="formatNullable(evolution.rxtx)" />    
              <info-data v-if="evolution.rxtx" data="Tipo (RxTx)" :value="formatNullable(evolution.rxtx_studies)" />
              <info-data v-if="evolution.rxtx_studies == 2" data="Descripción (RxTx)" :value="formatNullable(evolution.rxtx_text)" />
              
              <info-data data="Tac de tórax" :value="formatNullable(evolution.tac)" />    
              <info-data v-if="evolution.tac" data="Tipo (Tac de Tórax)" :value="formatNullable(evolution.tac_studies)" />
              <info-data v-if="evolution.tac_studies == 2" data="Descripción (Tac de Tórax)" :value="formatNullable(evolution.tac_text)" />
              
              <info-data data="ECG" :value="formatNullable(evolution.ecg)" />    
              <info-data v-if="evolution.ecg" data="Tipo (ECG)" :value="formatNullable(evolution.ecg_studies)" />
              <info-data v-if="evolution.ecg_studies == 2" data="Descripción (ECG)" :value="formatNullable(evolution.ecg_text)" />
              
              <info-data data="PCR Covid" :value="formatNullable(evolution.pcr)" />    
              <info-data v-if="evolution.pcr" data="Tipo (PCR Covid)" :value="formatNullable(evolution.pcr_studies)" />
              <info-data v-if="evolution.pcr_studies == 2" data="Descripción (PCR Covid)" :value="formatNullable(evolution.pcr_text)" />
              
              <info-data data="Laboratorio" :value="formatNullable(evolution.laboratory)" />
            </div>
            <!-- /.Estudios realizados en el día -->

            <!-- Tratamientos actuales -->
            <div class="mb-5">
              <p class="h5 black-alpha-40">Tratamientos actuales</p>
              <info-data data="Tipo de alimentación" :value="formatNullable(evolution.feeding_type)" />
              <info-data data="Nota de alimentación" :value="formatNullable(evolution.feeding_note)" />
              <info-data data="Fármaco" :value="formatNullable(evolution.drug)" />
              <info-data data="Dósis" :value="formatNullable(evolution.drug_dosis)" />
              <info-data data="Número de días" :value="formatNullable(evolution.dosis_day_number)" />

              <info-data data="Tromboprofilaxis" :value="formatNullable(evolution.thromboprophylaxis)" />    
              <info-data v-if="evolution.thromboprophylaxis" data="Descripción (Tromboprofilaxis)" :value="formatNullable(evolution.thromboprophylaxis_data)" />

              <info-data data="Dexametasona" :value="formatNullable(evolution.dexamethasone)" />    
              <info-data v-if="evolution.dexamethasone" data="Descripción (Dexametasona)" :value="formatNullable(evolution.dexamethasone_data)" />

              <info-data data="Protección gástrica" :value="formatNullable(evolution.gastric_protection)" />    
              <info-data v-if="evolution.gastric_protection" data="Descripción (Protección gástrica)" :value="formatNullable(evolution.gastric_protection_data)" />
              
              <info-data data="Diálisis" :value="formatNullable(evolution.dialysis)" />    
              <info-data v-if="evolution.dialysis" data="Descripción (Diálisis)" :value="formatNullable(evolution.dialysis_data)" />

              <info-data data="Participa en Estudio de Investigación" :value="formatNullable(evolution.research_study)" />    
              <info-data v-if="evolution.research_study" data="Descripción (Participa en Estudio de Investigación)" :value="formatNullable(evolution.research_study_data)" />
            </div>
            <!-- /.Tratamientos actuales -->

            <!-- Observaciones -->
            <div class="mb-5">
              <p class="h5 black-alpha-40">Observaciones</p>
              <p>{{formatText(evolution.observations)}}</p>
            </div>
            <!-- /.Observaciones -->

          </div>
        </div>
      </mdb-modal-body>
      <mdb-modal-footer class="d-flex justify-content-center">
        <mdb-btn
          color="secondary"
          class="btn-block"
          @click.native="modal = false"
          >Cerrar</mdb-btn
        >
        <!-- <mdb-btn color="primary">Save changes</mdb-btn> -->
      </mdb-modal-footer>
    </mdb-modal>
  </div>
</template>

<script>
import {
  mdbModal,
  mdbModalHeader,
  mdbModalTitle,
  mdbModalBody,
  mdbModalFooter,
  mdbBtn,
} from "mdbvue";
export default {
  components: {
    mdbModal,
    mdbModalHeader,
    mdbModalTitle,
    mdbModalBody,
    mdbModalFooter,
    mdbBtn,
  },
  props: {
    evolution: {
      type: Object,
    },
  },
  data() {
    return {
      modal: false,
    };
  },
  methods: {
    formatNullable(value){
      if (value == null) {
        return "N/a";
      } else if (value == false) {
        return "No";
      } else {
        return "Si";
      }
    },

    formatText(value){
      if (!value) {
        return "N/a";
      } else {
        return value;
      }
    }
  }
};
</script>
