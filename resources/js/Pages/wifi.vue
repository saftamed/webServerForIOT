<template>
 <app-layout>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-7" v-if="nn">
                        <div class="mt-8 text-2xl">
                             Wifi Setting
                        </div>

                        <div class="mt-6 text-gray-500">
                           First connect To Smart wifi then click on Connect bellow .
                        </div>
                        <button @click.prevent="nn=false" class="bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-2 px-4 border border-green-500 mt-7 hover:border-transparent rounded">Connect </button>
                    </div>
                    <div v-else>
                        <button @click.prevent="nn=true" class="bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-2 px-4 border border-green-500 m-7 hover:border-transparent rounded">Try Agin </button>
                        <iframe  src="http://192.168.1.184/" ></iframe>
                    </div>
                </div>
            </div>
      
 </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    export default {
       components: {
            AppLayout,
        },
        data: function () {
            return {
                nn:true
            }
        },
    }
</script>
<style>
iframe{
    width: 100%;
    height: calc(100vh - 30vh);
}
</style>