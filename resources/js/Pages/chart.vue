<template>
    <div :ref="rm" ></div>
 
</template>

<script>
export default {
    props: ["b", "w", "h","uuid"],
    computed:{
        rm:function(){
            return toString(safta) ;
        }
    },
    data:function(){
        return{
           last:-1000,
        }
    },
    mounted() {
        safta++;
        console.log("mou");
        var layout = {
            autosize: true,
            width: this.w,
            height: this.h-25,
            margin: {
                l: 10,
                r: 25,
                b: 25,
                t: 20,
            },
            font: { size: 14 },
       paper_bgcolor: '#c7c7c7',
  plot_bgcolor: '#c7c7c7',

        };
        var config = {
            responsive: true,
            modeBarButtonsToRemove: [
                "pan2d",
                "select2d",
                "lasso2d",
                "tooltip2d",
                "toggleSpikelines",
                "hoverClosestCartesian",
                "hoverCompareCartesian",
            ],
            displaylogo: false,
        };
        Plotly.plot(
            this.$refs[this.rm],
            [
                {
                    x: [
                        this.getTime(),
                    ],
                    y: [this.b,],
                    type: "lines",
                    mode: 'lines+markers',
                     line: {
    color: 'rgb(55, 128, 10)',
    width: 3
  }
                },
            ],
            layout,
            config
        );
        this.last = this.b;
    },
    methods: {
        getTime: function () {
            var today = new Date();
          return  today.getFullYear()+"-"+(today.getMonth()+1)+"-"+today.getDate()+" "+today.getHours()+":"+today.getMinutes()+":"+today.getSeconds();
        },
        check(){
            console.log(this.last +" : "+ this.b);
            return this.last != this.b && this.b !="undefined"  && this.b !="NaN";
        }
    },
    watch: {
        b: {
            handler: function (d) {
               
            if(this.check())
         {

             Plotly.extendTraces(
                 this.$refs[this.rm],
                 {
                     y: [[d]],
                     x: [[this.getTime()]],
                 },
                 [0]
             );
             this.last = d;
         }
            },
            deep: true,
        },
        h: function (h) {
         
            var ll = { height: h-25 };
            Plotly.relayout(this.$refs[this.rm], ll);
        },
        w: function (w) {
           
            var ll = { width: w };
            Plotly.relayout(this.$refs[this.rm], ll);
        },
    },
};
</script>

<style>
svg {
    display: inherit;
}
</style>
