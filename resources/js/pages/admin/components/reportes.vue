<template>
    <v-dialog
    v-model="dialog"
    max-width="700"
    >
    <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="green accent-3"
          dark
          class="ml-auto"
          v-bind="attrs"
          v-on="on"
        >
          Reportes
        </v-btn>
    </template>
    <v-card>
        <v-card-title>
            Generador de reportes
        </v-card-title>
        <v-card-text>
            <v-row justify="space-around">
                <v-date-picker
                v-model="form.mes"
                color="warning"
                :show-current="false"
                type="month"
                ></v-date-picker>
                <v-card elevation="0" justify-center>
                    <v-btn color="green darken-3" dark  @click="exportar()">Exportar a EXCEL</v-btn>
                </v-card>
            </v-row>
        </v-card-text>
    </v-card>
    </v-dialog>
</template>
<script>
import { Form } from 'vform';


export default{

    data(){
        return{
            dialog:false,
            form: new Form({
                mes: new Date().toISOString().substr(0, 7),
            })
        }
    },methods:{
        exportar(){
            this.form.post('/api/genera-reporte-mes',{ headers: { },
                'responseType': 'blob' 
            }).then(response=>{    
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    console.log(url);
                    link.href = url;
                    link.setAttribute('download', 'aportes.xlsx');
                    document.body.appendChild(link);
                    link.click();
            }).catch(error=>{
                console.log('error');
            })
        }
    }
}
</script>