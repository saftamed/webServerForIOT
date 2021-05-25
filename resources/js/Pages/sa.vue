<template>
 <app-layout>
       


<!--Sidebar with Dimmer -->
		<div class="fixed inset-0 flex z-50 sd">
			<!-- Sidebar -->
			<div
				class="absolute flex top-0 h-screen z-50"
				:class="[right ? 'right-0 flex-row' : 'left-0 flex-row-reverse']"
			>
				<!--Drawer -->
				<button
          v-if="edit"
					@click.prevent="toggle()"
					class=" p-1 my-auto rounded text-white bg-gray-500 text-center focus:outline-none hover:bg-gray-400 transition-color duration-300"
				>
					<span

						class="block transform origin-center font-bold"
					>
						<i class="far fa-arrow-alt-from-left"></i>
					</span>
				</button>

				<!-- Sidebar Content -->
				<div
					ref="content"
					class="transition-all duration-700 bg-yellow-200 overflow-hidden flex items-center justify-center"
					:class="[open ? 'max-w-lg' : 'max-w-0']"
				>
                    <nav class="h-screen flex flex-col w-64 bg-gray-50">
                        <div class="p-4">
                          <div id="com">Components</div>
                        </div>
                        <ul class="p-2 space-y-2 flex-1 overflow-auto" style="scrollbar-width: thin;">
                            <li @click="addRelay">
                                <a href="#" class="flex space-x-2 items-center text-gray-600 p-2 bg-gray-200 rounded-lg">
                                    <span class="text-gray-900">Add Relay</span>
                                    <i class="fal fa-toggle-on"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
				</div>

    	
			</div>

		</div>
