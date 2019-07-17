<template>
<div class="master">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th v-for="title in titlesProp" :key="title.id">{{title}}</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(info, index) in dataProp" :key="index">
                    <td v-for="(key, index) in keysProp" :key="index">{{info[key]}}</td>
                    <slot v-bind="info"></slot>
                        <!--in the parent, the access to item "info" is with v-slot:default="listItem"-->
                </tr>
            </tbody>
        </table>
    </div>
</div>
</template>

<script>
export default {
    props: { 
        dataProp: Array, // The JSON dataset to extact info
        titlesProp: Array, // The titles wich the parent will render
        keysProp: Array, // The keys from the JSON dataser
    },
    
    data(){
        return {
            data:[],
            keys:[],
            titlesData:[]
        } 
    },

    computed:{},

    methods:{},

    mounted(){},

    created(){}
}
</script>

<style>
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
</style>
