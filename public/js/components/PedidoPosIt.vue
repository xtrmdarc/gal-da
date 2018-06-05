<template>
     <div id="pedido-post-it" class="col-sm-3" style="margin-left:5%">
        <div class="card post-it ">
            <div class="card-header post-it-header ">
                <div class="row-fluid">
                    <div class="col-sm-4 text-left">
                        <span><b>M02 </b></span>
                    </div>
                    <div class="col-sm-4 text-center">
                        <span>01:21 m</span>
                    </div>
                    <div class="col-sm-4 text-right">
                        <a class="btn btn-primary" style="float:right;" href="#">Info</a>
                    </div>
                </div>

            </div>
                
            <ul class="list-group list-group-flush">

                <li class="list-group-item">
                    <div class="row"   >
                        {{--<div class="col-sm-1 " style="height:15px;display: flex;">
                            <div class="ped-stat-sticker"></div>
                        </div>--}}
                        <div class="col-sm-8">
                            Cebiches pequeños 
                            <div class="row">
                                <div class="col-sm-12">
                                    Sin Aji
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2"><span class="card-text"> 4m </span></div>
                        <div class="col-sm-2 text-right"><a class="btn btn-primary"  href="#">V</a></div>
                    </div>
                </li>

            </ul>

        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            console.log('Component mounted.')

        },
        props: ['features']   
    }
</script>
