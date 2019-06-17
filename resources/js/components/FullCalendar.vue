<template>
<div>
<div class="container col-md-10 col-sm-10">
  <div class="card">
    <div class="card-header ">
      <h3 class="card-title my-auto">Lista de Materiales</h3>
      <div class="card-tools">
                  <button class="btn btn-tool btn-sm" @click="showSearch()">
                    <i class="fa fa-search"></i>
                  </button>
        </div>
    </div>
    <div class="card-body">
        <div class='calendar'>
          <div :class="{'d-none' : visible}" >
              
            <div class="col-auto">
              <label class="sr-only" for="inlineFormInputGroup"></label>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-calendar"></i>
                  </div>
                </div>
                <input type="date" v-model="goTo" class="form-control" @input="goToDate(goTo)">
              </div>
            </div>
            <!--/form imput -->

            <div class="col-auto">
              <label class="sr-only" for="inlineFormInputGroup"></label>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-truck"></i>
                  </div>
                </div>

                <select class="form-control" v-model="filter" @change="getEvents(filter)">
                  <option value="">Seleccione Contratista...</option>
                  <option v-for="cont in contratistas"  :key="cont.id" :value="cont" v-text="cont.nombre"></option>
                </select>

              </div>
            </div>
            <!--/form imput -->
                      
          </div>
          <FullCalendar
          :key="refresh"
            class='calendar-render'
            ref="fullCalendar"
            defaultView="dayGridMonth"
            :header="{
              left: 'prev,next',
              center: 'title',
              right: 'today'
            }"
            :plugins="calendarPlugins"
            :weekends="calendarWeekends"
            :events="calendarEvents"
            @dateClick="handleDateClick"
            @eventClick ="handleEventClick"
            />
        </div>
    </div>
  </div>

  

  </div>

  <!-- Modal -->
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" :class="{'mostrar' : modal}">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header" >
                <h5 class="modal-title"  v-text="tituloModal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="cerrarModal()">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                  <table class="table table-bordered">
                        <thead class="thead-dark">
                          <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Cantidad</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="consumo in consumos" :key="consumo.id">
                            <td>{{consumo.codigo}}</td>
                            <td>{{consumo.descripcion}}</td>
                            <td>{{consumo.consumo}}</td>
                          </tr>
                        </tbody>
                    </table>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="cerrarModal()">Close</button>
                <button type="button"   class="btn btn-primary">
                  <i class="fas fa-edit"></i> Editar
                </button>
              </div>
            </div>
          </div>
        </div>
        <!--/modal-->


</div>
</template>

<script>
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
//import { parseEvents } from '@fullcalendar/core/structs/event-store';

export default {
  components: {
    FullCalendar // make the <FullCalendar> tag available
  },
  data: function() {
    return {
      modal: 0,
      tituloModal: '',
      events: [],
      contratistas: [],
      contr: this.$attrs.cur_cont,
      selected: {},
      consumos: {},
      goTo: '',
      filter: [],
      filterData: {},
      hasCont: '',
      refresh: 0,
      visible: 1,

      calendarPlugins: [ // plugins must be defined in the JS
        dayGridPlugin,
        timeGridPlugin,
        interactionPlugin // needed for dateClick
      ],
      calendarWeekends: true,
      calendarEvents: []
    }
  },

  methods: {
    
    handleDateClick(arg) {
      
    },

    goToDate(date){
      this.$refs.fullCalendar.getApi().gotoDate(date);
    },

    handleEventClick(info){
      this.selected = this.events.filter((obj)=>{
          return obj.id == info.event.id;
        }).pop();
      
        this.consumos = JSON.parse(this.selected.datos_consumo);
        this.tituloModal = this.selected.contratista[0].nombre + ' ' + new Date(this.selected.fecha + ' ').toLocaleDateString('es-AR');
        console.log(this.selected);
        
        this.abrirModal();

    },

    abrirModal(){
      this.modal = 1;
    },
    cerrarModal(){
      this.modal = 0;
    },

    parses(events){
      this.calendarEvents = [];
        for (let index = 0; index < events.length; index++) {
          this.calendarEvents.push({
            id: this.events[index].id,
            title: this.events[index].contratista[0].nombre,
            start: this.events[index].fecha,
            allDay: 'true',
            color: this.events[index].contratista[0].color,

          });
          
        }
    },

    getEvents(){
      let me = this;
      var date = me.$refs.fullCalendar.getApi().getDate();
      var month = date.getMonth();
      var uri = '';
      var id_cont = me.contratista == undefined ? '' : me.contratista;
      
      id_cont = me.filter.id == undefined ? '' : me.filter.id;

      if(me.contr[0] != null || me.contr[0] != undefined){
        uri = '/consumo/fecha/' + (month +1) + '/' + me.contr[0].id;
      } else{
        uri = '/consumo/fecha/' + (month +1) + '/' + id_cont;
      }
            axios.get(uri)
                .then(function (response) {
                    
                    me.events = response.data;
                    
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                    me.parses(me.events);
                });
      },


      getContratistas(){
        let me = this;

          axios.get('/contratistas/listar')
                .then(function (response) {
                    
                    me.contratistas = response.data;
                    
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
      },


      showSearch(){
        this.visible++;
        this.visible = this.visible%2;
      }

  },

  mounted() {
      this.getEvents();
      this.getContratistas();
    },
  
}
</script>

<style lang='scss'>
// you must include each plugins' css
// paths prefixed with ~ signify node_modules
@import '~@fullcalendar/core/main.css';
@import '~@fullcalendar/daygrid/main.css';
@import '~@fullcalendar/timegrid/main.css';

.calendar {
  font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
  font-size: 14px;
}
.calendar-top{
  margin: 0 0 3em;
}
.calendar-render {
  margin: 0 auto;
  max-width: 900px;
}
.modal-content{
  width: 100% !important;
  position: absolute !important;
}
  .mostrar{
    display: list-item !important;
    opacity: 1 !important;
    position: absolute !important;
    background-color: #3c29297A;

  }

</style>