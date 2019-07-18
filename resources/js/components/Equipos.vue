<template>
<div class="component">
    <div class="container col-md-8">
        <div class="alert alert-warning alert-dismissible" v-if="error.length > 0">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" @click="error=[]">×</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
            <p v-for="(e, index) in error" :key="index">{{e}}</p>
        </div>

        <div class="card collapse show">
            <div class="card-header">
                <div class="row">
                    <p class="card-title my-auto col">Carga de equipos</p>
                    <div class="d-none d-sm-inline-flex mr-2">
                        <input type="date" class="form-control col-6 mr-2" v-model="equipos.fecha" >
                        
                        <select class="custom-select col-6 mr-2" v-model="equipos.contratista" v-if="$attrs.cur_cont[0] !== undefined">
                            <option  v-if="$attrs.cur_cont[0] !== undefined" :value="$attrs.cur_cont[0].id" selected> {{$attrs.cur_cont[0].nombre}}</option>
                        </select>
                        
                        <select class="custom-select col-6 mr-2" v-model="equipos.contratista" v-else>
                            <option  v-for="contratista in contratistas" :key="contratista.id" :value="contratista.id">
                            {{contratista.nombre}}
                            </option>
                        </select>
                    </div>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-widget="collapse" @click="formDisplay = !formDisplay"><i :class="formDisplay ? 'fas fa-minus' :'fas fa-plus'"></i></button>
                        </div>
                        <!-- /.card-tools -->
                </div>  

                <div class="d-sm-none">
                    <input type="date" class="form-control my-1" v-model="equipos.fecha" >
                    <select class="custom-select" v-model="equipos.contratista" v-if="$attrs.cur_cont[0] !== undefined">
                            <option  v-if="$attrs.cur_cont[0] !== undefined" :value="$attrs.cur_cont[0].id" selected> {{$attrs.cur_cont[0].nombre}}</option>
                        </select>
                        
                        <select class="custom-select mr-2" v-model="equipos.contratista" v-else>
                            <option  v-for="contratista in contratistas" :key="contratista.id" :value="contratista.id">
                            {{contratista.nombre}}
                            </option>
                        </select>
                </div>

            </div>
            
            <div class="card-body">
                <!--form-->
                <form class="form col-md-10  mx-auto" @submit.prevent="">
                    
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-file-signature"></i>
                                </span>
                            </div>
                            <input 
                                type="text" 
                                class="form-control" 
                                required
                                placeholder="Orden Nº.:" 
                                v-model.number="input.OT" 
                                @input="validateData(0,0,3)"
                                :class="{'invalid' : !validation.OT && !isEmpty(input.OT)}"    
                            >
                        </div>

                        <div class="input-group mb-2 has-icon">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-truck"></i>
                                </span>
                            </div>
                            <input 
                                type="text" 
                                class="form-control" 
                                required
                                placeholder="Tecnico WFX:" 
                                v-model="input.movil" 
                                @input="validateData(0,0,4)"
                                :class="{'invalid' : !validation.movil && !isEmpty(input.movil)}"
                            > 
                            <i class="fas fa-thumbtack my-auto form-control-icon" :class="{'text-success' : rememberMovil}" @click="toogleRememberMovil()"></i>
                        </div>

                        
                        <div class="btn-group mt-2">
                            <button class="col btn btn-dark" @click="saveOT(input)" value="Guardar OT">Siguiente OT</button>
                            <button class="col btn btn-success" @click="addInputsRow()">Agregar equipos</button>
                        </div>

                    <hr>

                    <div class="row">
                        <i class="fas fa-barcode text-xl ml-3 mr-3 mb-2"> </i>  
                        <p class="text-lg my-auto">Serializables</p>
                    </div>

                    <ul class="input-list" :key="refresh">
                        <li v-for="(series, index) in input.series" :key="index">
    
                                <div class="input-group mb-1">
                                    <input 
                                        type="text" 
                                        class="form-control mr-1"  
                                        placeholder="Serie a instalar..." 
                                        v-model="series.instala" 
                                        @input="validateData(series, index, 1)"
                                        :class="{'invalid' : !validation.series[index].instala && !isEmpty(series.instala)}"
                                    >
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        placeholder="Serie a retirar..." 
                                        v-model="series.recupera" 
                                        @input="validateData(series, index, 2)"
                                        :class="{'invalid' : !validation.series[index].recupera && !isEmpty(series.recupera)}"
                                    >
                                    <button class="btn btn-outline-danger btn-circle my-auto ml-2" @click="removeLine(index)"><i class="fas fa-times"></i></button>
                                </div>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
            <div class="card card-outline card-primary collapsed-card">
              <div class="card-header">
                <h3 class="card-title">Equipos Cargados</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool btn-dark" @click="newEntry ? storeData() : commitData()"><i class="fas fa-save"></i> <p class="d-none d-md-inline"> Guardar datos</p> </button>
                  <button type="button" class="btn btn-tool" data-widget="collapse" @click="tableDisplay = !tableDisplay"><i  :class="tableDisplay ? 'fas fa-minus' : 'fas fa-plus'"></i></button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: none;">
                <div class="table-responsive">
                    <!--table class="table table-bordered" v-if="equipos.data.length > 0">
                        <thead class="thead-dark">
                            <th>OT</th>
                            <th>Móvil</th>
                            <th>Instala</th>
                            <th>Retira</th>
                            <th>Acciones</th>
                        </thead>
                        <tbody>
                                <tr v-for="(serie, index) in equipos.data" :key="index">
                                    <td>{{serie.OT}}</td>
                                    <td>{{serie.movil}}</td>
                                    <td>{{serie.instala}}</td>
                                    <td>{{serie.recupera}}</td>
                                    <td>
                                        <div class="d-inline-flex mx-auto">
                                            <button class="btn btn-outline-primary btn-circle my-auto" @click="editLineData(serie)"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-outline-danger btn-circle my-auto ml-2" @click="removeLineData(index)"><i class="fas fa-times"></i></button>
                                        </div>
                                    </td>
                                </tr>
                        </tbody>
                    </table-->
                    <list-render
                        :makeActions="true"
                        v-if="equipos.data.length > 0"
                        :dataProp="equipos.data"
                        :titlesProp="['OT', 'Móvil', 'Instala', 'Recupera']"
                        :keysProp="['OT', 'movil', 'instala', 'recupera']"
                        v-slot:default="listItem"
                    >
                    <td>
                        <div class="d-inline-flex mx-auto my-auto">
                            <button class="btn btn-outline-primary btn-circle my-auto" @click="editLineData(listItem)"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-outline-danger btn-circle my-auto ml-2" @click="removeLineData(index)"><i class="fas fa-times"></i></button>
                        </div>
                    </td>

                    </list-render>
                    <p v-else> No se han cargado equipos todavía</p>
                </div>
              </div>
              
              <!-- /.card-body -->
            </div>

        </div>
    </div>
