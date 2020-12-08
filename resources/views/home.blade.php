@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Main Page</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <form>
                            @csrf
                            <div class="col-md-6">
                                <textarea id="article" name="article" rows="4" cols="50">
                                </textarea>
                            </div>
                          <span id="ar_error"></span>
                          <div class="col-md-6 offset-3 mt-2">
                            <button type="button" class="btn btn-primary"   id="save_article">Save</button>
                          <a href="{{route('category')}}" class="btn btn-info">Category page</a>
                          </div>
                        </form>
                        <div class="container" style="padding-top:38px">
                                <h2>Article List</h2>
                            <div class="row">
                                <table style="width:50%;border: 1px solid black;
                                border-collapse: collapse;">
                                    <thead>
                                        <th style="width:50%;border: 1px solid black;
                                        border-collapse: collapse;">Article</th>
                                        <th style="width:50%;border: 1px solid black;
                                        border-collapse: collapse;">Action</th>
                                    </thead>
                                    <tbody id="article_body" ></tbody>
                                </table>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Article</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <form>
        @csrf
        <input type='hidden' id="article_id">
            <div class="col-md-6">
                    <textarea id="article_modal" name="article" rows="4" cols="50">
                    </textarea>
                </div>
                <span id="ar_error"></span>
                <div class="col-md-6 offset-3 mt-2">
                <div class="modal-footer">
                <button type="button" class="btn btn-primary"  id="edit_article">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </form>
        </div>

        </div>
    </div>
</div>

@endsection
@push('scripts')


<script>
        $(function()
        {
            // $("#modal").hide();
            get_articles();
            $("#save_article").click(function(){
            var article = $("#article").val();
            if(article==null || article=='')
            {
                $(".rm_err").remove();
                $('#ar_error').append("<span class='rm_err'>Please enter article</span>").css("color", "red");
                $('.rm_err').delay(2000).fadeOut(2000);
            }
            else{
                    $.ajax({
                        url: "{!! route('save_article') !!}",
                        type:'POST',
                        async:true,
                        data: {"_token": "{{ csrf_token() }}",
                            "article": article
                        }, success: function(result){
                            get_articles();
                            $("#article").val('');
                        }
                    })
                    .done(function( data ) {
                    });
                }

         });
            $("#edit_article").click(function(){
                    var id=$("#article_id").val();
                    var article_val=$("#article_modal").val();

                    $.ajax({
                            url: "{!! route('edit_article_save') !!}",
                            type:'POST',
                            async:true,
                            data: {"_token": "{{ csrf_token() }}",
                            'id':id,
                            'article_val':article_val,
                            }, success: function(result){
                                    $("#article").val('');
                                    get_articles();
                                    $("#modal").modal('hide');
                            }
                            });
                    });
        });

$("#close").click(function(){
            $("#modal").hide();

});
function get_articles()
{
    $.ajax({
            url: "{!! route('get_article') !!}",
            type:'GET',
            async:true,
            data: {"_token": "{{ csrf_token() }}",
            }, success: function(result){
                console.log(result);
               var article=[];
               var data="";
                $.each(result,function(key,value){
                    data+= '<tr style="width:50%;border: 1px solid black;border-collapse: collapse;">'+
                                '<td style="width:50%;border: 1px solid black;border-collapse: collapse;">'+value.article+'</td>'+
                                '<td style="width:50%;border: 1px solid black;border-collapse: collapse;"><span onclick="edit_article('+
                                +value.id+')" style="cursor:pointer">Edit</span>/<span onclick="delete_article('+value.id+')" style="cursor:pointer">Delete</span></td>'+
                            '</tr>';
                        });
                        $("#article_body").html(data);
            }
            });
}

function edit_article(id)
{
    $.ajax({
            url: "{!! route('edit_article') !!}",
            type:'GET',
            async:true,
            data: {"_token": "{{ csrf_token() }}",
            'id':id
            }, success: function(result){
            $("#modal").modal('show');
            $("#article_modal").html(result.article);
            $("#article_id").val(result.id);
            }
            });
}

function delete_article(id)
{
  window.location.href = "{{URL::to('/delete-article')}}/"+id;
}


        </script>
@endpush
