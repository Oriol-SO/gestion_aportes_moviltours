
<template>
    <v-row class="fill-height">
        <v-col>
        <v-sheet height="64">
            <v-toolbar
            flat
            >
            <v-btn
                outlined
                class="mr-4"
                color="grey darken-2"
                @click="setToday"
            >
                Hoy
            </v-btn>
            <v-btn
                fab
                text
                small
                color="grey darken-2"
                @click="prev"
            >
                <v-icon small>
                mdi-chevron-left
                </v-icon>
            </v-btn>
            <v-btn
                fab
                text
                small
                color="grey darken-2"
                @click="next"
            >
                <v-icon small>
                mdi-chevron-right
                </v-icon>
            </v-btn>
            <v-toolbar-title v-if="$refs.calendar">
                {{ $refs.calendar.title }}
            </v-toolbar-title>
            <v-spacer></v-spacer>
            </v-toolbar>
        </v-sheet>
        <v-sheet height="600">
            <v-calendar
            ref="calendar"
            v-model="focus"
            color="primary"
            :events="events"
            :event-color="getEventColor"
            :type="type"
            @change="updateRange"
            @click:date="viewDay"
            @click:more="vermas"
            @click:event="showEvent"
            ></v-calendar>
                <v-menu
                v-model="selectedOpen"
                :close-on-content-click="false"
                :activator="selectedElement"
                offset-x
                >
                    <v-card>
                        <v-card-title>
                            Aporte del {{ getfechatitle(focus) }}
                        </v-card-title>
                        <v-card-text>
                            <v-text-field
                            label="Monto"
                            v-model="form.monto"
                            ></v-text-field>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn
                            @click="guardarmonto()"
                            small
                            color="primary"
                            >
                                Guardar
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-menu>
                <v-menu
                v-model="detailsopen"
                :close-on-content-click="false"
                :activator="selectitem"
                offset-x
                >
                    <v-card>
                        <v-card-title>
                            <strong>Detalles del aporte <span v-html="aporteEvent.fecha"></span></strong>
                        </v-card-title>
                        <v-card-text>
                            <strong>Registrado por : <span v-html="aporteEvent.rol"></span></strong> <br>
                            <strong>Monto: <span v-html="aporteEvent.monto"></span> </strong> <br>
                            <strong>registro: <span v-html="aporteEvent.registro"></span> </strong> <br>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn small rounded color="error" @click="eliminarmonto(aporteEvent)">Eliminar</v-btn>
                        </v-card-actions>
                       
                    </v-card>
                </v-menu>
        </v-sheet>
        </v-col>
    </v-row>
</template>
<script>
import Form from 'vform'
export default {
    props:{
    veiculo:{default:null},
    },
    data: () => ({
        focus: '',
        type: 'month',
        selectedEvent: {},
        aporteEvent:{},
        selectedElement: null,
        selectedOpen: false,

        detailsopen:false,
        selectitem:null,

        events: [],
        colors: ['primary', 'warning', 'error'],
        names: ['Control','Admin','x'],

        form: new Form({
            monto:1.5,
            fecha:null,
            veiculo:null,
        }),
        formdel: new Form({
            veiculo:'',
            aporte_id:'',
        }),
    }),
    mounted () {
        this.$refs.calendar.checkChange()
    },
    methods: {
        showEvent ({ nativeEvent, event }) {
            const open = () => {
            this.aporteEvent = event
            this.selectitem = nativeEvent.target
            requestAnimationFrame(() => requestAnimationFrame(() => this.detailsopen = true))
            }

            if (this.detailsopen) {
            this.detailsopen = false
            requestAnimationFrame(() => requestAnimationFrame(() => open()))
            } else {
            open()
            }

            nativeEvent.stopPropagation()
        },
        viewDay ({ date, nativeEvent, event  }) {
            this.focus = date
            const open = () => {
            this.selectedEvent = event
            this.selectedElement = nativeEvent.target
            requestAnimationFrame(() => requestAnimationFrame(() => this.selectedOpen = true))
            }

            if (this.selectedOpen) {
            this.selectedOpen = false
            requestAnimationFrame(() => requestAnimationFrame(() => open()))
            } else {
            open()
            }

            nativeEvent.stopPropagation()
        },
        vermas({date}){
            this.focus=date
            this.type='month'
        },
        getEventColor (event) {
        return event.color
        },
        setToday () {
        this.focus = ''
        this.type='month'
        },
        prev () {
        this.$refs.calendar.prev()
        },
        next () {
        this.$refs.calendar.next()
        },

        updateRange () {
            const events = []

            this.veiculo.aportaciones.forEach(element => {
                const fechaParts = element.fecha.split('-');
                const first = new Date(fechaParts[0], fechaParts[1] - 1, fechaParts[2]);

                const creacion = new Date(element.created_at);
                    events.push({
                        name: 'aportado',
                        start: first,
                        color:element.rol==1?'green':'primary',
                        hora:`${creacion.getHours()}:${creacion.getMinutes()}`,
                        rol:element.rol==1?'Controladora':'Administrador',
                        del:true,
                        monto:element.monto,
                        registro: element.created_at,
                        fecha:element.fecha_visual,
                        id:element.id,
                    })

                });
        
            this.events = events
        },
        getfechatitle(f){
            const fecha = f.split('-');
            const nombresMeses = [
            "enero", "febrero", "marzo", "abril", "mayo", "junio",
            "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"
            ];
            const nombreMes = nombresMeses[parseInt(fecha[1])-1];
            return `${fecha[2]} de ${nombreMes} ${fecha[0]}`;
        },

        guardarmonto(){
            this.form.fecha=this.focus;
            this.form.veiculo=this.veiculo.id;
            this.form.post('/api/registrar-aporte').then(response=>{
                this.$store.dispatch('control/getVeiculos')
                this.selectedOpen=false;
            }).catch(e=>{

            })
        },
        eliminarmonto(aporte){
           this.formdel.aporte_id=aporte.id;
           this.formdel.veiculo=this.veiculo.id;
           this.formdel.post('/api/del-aporte-veiculo').then(response=>{
                this.$store.dispatch('control/getVeiculos')
                this.detailsopen=false;
           }).catch(e=>{

           })
        }
    },watch:{
        veiculo(nuevo){
            this.updateRange()
        }
    }
}
</script>