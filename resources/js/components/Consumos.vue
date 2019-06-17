<template>
    <div class="container col-md-7 mb-5">

        <div class="alert alert-warning alert-dismissible" :class="{'d-none' : error}">
            <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
            Error en la carga del consumo, revisar datos: 
            <ul>
                <li>Fecha ya ingresada</li>
                <li>Cantidad no numerica</li>
            </ul>
        </div>

        <div class="card mx-auto">
            <div class="card-header">
                <div class="row">
                    <div class="card-title my-auto col">
                        Agregar Consumo
                    </div>
                    
                    <input type="date" class="form-control col-3 mr-2" v-model="fecha" >
                    
                    <select class="custom-select col-3 mr-2" v-model="contr_id" v-if="$attrs.cur_cont[0] !== undefined">
                        <option  v-if="$attrs.cur_cont[0] !== undefined" v-bind:value="$attrs.cur_cont[0].id" selected> {{$attrs.cur_cont[0].nombre}}</option>
                    </select>
                    
                    <select class="custom-select col-3 mr-2" v-model="contr_id" v-else>
                        <option  v-if="$attrs.cur_cont[0] !== undefined" v-bind:value="$attrs.cur_cont[0].id"> {{$attrs.cur_cont[0].nombre}}</option>
                        <option  v-for="contratista in contratistas" :key="contratista.id" v-bind:value="contratista.id">
                           {{contratista.nombre}}
                        </option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" ref="table" id="table">
                        <thead class="thead-dark">
                            <tr>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            </tr>
                            
                        </thead>
                        <tbody>
                            <tr v-for="(material) in materiales" :key="material.id" >
                                <td>{{material.codigo}}</td>
                                <td>{{material.descripcion}}</td>
                                <!--editable  v-model="material.consumo"   @input="filterInput(material)"></editable-->
                                <td><input min="0" type="number" v-model="material.consumo" v-text="material.consumo" @input="isPositive(material)"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" @click="guardarConsumo()" class="btn btn-primary">Guardar</button>
            </div>
        </div>

    </div>
</template>

<script>

export default {

    data: function(){
        return{
            materiales: [],
            consumos: [],
            contratistas: [],
            contr_id: '',
            fecha: '',
            cur_user: '',
            cur_cont: '',
            error: 1,
        } 
    },

    methods: {
        listarMateriales(){
            let me = this;
            axios.get('/materiales/listar')
                .then(function (response) {
                    
                    me.materiales = response.data;
                
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
        },
        listarContratistas(){
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

        printMateriales(){
            this.consumos = this.materiales.filter(
                (element) => element.consumo
            );

            this.consumos.forEach(
                function(v){ 
                    delete v.created_at;
                    delete v.updated_at;
                });

            
            return this.consumos;
        },

        guardarConsumo(){
        var me = this;

    
        axios.post('/consumo/agregar', {
            
                fecha: me.fecha,
                datos_consumo: JSON.stringify(me.printMateriales()),
                contratista_id: me.contr_id

            })
            .then(function (response) {
                alert('Consumo cargado correctamente');
                window.location.reload();
                me.error=1;
            })
            .catch(function (error) {
                console.log(error);
                me.error=0;
            })
            .finally(function () {
               
            });
        },  
        
        errorToggle(){
            this.error++;
            this.error = this.error%2;
        },

        isPositive(e){
            e.consumo = e.consumo.replace(/[^0-9]+/g, '');
        },
    },

    

    mounted() {
            this.listarMateriales();
            this.listarContratistas();
        },
}

</script>

<style lang="css">
    table td {
        position: relative;
    }

    table td input {
        position: absolute;
        display: block;
        top:0;
        left:0;
        margin: 0;
        height: 100%;
        width: 100%;
        border: none;
        padding: 10px;
        box-sizing: border-box;
        
    }

    
</style>