<transition>
				<!-- Dimmer -->
				<div
					v-if="dimmer && open"
					@click="toggle()"
					class="flex-1 bg-gray-400 bg-opacity-75 active:outline-none z-10 sm"
				/>
			</transition>

       <template #header>
          <button @click.prevent="starEdit"  v-if="!edit" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
            Edit
          </button>
          <button @click="cancel"  v-if="edit" class="mr-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
             Cancel
          </button>
          <button @click="save"  v-if="edit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
             Save
          </button>

          <span v-if="connected" class="right-3 text-green-800 absolute  font-bold py-2 px-4 inline-flex items-center">
            <span class=" mr-2">Connected </span>
            <i class="fill-current w-4 h-4 far fa-wifi"></i>
          </span>
           <span v-else class="right-3 text-red-600 absolute  font-bold py-2 px-4 inline-flex items-center">
            <span class=" mr-2"> Disconnected</span>
            <i class="fill-current w-4 h-4 far fa-wifi-slash"></i>
          </span>
        </template>

		

  <div class="d-flex" id="wrapper">



    <!-- Page Content -->
    <div id="page-content-wrapper">
      <div class="container-fluid">
        <div id="space">
         
            <div class="mb-8 p-2 w-full flex flex-wrap bg-grey-light">
               <div class="h-16 border-8 res w-full md:w-1/2 lg:w-1/3 bg-grey rows" v-for="(ss,ii) in data" :key="ii" v-bind:style="{height: param[ii] + 'px'}">
                <div class="ui-widget-content draggable" v-for="(item,i) in ss" :key="item.id" v-bind:style="{top: item.option.top + 'px',left: item.option.left + 'px',width: item.option.width + 'px',height: item.option.height + 'px'}" >
                  <div class="title1">
                  <span>{{item.option.name}}</span>
                  <span id="ss"  v-if="edit"><i class="fad fa-arrows-alt"></i></span>
                  </div>
                  <div class="cc" v-if="item.action=='D'">
                  
                  <input type="checkbox" v-bind:id="'switch'+i+ii" v-model="item.value" true-value="1" false-value="0" />
                  <label @click="switchChange($event,ii,i)" v-bind:for="'switch'+i+ii" class="switch" :style="{background: item.value == 1 ?item.option.color:'gray'}"> <div :class="item.value == 1 ? 'pr-7':'pl-10'">{{ item.value == 1 ? 'ON':'OFF'}}</div></label>
                </div>
                <div class="cc" v-else> 
                  <input v-bind:id="'switch'+i+ii" @change="switchChange($event,ii,i)" :style="{background:item.option.color}" v-model="item.value" class="rounded-lg ss overflow-hidden appearance-none bg-red-400 h-5 w-200" type="range" min="1" max="100" step="10"  /> 
                </div>
                </div>
            </div>
          </div>
        <!--  <div class="draggable">
            <span>drag here<i class="fas fa-arrows-alt"></i><i class="far fa-hat-winter"></i></span>
            <input type="checkbox" id="switch" /><label for="switch" class="switch">Toggle</label>
          </div> -->
        </div>




      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>

 <transition
      enter-active-class="transition duration-300 ease-out transform"
      enter-class="scale-95 opacity-0"
      enter-to-class="scale-100 opacity-100"
      leave-active-class="transition duration-300 ease-in transform"
      leave-class="scale-100 opacity-100"
      leave-to-class="scale-95 opacity-0"
    >
      
  <!--Modal-->
  <div v-if="modalOpen" class="modal  z-50  fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div @click="modalOpen =false" class="modal-overlay absolute w-full h-full bg-gray-900 opacity-30"></div>
    
    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
      

      <!-- Add margin if you want to see some of the overlay behind the modal-->
      <div class="modal-content py-4 text-left px-6">
        <!--Title-->
        <div class="flex justify-between items-center pb-3">
          <p class="text-2xl font-bold">{{options.name}} Edit</p>
          <div class="modal-close cursor-pointer z-50" @click="modalOpen =false">
            <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
              <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
            </svg>
          </div>
        </div>

        <!--Body-->
        <div class="col-span-6">
          <label  class="block text-sm font-medium text-gray-700">Name</label>
          <input type="text" v-model="options.name" name="Name"  autocomplete="Name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>

              <div class="col-span-6 sm:col-span-3 my-5 ">
                <label class="block text-sm font-medium text-gray-700">Select pin</label>
                <select v-model="options.pin" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                  <option value="4" selected>four</option>
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
                  <option value="5">five</option>
                  <option value="6">six</option>
                  <option value="7">seven</option>
                </select>
              </div>

              <div class="col-span-6 sm:col-span-3 my-5 ">
                <label class="block text-sm font-medium text-gray-700">Position</label>
                <select v-model="options.position" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                  <option value="left" selected>Left</option>
                  <option value="center">Center</option>
                  <option value="right">Right</option>

                </select>
              </div>

        <div class="col-span-6">
          <label  class="block text-sm font-medium text-gray-700">Color</label>
          <input v-model="options.color" type="color" class="border-solid h-8 border-2 border-gray-300">
        </div>
        <button @click.prevent="deleteRelay" v-if="!open" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded">
          Delate
        </button>
        <!--Footer-->
        <div class="flex justify-end pt-2">
          <button @click="modalOpen =false " class="px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2">Close</button>
          <button @click="saveOptions" class="modal-close px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400">Save</button>
        </div>
        
      </div>
    </div>
  </div>
    </transition>
 </app-layout>
</template>

