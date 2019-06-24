<template>
<div class="component">
    <div class="container col-md-10">
        <div class="card">
            <div class="card-header">
                <div class="row">

                    <p class="card-title my-auto col">Carga de equipos</p>

                    <input type="date" class="form-control col-3 mr-2" v-model="fecha" >
                        
                        <select class="custom-select col-3 mr-2" v-model="equipos.contratista" v-if="$attrs.cur_cont[0] !== undefined">
                            <option  v-if="$attrs.cur_cont[0] !== undefined" :value="$attrs.cur_cont[0]" selected> {{$attrs.cur_cont[0].nombre}}</option>
                        </select>
                        
                        <select class="custom-select col-3 mr-2" v-model="equipos.contratista" v-else>
                            <option  v-if="$attrs.cur_cont[0] !== undefined" :value="$attrs.cur_cont[0].id"> {{$attrs.cur_cont[0].nombre}}</option>
                            <option  v-for="contratista in contratistas" :key="contratista.id" :value="contratista">
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
                            <input type="text" class="form-control" placeholder="Orden Nº.:">
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">9 caracteres numericos</div>
                        </div>

                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-truck"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Tecnico WFX:">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <button class="col btn btn-primary " @click="addInputsRow()">Agregar equipos</button>

                    <hr>

                    <ul class="input-list">
                        <li v-for="(input, index) in inputs" :key="index">
    
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-barcode"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Serie a instalar..." v-model="input.instala">
                                    <input type="text" class="form-control" placeholder="Serie a retirar..." v-model="input.recupera">
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
            inputs: [
                {
                    instala: '',
                    recupera: ''
                },
            ],
            equipos: {},
            fecha: '',

        }
    },

    methods: {
        addInputsRow(){
            this.inputs.push({
                instala: '',
                recupera: ''
            });
        }
    },
    
    mounted() {
        
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
    
</style>