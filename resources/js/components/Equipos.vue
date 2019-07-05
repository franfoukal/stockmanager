<template>
<div class="component">
    <div class="container col-md-10">
        <div class="card collapse show">
            <div class="card-header">
                <div class="row">
                    <p class="card-title my-auto col">Carga de equipos</p>
                    <input type="date" class="form-control col-3 mr-2" v-model="equipos.fecha" >
                        
                        <select class="custom-select col-3 mr-2" v-model="equipos.contratista" v-if="$attrs.cur_cont[0] !== undefined">
                            <option  v-if="$attrs.cur_cont[0] !== undefined" :value="$attrs.cur_cont[0].id" selected> {{$attrs.cur_cont[0].nombre}}</option>
                        </select>
                        
                        <select class="custom-select col-3 mr-2" v-model="equipos.contratista" v-else>
                            <option  v-for="contratista in contratistas" :key="contratista.id" :value="contratista.id">
                            {{contratista.nombre}}
                            </option>
                        </select>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-plus"></i></button>
                        </div>
                        <!-- /.card-tools -->
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
                            <button class="col btn btn-dark " @click="addInputsRow()">Agregar equipos</button>
                            <button class="col btn btn-success " @click="saveOT(input)" value="Guardar OT">Guardar OT</button>
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
                  <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-plus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: none;">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <th>OT</th>
                        <th>Móvil</th>
                        <th>Instala</th>
                        <th>Retira</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody v-for="(data, index) in equipos.data" :key="index">
                            <tr v-for="(serie, key) in data.series" :key="key">
                                <td>{{data.OT}}</td>
                                <td>{{data.movil}}</td>
                                <td>{{serie.instala}}</td>
                                <td>{{serie.recupera}}</td>
                                <td>
                                    <button class="btn btn-outline-primary btn-circle my-auto ml-2" @click="editLineData(index, data)"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-outline-danger btn-circle my-auto ml-2" @click="removeLineData(index, key)"><i class="fas fa-times"></i></button>
                                </td>
                            </tr>
                    </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>

        
    </div>
</div>
</template>

<script>
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
                comentario: ''
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
        }
    },

    methods: {
        addInputsRow(){
            this.input.series.push({
                instala: '',
                recupera: ''
            });

            this.validation.series.push({
                instala: '',
                recupera: ''
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
                return;
            }
            let me = this;
            const tempMyObj = Object.assign({}, currentInput);
            this.equipos.data.push(tempMyObj);//JSON.stringify(this.input));
            this.input.OT='';
            this.input.movil = this.rememberMovil ? this.input.movil : '';
            this.input.series = [];
            this.validation.series = [];
            me.addInputsRow();
        },

        storeData(){
            var me = this;
            axios.post('/equipos/agregar', {
            
                fecha: me.fecha,
                datos_equipos: JSON.stringify(me.equipos.data),
                contratista_id: me.equipos.contratista.id,
            })
            .then(function (response) {
                alert('Equipos cargados correctamente');
                
            })
            .catch(function (error) {
                console.log(error);
                
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

        editLineData(row, data){
            this.refresh += 1;
            this.validation.series = [];
            this.input.series = [];
            for (let index = 0; index < data.series.length; index++) {
                this.addInputsRow();  
            }
            this.input = data;
            this.equipos.data.splice(row, 1);
        },

        removeLineData(row,key){
            if(this.equipos.data[row].series.length === 1){
                this.equipos.data.splice(row, 1);
            }else{
                this.equipos.data[row].series.splice(key, 1);
            }
            
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

        
    },
    
    mounted() {
        this.getContratistas();
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

    
</style>