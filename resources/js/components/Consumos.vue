<template>
    <div class="container col-8">
        <div class="card mx-auto ">
            <div class="card-header">
                <div class="card-title my-auto">
                    Agregar Consumo
                </div>

                <select class="custom-select col-3 ml-auto">

                </select>

            </div>
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
                        <tr v-for="(material) in materiales" :key="material.id" >
                            <td name="codigo[]">{{material.codigo}}</td>
                            <td name="descripcion[]">{{material.descripcion}}</td>
                            <editable v-model="material.consumo" @input="printMateriales()"></editable>
                            
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <button type="button" @click="printMateriales()" class="btn btn-primary">Primary</button>
            </div>
        </div>

    </div>
</template>

<script>

export default {

    data: function(){
        return{
            materiales: [],
            consumos: []
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

        printMateriales(){
            console.log(this.materiales);
            this.consumos = this.materiales.filter(
                (element) => element.consumo
            );

            this.consumos.forEach(
                function(v){ 
                    delete v.created_at;
                    delete v.updated_at;
                });

            console.log(this.consumos);
        }
    },

    mounted() {
            this.listarMateriales();
        },
}

</script>

<style lang="css">
    
</style>