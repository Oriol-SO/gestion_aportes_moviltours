<template>
  <div >
    <v-card class="ma-3">
      <v-card-title>
        FORMULARIO DE REGISTRO 
      </v-card-title>
      <v-card-text>
        <form @submit.prevent="register" >
          <v-row>
            <v-col
            cols="12"
            md="6"
            >
              <v-text-field
              label="Nombre"
              outlined
              required
              v-model="form.name"
              ></v-text-field>
            </v-col>
            <v-col
            cols="12"
            md="6"
            >
              <v-text-field
              label="DNI"
              outlined
              required
              v-model="form.dni"
              ></v-text-field>
            </v-col>
            <v-col
            cols="12"
            md="6"
            >
              <v-text-field
              label="Telefono"
              outlined
              required
              v-model="form.telefono"
              ></v-text-field>
            </v-col>
            <v-col
            cols="12"
            md="6"
            >
              <v-text-field
              label="Correo electronico"
              outlined
              required
              type="email"
              v-model="form.email"
              ></v-text-field>
            </v-col>
            <v-col
            cols="12"
            md="6"
            >
              <v-text-field
              label="Contraseña"
              outlined
              type="password"
              required
              v-model="form.password"
              ></v-text-field>
            </v-col>
            <v-col
            cols="12"
            md="6"
            >
              <v-text-field
              label="Confirmar contraseña"
              outlined
              type="password"
              required
              v-model="form.password_confirmation"
              ></v-text-field>
            </v-col>
            <v-col
            cols="12"
            md="6"
            >
              <v-select
              label="Elije tu rol"
              outlined
              required
              :items="roles"
              item-text="nombre"
              item-value="id"
              v-model="form.rol"
              ></v-select>
            </v-col>

          </v-row>
          <v-row class="pa-3">
            <v-btn
            color="primary"
            type="submit"
            :loading="loader"
            >
              REGISTRAR
            </v-btn>
          </v-row>
        </form>
      </v-card-text>
    </v-card>
    <mensaje :msg="msg" v-if="msg"/>
  </div>
</template>

<script>
import Form from "vform";
 export default {

  data(){
    return{
      msg:'',
      form: new Form({
        name:'',
        email:'',
        dni:'',
        password:'',
        telefono:'',
      }),
      loader:false,
      roles:[
        {id:1,nombre:'SOCIO COMISIONISTA'},
        {id:2, nombre:'CONTROLADOR'},
        {id:3, nombre:'ADMINISTRADOR'},
      ]
    }
  },methods:{
    register(){
      this.msg='';
      this.form.post('/api/register').then(response=>{
        this.form.reset();
        this.msg='Registro exitoso, inicie sesión';
      }).catch(e=>{})
    }
  }
 }
</script>
