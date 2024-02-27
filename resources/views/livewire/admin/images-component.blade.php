<style>
    .custom_select .select2-container--default .select2-selection--single {
        width: 160px;
        padding-right: 50px;
    }
</style>
<style>

    /*Pagination Style*/
    [aria-current] .page-link {
        color: orange;
    }

    .page-item.active .page-link{
        background-color: darkorange;
        border-color: orange;
    }

    [rel='prev'], [rel='next'] {
        color: darkorange;
    }

    [rel='prev']:hover, [rel='next']:hover {
        color: white;
        background-color: darkorange;
    }

    .pagination > li :not([rel='prev'],[rel='next'],[aria-current] .page-link) {
        color: darkorange;
    }

    .search-style-1{
        margin-bottom: 15px;
    }

    p{
        margin-bottom: 0;
    }

    .autosize_button{
        border: none;
        background: none;
        text-decoration: none;
        color: #F15412;
    }
    .search-style-1 form {
        width: 100%;
    }
    .improviso:hover{
        color: #F15412;
    }
    input {
        height: unset;
        font-size: unset;
    }
</style>
<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home.index') }}" rel="nofollow">Home</a>
                <span></span> Images
            </div>
        </div>
    </div>
    <section class="pt-150 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="dashboard-menu">
                                <ul class="nav flex-column" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link
                                        @if ($orders_selected == 0) active @endif
                                        "
                                            id="update-tab" data-bs-toggle="tab" href="#update" role="tab"
                                            aria-controls="update" aria-selected="false"><i
                                                class="fi-rs-edit mr-10"></i>Update</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link
                                        @if ($orders_selected == 1) active @endif
                                        "
                                            id="remove-tab" data-bs-toggle="tab" href="#remove" role="tab"
                                            aria-controls="remove" aria-selected="false"><i
                                                class="fi-rs-trash mr-10"></i>Remove</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link
                                        @if ($orders_selected == 2) active @endif
                                        "
                                            id="add-tab" data-bs-toggle="tab" href="#add" role="tab"
                                            aria-controls="add" aria-selected="false"><i
                                                class="fi-rs-plus mr-10"></i>Add</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content dashboard-content">
                                <!--Update-->
                                <div class="tab-pane fade
                                @if ($orders_selected == 0) active show @endif
                                "
                                    id="update" role="tabpanel" aria-labelledby="update-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Update</h5>
                                        </div>
                                        <div class="card-body">
                                            @if ($msg1 != '')
                                            <div class="mb-20 mt-20 text-center">
                                                <h4 style="color: darkgoldenrod">{{$msg1}}</h4>
                                            </div>
                                            @endif
                                            <section class="section-padding">
                                                <div class="col-lg-12 col-md-12 col-6 col-sm-6 p-2">
                                                    <div class="search-style-3">
                                                        <form action="{{route('product.search')}}">
                                                            <input type="text" name="q" placeholder="Search for items...">
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="container">
                                                    <div class="row product-grid-3">
                                                        @foreach ($products as $product)
                                                        <div class="col-lg-4 col-md-4 col-6 col-sm-6">
                                                            <div class="product-cart-wrap mb-30">
                                                                <div class="product-img-action-wrap">
                                                                    <div class="product-img product-img-zoom">
                                                                        <a href="{{route('admin.images',['upImage'=>$product])}}" class="text-center">
                                                                            <img class="default-img" src="
                                                                            {{$images[$loop->index]}}
                                                                            " alt="Sem foto Disponivel">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="product-content-wrap">
                                                                    <div class="product-category">
                                                                        <a href="#">
                                                                            @if ($product->categorieRef == null)
                                                                            Sem Categoria
                                                                            @else
                                                                            {{$product->categorieRef->name}}
                                                                            @endif
                                                                    </div>
                                                                    <h2><a href="#">{{$product->name}}</a></h2>



                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach

                                                    </div>
                                                    <!--pagination-->
                                                    {{$products->appends(['orders_selected'=>0])->links("pagination::bootstrap-5");}}
                                                </div>
                                                <div class="container">
                                                    <form action="{{route('admin.edit.image',['image'=>$code])}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                    <div class="row product-grid-3">
                                                        <div class="col-lg-4 col-md-4 col-6 col-sm-6 p-5">

                                                            <h4 class="font-heading mb-20">
                                                                Image
                                                            </h4>
                                                            <input type="file" name="ficheiro"
                                                                accept="image/png"
                                                                onchange="readURL(this);">
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-6 col-sm-6 p-5">
                                                            <h4 class="font-heading mb-20">
                                                                Name
                                                            </h4>
                                                            <input type="text" name="name" value="{{$image!=null?$image->name:'None'}}">
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-6 col-sm-6 p-5">
                                                            <h4 class="font-heading mb-20">
                                                                Descrition
                                                            </h4>
                                                            <input type="text" name="desc" value="{{$image!=null?$image->description:'None'}}">

                                                        </div>
                                                    </div>
                                                    <p class="text-center"><button type="submit" >Update Image</button></p>
                                                    </form>
                                                </div>


                                            </section>
                                        </div>



                                    </div>
                                </div>


                                <!--Delete-->
                                <div class="tab-pane fade
                                @if ($orders_selected == 1) active show @endif
                                "
                                    id="remove" role="tabpanel" aria-labelledby="remove-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Remove</h5>
                                        </div>
                                        <div class="card-body">

                                            <section class="section-padding">
                                                <div class="col-lg-12 col-md-12 col-6 col-sm-6 p-2">
                                                    <div class="search-style-3">
                                                        <form action="{{route('product.search')}}">
                                                            <input type="text" name="q" placeholder="Search for items...">
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="container">
                                                    @if ($msg2 != '')
                                                        <div class="mb-20 mt-20 text-center">
                                                            <h4 style="color: darkgoldenrod">{{$msg2}}</h4>
                                                        </div>
                                                    @endif
                                                    <div class="row product-grid-3">
                                                        @foreach ($products as $product)
                                                        <div class="col-lg-4 col-md-4 col-6 col-sm-6">
                                                            <div class="product-cart-wrap mb-30">
                                                                <div class="product-img-action-wrap">
                                                                    <div class="product-img product-img-zoom">
                                                                        <a href="#" class="text-center" name="delete" data-bs-toggle="modal"
                                                                        data-bs-target="#confirmationModal"
                                                                        data-msgLine1="Are you sure to delete this image?"
                                                                        data-action="{{ route('admin.destroy.image',['image' => $product]) }}">
                                                                            <img class="default-img" src="{{$images[$loop->index]}}" alt="Sem foto Disponivel">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="product-content-wrap">
                                                                    <div class="product-category">
                                                                        <a href="#">
                                                                            @if ($product->categorieRef == null)
                                                                            Sem Categoria
                                                                            @else
                                                                            {{$product->categorieRef->name}}
                                                                            @endif
                                                                    </div>
                                                                    <h2><a href="#">{{$product->name}}</a></h2>



                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach

                                                    </div>
                                                    <!--pagination-->

                                                            {{$products->appends(['orders_selected'=>2])->links("pagination::bootstrap-5");}}

                                                </div>
                                                <div class="container">


                                                        <div class="col-lg-12 col-md-12 col-6 col-sm-6 p-5">


                                                            <input type="submit"
                                                                class="btn btn-fill-out btn-block mt-30"
                                                                value="Remove">
                                                        </div>




                                            </section>
                                        </div>



                                    </div>
                                </div>

                                <!--New-->
                                <div class="tab-pane fade
                                @if ($orders_selected == 2) active show @endif
                                "
                                    id="add" role="tabpanel" aria-labelledby="add-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Add</h5>
                                        </div>
                                        <div class="card-body">
                                            @if ($msg3 != '')
                                            <div class="mb-20 mt-20 text-center">
                                                <h4 style="color: darkgoldenrod">{{$msg3}}</h4>
                                            </div>
                                             @endif
                                            <section class="section-padding">

                                                <div class="container">
                                                    <form action="{{route('admin.new.image')}}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                    <div class="row product-grid-3">
                                                        <div class="col-lg-4 col-md-4 col-6 col-sm-6 p-5">
                                                            <p class="text-center">
                                                                <img alt="Sem Imagem" id="perfil_photo" height="100px" width="100px">
                                                            </p>
                                                            <input type="file" name="ficheiro"
                                                                accept="image/png"
                                                                onchange="readURL(this);" required>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-6 col-sm-6 p-5">
                                                            <h4 class="font-heading mb-20">
                                                                Name
                                                            </h4>
                                                            <input type="text" name="name" required>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-6 col-sm-6 p-5">
                                                            <h4 class="font-heading mb-20">
                                                                Descrition
                                                            </h4>
                                                            <input type="text" name="desc" required>
                                                        </div>
                                                    </div>
                                                    <p class="text-center"><button type="submit" class="btn">Save new Image</button></p>
                                                    </form>
                                                </div>

                                            </section>
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>
</main>
<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#perfil_photo')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@include('shared.confirmationDialog',[
'title' => 'Delete Image',
'msgLine1' => 'Clique no botão "Apagar" para confirmar a operação',
'msgLine2' => '',
'confirmationButton' => 'Apagar',
'formMethod' => 'DELETE',
])
