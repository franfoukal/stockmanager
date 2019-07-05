<template>
<div class="master">
    <div class="table-responsive">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th v-for="titles in tableTitles" :key="titles.id">{{titles}}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(data) in tableData" :key="data.id">
                    <p>{{data}}</p>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</template>

<script>
export default {
    props: {
        tableTitles: Array,
        tableData: Object,
        singleData: Object,
    },
    
    data: function(){
        return {
            datas: [],
        } 
    },

    methods:{
        chooseFieldsToRender(arr,...data){
            this.tableData = this.arr.filter(function(element){
                this.data.forEach(function(c){
                    (element) => element.c
                });
            });
        },
    },

    mounted(){}
}
</script>

<style>

</style>
