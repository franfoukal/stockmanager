<template>
<div class="component">
    <div class="container col-md-10">
        <div class="card">
            <div class="card-header">
                <div class="row">

                    <p class="card-title my-auto col">Carga de equipos</p>

                    <input type="date" class="form-control col-3 mr-2" v-model="equipos.fecha" >
                        
                        <select class="custom-select col-3 mr-2" v-model="equipos.contratista" v-if="$attrs.cur_cont[0] !== undefined">
                            <option  v-if="$attrs.cur_cont[0] !== undefined" :value="$attrs.cur_cont[0].id" selected> {{$attrs.cur_cont[0].nombre}}</option>
                        </select>
                        
                        <select class="custom-select col-3 mr-2" v-model="equipos.contratista" v-else>
                            <!--option  v-if="$attrs.cur_cont[0] !== undefined" :value="$attrs.cur_cont[0].id"> {{$attrs.cur_cont[0].nombre}}</option-->
                            <option  v-for="contratista in contratistas" :key="contratista.id" :value="contratista.id">
                            {{contratista.nombre}}
                            </option>
                        </select>
                </div>
            </div>
            <div class="card-body">
                <!--form-->
                <div class="form col-md-10  mx-auto">
                    
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-file-signature"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Orden Nº.:" v-model="input.OT">
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">9 caracteres numericos</div>
                        </div>

                        <div class="input-group mb-2 has-icon">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-truck"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Tecnico WFX:" v-model="input.movil"> 
                            <i class="fas fa-thumbtack my-auto form-control-icon" :class="{'text-success' : rememberMovil}" @click="toogleRememberMovil()"></i>
                                
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        
                        <div class="btn-group mt-2">
                            <button class="col btn btn-dark " @click="addInputsRow()">Agregar equipos</button>
                            <button class="col btn btn-success " @click="saveOT()">Guardar OT</button>
                        </div>
                        


                    <hr>

                    <p class="text-lg mx-auto">
                        <i class="fas fa-barcode text-xl"> </i>  
                            Serializables
                    </p>

                    <ul class="input-list">
                        <li v-for="(series, index) in input.series" :key="index">
    
                                <div class="input-group has-icon">
                                    <input type="text" class="form-control has-icon" placeholder="Serie a instalar..." v-model="series.instala">
                                    <input type="text" class="form-control" placeholder="Serie a retirar..." v-model="series.recupera">
                                    <button class="btn btn-outline-danger btn-circle my-auto ml-2"><i class="fas fa-times"></i></button>
                                </div>
                        </li>
                    </ul>

                </div>
                
            </div>
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
        }
    },

    methods: {
        addInputsRow(){
            this.input.series.push({
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

        saveOT(){
            let me = this;
            this.equipos.data.push(JSON.stringify(this.input));
            this.input.OT='';
            this.input.movil = this.rememberMovil ? this.input.movil : '';
            this.input.series = [];
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

        deleteLine(row){
            this.input.series[row];
        }
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

    
</style>