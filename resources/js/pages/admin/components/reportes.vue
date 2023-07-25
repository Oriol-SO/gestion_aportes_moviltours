<template>
    <v-dialog
    v-model="dialog"
    max-width="1600"
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
            
        </v-card-text>
    </v-card>
    </v-dialog>
</template>
<script>

export default{

    data(){
        return{
            dialog:false,
        }
    }
}
</script>