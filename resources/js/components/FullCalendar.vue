<template>
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
            />
        </div>
    </div>
  </div>
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
    toggleWeekends() {
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
</style>