</template>

<script>
import jexcel from 'jexcel'

export default {
    
    data() {
        return {
            input: {
                OT: '',
                movil: '',
                series:[
                    { 
                        instala: '',
                        recupera: '',
                    }, 
                ],
                //comentario: ''
            },    
            
            equipos: {
                contratista: '',
                fecha: '',
                data: [],
            },
            contratistas: [],
            rememberMovil: false,
            validation: {
                OT: '',
                movil: '',
                series:[
                    { 
                        instala: '',
                        recupera: '',
                    }, 
                ],
            },

            refresh: 0,
            formDisplay: true,
            tableDisplay: false,
            newEntry: true,
            error:[]
            
        }
    },

    methods: {
        addInputsRow(state){
            this.input.series.push({
                instala: '',
                recupera: ''
            });

            this.validation.series.push({
                instala: state ? state : '',
                recupera: state ? state : ''
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

        saveOT(currentInput){
            if (this.isValidated() === false) {
                this.error.push('Verificar fecha, contratista y que hayan equipos cargados');
                return;
            }
            let me = this;
            const tempMyObj = Object.assign({}, currentInput);
            var objToData = {};

            tempMyObj.series.forEach(element => {
                objToData.OT = tempMyObj.OT;
                objToData.movil = tempMyObj.movil;
                objToData.instala = element.instala;
                objToData.recupera = element.recupera;

                const temp = Object.assign({}, objToData);

                this.equipos.data.push(temp);
                console.log(temp);
                
            });

            this.input.OT='';
            this.input.movil = this.rememberMovil ? this.input.movil : '';
            this.input.series = [];
            this.validation.series = [];
            me.addInputsRow();
        },

        storeData(){
            if(this.equipos.data.length === 0){
                this.error.push('Verificar fecha, contratista y equipos cargados');
                return;
            }
            var me = this;
            axios.post('/equipos/agregar', {
            
                fecha: me.equipos.fecha,
                datos_equipos: JSON.stringify(me.equipos.data),
                contratista_id: me.equipos.contratista,
            })
            .then(function (response) {
                alert('Equipos cargados correctamente' + response);
                me.newEntry = false;
            })
            .catch(function (error) {
                console.log(error);
                me.error.push('Verificar fecha, contratista y equipos cargados');
            })
            .finally(function () {
               
            }); 
        },

        toogleRememberMovil(){
            this.rememberMovil = !this.rememberMovil;
        },

        removeLine(row){
            this.input.series.splice(row, 1);
            this.validation.series.splice(row, 1);
        },

        editLineData(serie){
            let me = this;
            var eq = {
                        OT: '',
                        movil: '',
                        series:[],
            };
            this.refresh += 1;
            this.validation.series = [];
            this.input.series = [];
            eq.OT = serie.OT;
            eq.movil = serie.movil;


            this.equipos.data.forEach((element, index) => { 
                if(element.OT === serie.OT){
                    this.addInputsRow(true);
                    eq.series.push({
                        instala: element.instala,
                        recupera: element.recupera
                    });
                }
            });
            const OTnumber = serie.OT;

            for (let index = 0; index < this.equipos.data.length; index++) {
                
                if(this.equipos.data[index].OT === OTnumber){
                    this.equipos.data.splice(index, 1);
                    if (this.equipos.data.length >= 1) {
                        index--;
                    }
                }
            }
            
            const temp = Object.assign({}, eq);
            
            this.input = temp;

        },

        removeLineData(index){
            this.equipos.data.splice(index,1);
        },

        comprobeFields(regex, input){

            if(regex.test(input)){
                return true;
            } else{
                return false;
            }
        },

        validateData(serie, index, caso){

            switch (caso) {
                case 1:
                    this.validation.series[index].instala = this.comprobeFields(/^([A-Za-z0-9]{12})$/ , serie.instala) || this.comprobeFields(/^((CVN|cvn)(-[0-9]{4})(-[0-9]{6}))$/ , serie.instala);
                    break;
                case 2:
                    this.validation.series[index].recupera = this.comprobeFields(/^([A-Za-z0-9]{12})$/ , serie.recupera) || this.comprobeFields(/^((CVN|cvn)(-[0-9]{4})(-[0-9]{6}))$/ , serie.recupera);
                    break;
                case 3:
                    this.validation.OT = this.comprobeFields( /^[0-9]{9}$/ ,this.input.OT);
                    break;
                case 4:
                    this.validation.movil = this.comprobeFields(/^([0-9]{2})([A-Za-z]{3})([0-9]{3})$/ ,this.input.movil);
                    break;
                default:
                    break;
            };

        },

        isEmpty(value){
            if(value === '' || value === null){
                return true;
            } else{
                return false;
            }
        },

        isValidated(){
            var validate = true;
            let me = this;
            if(this.validation.OT === false || this.isEmpty(this.input.OT)) return validate=false;
            if(this.validation.movil === false || this.isEmpty(this.input.movil)) return validate=false;

            validate = this.validation.series.length !== 0;
            console.log(validate);
            
            this.validation.series.some(function(obj, index){
                
                 var cond =  ((me.input.series[index].instala !== '' && obj.instala !== false) && (me.input.series[index].recupera !== '' && obj.recupera !== false))
                            || (me.input.series[index].instala !== '' && obj.instala !== false && me.input.series[index].recupera === '') || (me.input.series[index].recupera !== '' && obj.recupera !== false && me.input.series[index].instala === '');
                
                if(cond === false){
                    validate = false; 
                    return;
                }    
            });

            console.log(validate);
            return validate;
        }, 

        test(){
            console.log(this.isValidated());
            
        },

        commitData(){
            if(this.equipos.data.length === 0){
                this.error.push('Verificar fecha, contratista y equipos cargados');
                return;
            }
            var me = this;
            axios.post('/equipos/editar', {
                fecha: me.equipos.fecha,
                datos_equipos: JSON.stringify(me.equipos.data),
                contratista_id: me.equipos.contratista,
            })
            .then(function (response) {
                console.log(response);
            })
            .catch(function (error) {
                console.log(error);
                me.error.push('Verificar fecha, contratista y equipos cargados');
            });
        },        
    },
    
    mounted() {
        this.getContratistas();
        // let spreadsheet = jexcel($ref.jexcel, this.options);
        //     Object.assign(this, spreadsheet);
    },

}
</script>

<style lang="css">

.input-list{
    list-style: none;
    padding: 0;
}

.form{
    padding: 20px;
}

.btn-circle.btn-xl {
    width: 70px;
    height: 70px;
    padding: 10px 16px;
    border-radius: 35px;
    font-size: 24px;
    line-height: 1.33;
}

.btn-circle {
    width: 30px;
    height: 30px;
    padding: 6px 0px;
    border-radius: 15px;
    text-align: center;
    font-size: 12px;
    line-height: 1.42857;
}

.has-icon .form-control {
    padding-right: 2.375rem;
}

.has-icon .form-control-icon {
    position: absolute;
    z-index: 2;
    display: block;
    width: 2.375rem;
    height: 2.375rem;
    line-height: 2.375rem;
    text-align: right;
    color: #aaa;
    right: 3%;
}
.input-group .invalid{
    border-color: red !important;
}

.w-20 {
  width: 20%;
}

.w-10 {
  width: 10%
}

.w-40 {
  width: 40%;
}

table {
    table-layout:auto;
    word-wrap: break-word;
}

    
</style>