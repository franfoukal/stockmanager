<template>
<div>
<div class="container col-md-7">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Lista de Materiales</h3>
    </div>
    <div class="card-body">
        <div class='calendar'>
          <div class='calendar-top'>
            <button @click="toggleWeekends">toggle weekends</button>
            <button @click="gotoPast">go to a date in the past</button>
            (also, click a date/time to add an event)
          </div>
          <FullCalendar
            class='calendar-render'
            ref="fullCalendar"
            defaultView="dayGridMonth"
            :header="{
              left: 'prev,next today',
              center: 'title',
              right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
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

  <div class="alert alert-primary" role="alert">
  A simple primary alert—check it out!
  </div>

  </div>

  <!-- Modal -->
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" :class="{'mostrar' : modal}">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"  v-text="tituloModal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="cerrarModal()">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                <!--div class="alert alert-warning" v-if="error==1">
                  <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                  <p v-for="(errores, index) in msjesError" :key="index">{{errores}}</p>
                </div-->

                <form action="">

                  <!-- form imput -->
                  <div class="col-auto">
                    <label class="sr-only" for="inlineFormInputGroup">Código</label>
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-barcode"></i>
                        </div>
                      </div>
                      <input type="text" class="form-control"  placeholder="Código">
                    </div>
                  </div>
                  <!--/form imput -->
                  <div class="col-auto">
                    <label class="sr-only" for="inlineFormInputGroup">Descripcion</label>
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-align-left"></i>
                        </div>
                      </div>
                      <input type="text" class="form-control"  placeholder="Descripción">
                    </div>
                  </div>
                  <!--/form imput -->

                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="cerrarModal()">Close</button>
                <button type="button"  class="btn btn-primary">
                  <i class="fas fa-save"></i> Guardar
                </button>
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

export default {
  components: {
    FullCalendar // make the <FullCalendar> tag available
  },
  data: function() {
    return {
      modal: 0,
      tituloModal: 'Ingrese Consumo',
      events: [],

      calendarPlugins: [ // plugins must be defined in the JS
        dayGridPlugin,
        timeGridPlugin,
        interactionPlugin // needed for dateClick
      ],
      calendarWeekends: true,
      calendarEvents: [ // initial event data
        { title: 'Event Now', start: new Date() },
        { title: 'event 2', date: '2019-05-02' }
      ]
    }
  },
  methods: {
    toggleWeekends()   {
      this.calendarWeekends = !this.calendarWeekends // update a property
    },
    gotoPast() {
      let calendarApi = this.$refs.fullCalendar.getApi() // from the ref="..."
      calendarApi.gotoDate('2000-01-01') // call a method on the Calendar object
    },
    handleDateClick(arg) {
      if (confirm('Would you like to add an event to ' + arg.dateStr + ' ?')) {
        this.calendarEvents.push({ // add new event data
          title: 'New Event',
          start: arg.date,
          allDay: arg.allDay
        })
      }
    },

    handleEventClick(info){
      this.getEvents();
    },

    abrirModal(){
      this.modal = 1;
    },
    cerrarModal(){
      this.modal = 0;
    },

    getEvents(){
      let me = this;
      var date = me.$refs.fullCalendar.getApi().getDate();
      var month = date.getMonth();
      var uri = '/consumo/fecha/' + (month +1);
            axios.get(uri)
                .then(function (response) {
                    
                    me.events = response.data;

                    console.log(response);
                    console.log(month+1);
                
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
    }

  }
  
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