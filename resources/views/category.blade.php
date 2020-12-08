@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Category Page</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <form>
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" id="catgeory" class="form-control" placeholder="Enter Category" name="catgeory">
                                    <span id="ctgy_error"></span>
                                </div>
                            </div>
                          <div class="col-md-6 offset-3 mt-2">
                            <button type="button" class="btn btn-primary"   id="save_catgeory">Save</button>
                          </div>
                        </form>
                        <form id="category_form">
                        <div class="row">
                            <div class="col-md-6">
                                <table style="width:50%;border: 1px solid black;
                                border-collapse: collapse;">
                                    <thead>
                                        <th style="width:50%;border: 1px solid black;
                                        border-collapse: collapse;">Category</th>
                                    </thead>
                                    <tbody id="category_body">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <span id="ctgy_success"></span>
                        <div id="hidden_c"></div>
                        <div class="col-md-6 offset-3 mt-2">
                            <button type="button" class="btn btn-primary"   id="save_all_catgeory">Save</button>
                        <a href="{{route('index')}}" class="btn btn-info" >Main page</a>
                          </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
 var categories = [];
 var local_data = [];
 $( document ).ready(function() {
    var data=JSON.parse(localStorage.getItem("keys"));

    var len = data.length;
            var html="";
            var html_new="";
            if(len > 0)
            {
                for(i=0;i<len;i++){

                html += "<tr>" +
    "<td style='width:50%;border:1px solid black;border-collapse: collapse;'>" + data[i].catgeory + "</td>" +
                        "</tr>";
                html_new+='<input type="hidden" name="hidden_category[]" class="hddn_c" value='+data[i].catgeory+'>';

                }
            }
            $("#category_body").html(html);
            $("#hidden_c").html(html_new);
});

$(function()
{
    $('#save_catgeory').click(function() {
            var catgeory = $("#catgeory").val();
            if(catgeory==null || catgeory=='')
            {
                $(".rm_err").remove();
                $('#ctgy_error').append("<span class='rm_err'>Please enter category</span>").css("color", "red");
                $('.rm_err').delay(2000).fadeOut(2000);
            }
            else{
                    var catgy = {
                        "catgeory": catgeory,
                    }
                    categories.push(catgy);
                    create_table(categories);
                }
            });
            group_category=[];
            $("#save_all_catgeory").click(function() {
                   $(".hddn_c").each(function() {
                       val =$(this).val();
                       group_category.push(val);
                })
            $.ajax({
                    url: "{!! route('save_all_category') !!}",
                    type:'POST',
                    async:true,
                    data: {"_token": "{{ csrf_token() }}",
                    'group_category':group_category
                    }, success: function(result){
                        $(".rm_err").remove();
                        $('#ctgy_success').append("<span class='rm_err'>All Category saved successfully</span>").css("color", "red");
                        $('.rm_err').delay(2000).fadeOut(2000);
                        $("#category_body").remove();
                        localStorage.clear();


                        }
                });
        });
})

        function create_table(categories){
            var catgeory = $("#catgeory").val("");
            var len = categories.length;
            var html="";
            var html_new="";
            if(len > 0)
            {
                for(i=0;i<len;i++){

                html += "<tr>" +
    "<td style='width:50%;border:1px solid black;border-collapse: collapse;'>" + categories[i].catgeory + "</td>" +
                        "</tr>";
                html_new+='<input type="hidden" name="hidden_category[]" class="hddn_c" value='+categories[i].catgeory+'>';
                localStorage.setItem('keys',JSON.stringify(categories));

                }
            }
            $("#category_body").html(html);
            $("#hidden_c").html(html_new);
    }

</script>

