<style>
    .custom_select .select2-container--default .select2-selection--single {
        width: 160px;
        padding-right: 50px;
    }
</style>
<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home.index') }}" rel="nofollow">Home</a>
                <span></span> Colors
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
                                            @if ($msg3 != '')
                                                <div class="mb-20 mt-20 text-center">
                                                    <h4 style="color: darkgoldenrod">{{$msg3}}</h4>
                                                </div>
                                            @endif

                                            <section class="section-padding">
                                                <div class="container">
                                                    <h3 class="section-title mb-20 wow fadeIn animated"><span>Select color of tshirt to update</span></h3>
                                                    <div class="carausel-6-columns-cover position-relative wow fadeIn animated">
                                                        <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow"
                                                            id="carausel-6-columns-3-arrows"></div>
                                                        <div class="carausel-6-columns text-center"
                                                            id="carausel-6-columns-3">
                                                            @foreach ($tshirts as $tshirt)
                                                                @foreach ($tshirt as $image => $url)
                                                                    <li><a class="text-dark" href="{{route('admin.colors',['upcolor'=>$url])}}"><img src="{{ $image }}" alt=""></a></li>
                                                                @endforeach
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="container">
                                                    <div class="row product-grid-2">
                                                        <form action="{{route('admin.edit.color',['color'=>$code])}}" method="post" enctype="multipart/form-data" class="d-flex">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="col-lg-6 col-md-6 col-6 col-sm-6 p-5">
                                                                <h3 class="font-heading mb-40">
                                                                    Change image to color selected
                                                                </h3>
                                                                <p class="text-center">
                                                                    <img alt="Sem Imagem" id="perfil_photo" height="100px" width="100px">
                                                                </p>
                                                                <input type="file" name="file_photo" accept="image/jpeg" onchange="readURL(this);">
                                                                <p class="mt-10">Color Selecionada: <input type="text" disabled value="{{$cor!=null?$cor->name:'None'}}"></p>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-6 col-sm-6 p-5">
                                                                <h3 class="font-heading mb-40">
                                                                    Change name to color selected
                                                                </h3>
                                                                <input type="text" name="name_color">
                                                                <button type="submit" class="btn btn-fill-out btn-block mt-30">Update Tshirt</button>
                                                            </div>
                                                        </form>
                                                    </div>

                                            </section>
                                        </div>



                                    </div>
                                </div>

                                <!--Remove-->
                                <div class="tab-pane fade
                                @if ($orders_selected == 1) active show @endif
                                "
                                    id="remove" role="tabpanel" aria-labelledby="remove-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Remove</h5>
                                        </div>
                                        <div class="card-body">
                                            @if ($msg != '')
                                                <div class="mb-20 mt-20 text-center">
                                                    <h4 style="color: darkgoldenrod">{{$msg}}</h4>
                                                </div>
                                            @endif
                                            <section class="section-padding">
                                                <div class="container">
                                                    <h3 class="section-title mb-20 wow fadeIn animated"><span>Select color of tshirt to remove</span></h3>
                                                    <div class="carausel-6-columns-cover position-relative wow fadeIn animated">
                                                        <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow" id="carausel-7-columns-3-arrows"></div>
                                                        <div class="carausel-6-columns text-center" id="carausel-7-columns-3">
                                                            @foreach ($tshirts as $tshirt)
                                                                @foreach ($tshirt as $image => $url)
                                                                    <li><a class="text-dark" name="delete" data-bs-toggle="modal"
                                                                        data-bs-target="#confirmationModal"
                                                                        data-msgLine1="Are you sure to delete this color?"
                                                                        data-action="{{ route('admin.destroy.color',['color' => $url]) }}" href="#">
                                                                        <img src="{{ $image }}" alt=""></a></li>
                                                                @endforeach
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="container mt-40">
                                                    <h4 class="font-heading ">Select arrow to show colors</h4>
                                                </div>

                                            </section>
                                        </div>

                                    </div>
                                </div>

                                <!--Create-->
                                <div class="tab-pane fade
                                @if ($orders_selected == 2) active show @endif
                                "
                                    id="add" role="tabpanel" aria-labelledby="add-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Add</h5>
                                        </div>
                                        <div class="card-body">
                                            @if ($msg2 != '')
                                                <div class="mb-20 mt-20 text-center">
                                                    <h4 style="color: darkgoldenrod">{{$msg2}}</h4>
                                                </div>

                                            @endif
                                            @error('file_photo' or 'name_color')
                                                {{$message}}
                                            @enderror
                                            <section class="section-padding">
                                                <div class="container">
                                                    <div class="row product-grid-2">
                                                        <form class="d-flex" action="{{route('admin.add.color')}}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                                <div class="col-lg-6 col-md-6 col-6 col-sm-6 p-5">
                                                                    <h3 class="font-heading mb-40">
                                                                        Select image of tshirt
                                                                    </h3>
                                                                    <p class="text-center">
                                                                        <img alt="Sem Imagem" id="perfil_photo" height="100px" width="100px">
                                                                    </p>
                                                                    <input type="file" name="file_photo" required accept="image/jpeg" onchange="readURL(this);">
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-6 col-sm-6 p-5 ">
                                                                    <h3 class="font-heading mb-40">
                                                                        Name to color
                                                                    </h3>
                                                                    <input type="text" name="name_color" required>
                                                                    <button type="submit" class="btn btn-fill-out btn-block mt-30">Save color base tshirt</button>
                                                                </div>
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
    'title' => 'Delete Color',
    'msgLine1' => 'Clique no botão "Apagar" para confirmar a operação',
    'msgLine2' => '',
    'confirmationButton' => 'Apagar',
    'formMethod' => 'DELETE',
])
