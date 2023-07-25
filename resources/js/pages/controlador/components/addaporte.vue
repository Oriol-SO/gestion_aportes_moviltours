<template>
    <v-dialog
    v-model="dialog"
    max-width="1200"
    >
    <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="primary"
          dark
          small
          class="text-capitalize"
          v-bind="attrs"
          v-on="on"
        >
          Añadir aporte
        </v-btn>
    </template>
    <v-card>
        <v-card-title>
            Aportes del veiculo
        </v-card-title>
        <v-card-text>
            <v-row class="pa-0 ma-0">
                <v-col cols="12" md="3" class="pa-0">
                    <strong>Socio: {{ veiculo.socio_nombre }}</strong> 
                </v-col>
                <v-col cols="12" md="3" class="pa-0">
                    <strong>placa veiculo: {{ veiculo.placa }}</strong> 
                </v-col>
                <v-col cols="12" md="3" class="pa-0">
                    <strong>DNI: {{ veiculo.socio_dni }}</strong> 
                </v-col>
                <v-col cols="12" md="3" class="pa-0">
                    <strong>Telefono: {{ veiculo.socio_telefono }}</strong> 
                </v-col>
                <v-col cols="12" md="3" class="pa-0">
                    <strong>Color: {{ veiculo.color }}</strong> 
                </v-col>
                <v-col cols="12" md="3" class="pa-0">
                    <strong>Marca: {{ veiculo.marca }}</strong> 
                </v-col>
                <v-col cols="12" md="3" class="pa-0">
                    <strong><Meta></Meta>Modelo: {{ veiculo.modelo }}</strong> 
                </v-col>
            </v-row>   
        </v-card-text>
        <v-card-text>
            <aportaciones :veiculo="veiculo" />
        </v-card-text>
    </v-card>
    </v-dialog>
</template>

<script>
import aportaciones from './aportes.vue'
export default{
    props:{
        veiculo:{default:null}
    },    
    components:{
        aportaciones,
    },
    data(){
        return{
            dialog:false,
        }
    }
}
</script>