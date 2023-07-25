<template>
    <v-dialog
    v-model="dialog"
    max-width="700"
    >
    <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
          class="ml-auto"
        >
          Agregar veiculo
        </v-btn>
    </template>
    <v-card>
        <v-card-title>
            Agregar un nuevo veiculo
        </v-card-title>
        <v-card-text>
            <form @submit.prevent="register">
                <v-row>
                    <v-col cols="12" md="6">
                        <v-text-field
                        label="Dale un nombre a tu veiculo"
                        required
                        v-model="form.nombre"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field
                        label="Placa"
                        v-model="form.placa"
                        required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field
                        label="Color"
                        v-model="form.color"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field
                        label="Marca"
                        v-model="form.marca"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field
                        label="Modelo"
                        v-model="form.modelo"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-card-actions>
                    <v-btn
                    color="primary"
                    type="submit"

                    >
                        Guardar
                    </v-btn>
                </v-card-actions>
            </form>
        </v-card-text>
    </v-card>
    
    </v-dialog>
</template>

<script>
import { Form } from 'vform';

export default{
    name:'addveiculo',
    data(){
        return{
            dialog:false,
            form: new Form({
                nombre:'',
                placa:'',
                color:'',
                marca:'',
                modelo:'',
            }),
        }
    },methods:{
        register(){
            this.form.post('/api/registrar-veiculo').then(response=>{
                this.form.reset();
                this.dialog=false;
                this.$store.dispatch('socio/getVeiculos')
            }).catch(e=>{})
        }
    }
}
</script>