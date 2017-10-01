@extends('layouts.app')

@section('content')

    <ul id="Huifold1" class="Huifold">
        <li class="item">
            <h4>标题<b>+</b></h4>
            <div class="info">
                <ul id="Huifold2" class="Huifold">
                    <li class="item">
                        <h4>标题<b>+</b></h4>
                        <div class="info">
                            <ul id="Huifold2" class="Huifold">
                                <li class="item">
                                    <h4>标题<b>+</b></h4>
                                    <div class="info">
                                        <ul id="Huifold2" class="Huifold">
                                            <li class="item">
                                                <h4>标题<b>+</b></h4>
                                                <div class="info"> 内容<br>很多内容 </div>
                                            </li>
                                            <li class="item">
                                                <h4>标题<b>+</b></h4>
                                                <div class="info"> 内容<br>很多内容 </div>
                                            </li>
                                            <li class="item">
                                                <h4>标题<b>+</b></h4>
                                                <div class="info"> 内容<br>很多内容 </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="item">
                                    <h4>标题<b>+</b></h4>
                                    <div class="info"> 内容<br>很多内容 </div>
                                </li>
                                <li class="item">
                                    <h4>标题<b>+</b></h4>
                                    <div class="info"> 内容<br>很多内容 </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="item">
                        <h4>标题<b>+</b></h4>
                        <div class="info"> 内容<br>很多内容 </div>
                    </li>
                    <li class="item">
                        <h4>标题<b>+</b></h4>
                        <div class="info"> 内容<br>很多内容 </div>
                    </li>
                </ul>
            </div>
        </li>
        <li class="item">
            <h4>标题<b>+</b></h4>
            <div class="info"> 内容<br>很多内容 </div>
        </li>
        <li class="item">
            <h4>标题<b>+</b></h4>
            <div class="info"> 内容<br>很多内容 </div>
        </li>
    </ul>

@endsection

@section('script')
    <script>
        //XiaoSong改过了Hui的东西 为了方便观察 类型只能穿3 不然报错
        jQuery.Huifold = function(obj,obj_c,speed,obj_type,Event){

            $(obj).bind(Event,function(){
                if($(this).next().is(":visible")){
                    $(this).next().slideUp(speed).end().removeClass("selected");
                    $(this).find("b").html("+")}
                else{
                    $(this).next().slideDown(speed).end().addClass("selected");
                    $(this).find("b").html("-")
                }
            })}

        $(function(){
            $.Huifold("#Huifold1 .item h4","#Huifold1 .item .info","fast",3,"click"); /*5个参数顺序不可打乱，分别是：相应区,隐藏显示的内容,速度,类型,事件*/
        });
    </script>
@endsection