<script>

    var dragOptions = {distance: 10,grid: [ 10, 10 ],opacity: 0.35,handle:"span", containment: "parent"};
    var  resizOptions = {distance: 10,grid: [ 50, 20 ]};
    import AppLayout from '@/Layouts/AppLayout'
    export default {
       props: {
            params: Object,
            user: Object,
        },
       components: {
            AppLayout,
        },
        data: function () {
            return {
              connected:false,
              open: false,
              dimmer: true,
              right: false,
              data:{
                left:[],
                center:[],
                right:[],
              },
               i:0,
               edit:false,
               options:{
                 pin:2,
                 color:"black",
                 name:"relay1",
                 index:0,
                 position:"left"
               },client:{},
                 modalOpen: false,
                 heights:[],
                 param:this.params

            }
        },
        mounted() {
          axios.defaults.withCredentials = true;
         console.log(this.user);
             axios.get("/items/"+this.user.id,{
                }).then(response =>{

                 this.data ={
                    left:response.data.hasOwnProperty('left')?[...response.data.left]:[] ,
                    center:response.data.hasOwnProperty('center')?[...response.data.center]:[] ,
                    right:response.data.hasOwnProperty('right')?[...response.data.right]:[] ,
                 };
                    //this.generateData();
                    //this.$forceUpdate();
                    this.connectToMqtt();
                });

            //this.switchChange("f");
            

        },methods:{
          deleteRelay(){
            //console.log( this.data[this.options.position][this.options.index]);
            if(confirm("Are you sure you want to delete?")){
                var c = {id: this.options.id};
                axios.post('/items/delete',c).then(response =>{
                  $( "body .draggable" ).draggable( "destroy" ).resizable( "destroy" );
                  $( "body .res" ).resizable("destroy" );
                  this.edit = false;
                  this.modalOpen = false;
                  this.open = false;       
                  this.data ={
                    left:response.data.hasOwnProperty('left')?[...response.data.left]:[] ,
                    center:response.data.hasOwnProperty('center')?[...response.data.center]:[] ,
                    right:response.data.hasOwnProperty('right')?[...response.data.right]:[] ,
                  };
                            
                });

            }
            
          },
          cancel(){
               axios.get("/items/"+this.user.id,{
                }).then(response =>{
                  this.data = response.data;
                  this.i = response.data.length;
                    this.edit =false;
                    $( "body .draggable" ).draggable( "destroy" ).resizable( "destroy" );
                    $( "body .res" ).resizable("destroy" );
                });
          },
          saveOptions(){
            if(!this.open){
             var pos = $( "#switch"+this.options.index+this.options.pos).position();
              this.data[this.options.pos][this.options.index].pin = this.options.pin;
              this.data[this.options.pos][this.options.index].option.name =  this.options.name;
              this.data[this.options.pos][this.options.index].option.color = this.options.color;
              this.data[this.options.pos][this.options.index].position = this.options.position;

              this.data[this.options.pos][this.options.index].option.width = pos.width;
              this.data[this.options.pos][this.options.index].option.height = pos.height;

              ['left','center','right'].forEach(pos => {
                
              });
              this.$forceUpdate();
            }else{
                
                this.data[this.options.position][this.data[this.options.position].length] ={
                    action:"D",
                    pin:this.options.pin,
                    position:this.options.position,
                    value:0,
                    user_id:this.user.id,
                    option:{
                      name:this.options.name,
                      color: this.options.color,
                      top:0,left:0,width:0,height:0,
                    }
                };
              this.open = false;
              this.$forceUpdate();
                this.$nextTick(function () {
                    if(this.edit){
                      $( "body .draggable-ui" ).draggable( "destroy" ).resizable( "destroy" );
                      $( "body .draggable" ).draggable(dragOptions).resizable(resizOptions);
                    }
                    console.log("updated");
                });
            }
              this.modalOpen = false;
              
          },
          toggle(){
             this.open = !this.open;
          },
          starEdit(){
            this.edit = true;
            $( "body .draggable-ui" ).draggable( "destroy" ).resizable( "destroy" );
             $( "body .draggable" ).draggable(dragOptions).resizable(resizOptions);
             $( "body .res" ).resizable({
                minHeight: 200,
             });
                
          },
            switchChange(event,ii,i){

              console.log(event.type);
                 if(!this.edit){
                   
                   if(this.connected){
                      var msg ={...this.data[ii][i]};
                      if(event.type == "click"){

                        msg.value= msg.value?0:1;
                      }
                      delete msg.option;
                      console.log(msg);

                      var message = new Paho.MQTT.Message(JSON.stringify(msg));
                      message.destinationName = "iot-2/"+this.params.code;
                      this.client.send(message);
                    axios.post('/items/update',msg).then(response =>{
                      console.log(response);
                    });
                    }
                    event.preventDefault();
                }else{
                    event.preventDefault();
                    this.options ={
                     id:this.data[ii][i].id,
                     name: this.data[ii][i].option.name,
                     color:this.data[ii][i].option.color,
                     pin:this.data[ii][i].pin,
                     position:this.data[ii][i].position,
                     index:i,
                     pos:ii
                      };
                      this.modalOpen = true;
                    //$('#staticBackdrop').modal('show');
                }
            },generateData(){
              data.forEach(function (item,index) {
               var $element = $('<div class="ui-widget-content draggable"><span>drag here</span><input type="checkbox" @click="switchChange()" id="switch'+index+'" /><label for="switch'+index+'" class="switch">Toggle</label></div>');
                $("#space").append($element);
                $element.draggable(dragOptions).resizable(resizOptions);
                $element.data('index',index); 
                $element.css({'top' :data[index].option.top + 'px','left':data[index].option.left + 'px','width':data[index].option.width + 'px','height':data[index].option.height + 'px'});
                            
              });
            },save(){

              var c =[...this.data["left"],...this.data["center"],...this.data["right"]];
              $( "body .draggable" ).each(function( index ) {
                const pos = $(this).position();
                delete  c[index].value;
                c[index].option={
                  top:pos.top,
                  left:pos.left,
                  width: $(this).outerWidth(),
                  height: $(this).outerHeight(),
                  name:c[index].option.name,
                  color:c[index].option.color,


                };
              });

              var cc = {};
              $(".res").each(function( index ) {
                cc[index]=$(this).outerHeight();
              });
              this.param ={
                  id:this.param.id,
                  left:cc[0],
                  center: cc[1],
                  right:cc[2],
                  code :this.param.code
              };
              var k = {
                items:c,
                params:this.param
              };
             // console.log(k);
            
               axios.post('/items/set',k).then(response =>{
                        console.log(response);
                        $( "body .draggable" ).draggable( "destroy" ).resizable( "destroy" );
                         $( "body .res" ).resizable("destroy" );
                        this.edit = false;
                        this.data ={
                          left:response.data.hasOwnProperty('left')?[...response.data.left]:[] ,
                          center:response.data.hasOwnProperty('center')?[...response.data.center]:[] ,
                          right:response.data.hasOwnProperty('right')?[...response.data.right]:[] ,
                        };
              });


            },
            addRelay(){
              this.options={color:"red",position:"left",name:"new relay"};
                this.modalOpen = true;
                // console.log(this.data);
                // this.i++;
                // this.$forceUpdate();
                // this.$nextTick(function () {
                //     if(this.edit){
                //       $( "body .draggable-ui" ).draggable( "destroy" ).resizable( "destroy" );
                //       $( "body .draggable" ).draggable(dragOptions).resizable(resizOptions);
                //     }
                //     console.log("updated");
                // });

             
            },connectToMqtt(){
              console.log("mqtt");
                this.client = new Paho.MQTT.Client("localhost", 9001,"hh"+Math.floor(Math.random() * 11));
                this.client.reconnect = true;
                this.client.onConnectionLost = this.onConnectionLost;
                this.client.onMessageArrived = this.onMessageArrived;
                this.client.connect({onSuccess:this.onConnect ,keepAliveInterval : 12,reconnect:true});
            }, onConnect() {
                console.log("onConnect");
                this.connected = true;
                this.client.subscribe("iot-2/"+this.params.code);
            },
            onConnectionLost(responseObject) {
                if (responseObject.errorCode !== 0) {
                console.log("onConnectionLost:"+responseObject.errorMessage);

                }
               // this.connectToMqtt();
                this.connected = false;
            },
            onMessageArrived(message) {
                var d = JSON.parse(message.payloadString);
                var e = {pos:"a"};
                for (const key in this.data) {
                  
                    const pos = this.data[key];
                    pos.forEach((element,i) => {
                      if(element.pin == d.pin){
                        e= {
                          pos:key,
                          index:i
                        };
                        return;
                      }
                    });
                  if(e.pos != "a"){
                      console.log(e);
                    break;
                  }
                    
                  
                }

                this.data[e.pos][e.index].value = d.value;
                
            }

        }
    }
</script>
<style>


.fade-enter-active,
.fade-leave-active {
	transition: opacity 1s ease-out;
}

.fade-enter,
.fade-leave-to {
	opacity: 0;
}
.sd{
display: inline-table;
}
.sm{
      width: 100%;
    height: 100%;
background: #2f2f2f;
    position: absolute;
    opacity: 0.4;
}
.ui-resizable-handle{
  z-index: 40 !important;

}
.rows{
  position: relative;
  height: 400px;
}
.res > .ui-resizable-e, .res> .ui-resizable-se{
  display: none !important;
}
button i {
  font-size: 32px;
}

#com{
      font-size: 28px;
    font-weight: bold;
    text-shadow: 2px 10px 6px #2d2c2c;
}
input[type="range"]::-webkit-slider-thumb {
  width: 20px;
  -webkit-appearance: none;
  appearance: none;
  height: 100vh;
  background: #FFF;
  box-shadow: 405px 0 0 400px #a7a7a7;
  border-radius: 50%;

}
.ss{
  width: 100%;
    height: 38%;
}
.ui-widget-content.draggable {
    height: 100%;
}
</style>