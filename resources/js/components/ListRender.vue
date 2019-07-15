<template>
<div class="master">
    <div class="table-responsive">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th v-for="title in titlesProp" :key="title.id">{{title}}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="info in data" :key="info.id">
                    {{info}}
                </tr>
            </tbody>
        </table>
    </div>
</div>
</template>

<script>
export default {
    props: {
        keysProp: Array,
        dataProp: Array,
        titlesProp: Array
    },
    
    data(){
        return {
            data:[],
            keys:[],
            titlesData:[]
        } 
    },

    computed:{
        titles: function(){
            const temp = Object.assign({}, this.dataProp[0]);
            console.log(temp);
            return Object.keys(temp);
        },

        dataComp: function(){
            const temp = Object.assign({}, this.dataProp);
            return temp.filter((element)=>{
                //foreach con los keysProps
            });
        }
    },

    methods:{
    },

    mounted(){},

    created(){
        
    }
}
</script>

<style>

</style>
