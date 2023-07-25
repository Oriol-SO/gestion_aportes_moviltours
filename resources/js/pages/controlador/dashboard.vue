<template>
    <div>
        <v-card class="ma-3" >
            <v-card-title>
                Control de veiculos en circulación
            
            </v-card-title>
            <v-card-title>
              <v-text-field
              v-model="search"
              color="orange"
              label="Buscar el  veiculo"
              ></v-text-field>
            </v-card-title>
            <v-card-text>
                <v-data-table
                    :search="search"
                    :headers="headers"
                    :items="veiculos"
                    :items-per-page="15"
                    class="elevation-1"
                >
                    <template v-slot:item.actions="{ item }">
                        <addaporte :veiculo="item" />
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>
    </div>
</template>
<script>
import addaporte from './components/addaporte.vue'
import {mapGetters,mapActions} from 'vuex'
export default {
  components:{
    addaporte
  },
  data(){
    return{
        search:'',
        headers:[
          { text: 'Socio', value: 'socio_nombre' },
          { text: 'Placa', value: 'placa' },
          { text: 'Dni',   value: 'socio_dni' },
          { text: 'Color', value: 'color' },
          { text: 'Marca', value: 'marca' },
          { text: 'Modelo', value: 'modelo' },
          { text: '', value: 'actions' },
        ],
    }
  },computed:{
    ...mapGetters({
      veiculos:'control/veiculos',
    }),
  },methods:{
    ...mapActions('control',['getVeiculos']),
  },created(){
    this.getVeiculos();
  }

}
</script>