<template>
    <div>
        <v-card class="ma-3" >
            <v-card-title>
              {{ buscarveiculo }}
              {{ buscarprimerveiculo }}
                TUS APORTACIONES   <addveiculo />
            </v-card-title>
            <v-card-text>
              <v-row>
                <v-select
                class="mx-5"
                :items="veiculos"
                label="Selecciona un veiculo"
                item-text="nombre"
                item-value="id"
                v-model="selectveiculo"
                return-object
                >
                </v-select>
          
              </v-row>
              <v-row class="mx-5" v-if="selectveiculo">
                <v-col cols="12" md="4" class="pa-0 ma-0">
                  <strong>Nombre:</strong> {{ selectveiculo.nombre }} 
                </v-col>
                <v-col cols="12" md="4" class="pa-0 ma-0">
                  <strong>Placa:</strong> {{ selectveiculo.placa }}
                </v-col>
                <v-col cols="12" md="4" class="pa-0 ma-0">
                  <strong>Color:</strong> {{ selectveiculo.color }} 
                </v-col>
                <v-col cols="12" md="4" class="pa-0 ma-0">
                  <strong>Marca:</strong> {{ selectveiculo.marca }}
                </v-col>
                <v-col cols="12" md="4" class="pa-0 ma-0">
                  <strong>Modelo:</strong> {{ selectveiculo.modelo }}
                </v-col> 
              </v-row>       
            </v-card-text>
            <v-card-text v-if="selectveiculo">
              <aportaciones :veiculo="veiculo"/>
            </v-card-text>
        </v-card>
    </div>
</template>
<script>
import addveiculo from './components/addveiculo.vue'
import aportaciones from './components/aportaciones.vue'

import {mapGetters,mapActions} from 'vuex'
export default {
  components:{
    addveiculo,
    aportaciones,
  },

  data(){
    return{
      selectveiculo:null,
    }
  },computed:{
    ...mapGetters({
      veiculos:'socio/veiculos',
      veiculo:'socio/infoveiculo',
    }),
    buscarveiculo(){
      this.selectveiculo=this.veiculos[0];
    },
    buscarprimerveiculo(){
      this.infoveiculo(this.selectveiculo)
    }
  },methods:{
    ...mapActions('socio',['getVeiculos','getinfoveiculo']),

    async infoveiculo(veiculo){
      await this.getinfoveiculo(veiculo);
    }
  },created(){
    this.getVeiculos();
  }

}
</script>