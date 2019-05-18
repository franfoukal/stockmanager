<template>
    <div class="container col-8">
        <div class="card mx-auto ">
            <div class="card-body">
                <table class="table table-bordered" ref="table" id="table">
                    <thead class="thead-dark">
                        <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        <tr v-for="material in materiales" :key="material.id" >
                            <td>{{material.codigo}}</td>
                            <td>{{material.descripcion}}</td>
                            <td contenteditable="true"></td>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <button type="button" @click="tableToJson()" class="btn btn-primary">Primary</button>
            </div>
        </div>

    </div>
</template>

<script>
import * as pt from '../parseTable.js'
export default {

    data: function(){
        return{
            materiales: [],
             
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

        tableToJson(){
            var dat = document.getElementById('table');
            
            console.log(pt.parseTable(dat));
            //console.log(dat.tHead.rows[0].cells);
        },

        guardarConsumo(){

        }
 
    },

    mounted() {
            this.listarMateriales();
        },
}

</script>

<style lang="css">
    
</style>