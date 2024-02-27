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
                <span></span> Categories
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
                                <div class="tab-pane fade
                                @if ($orders_selected == 0) active show @endif
                                "
                                    id="update" role="tabpanel" aria-labelledby="update-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Update</h5>
                                        </div>
                                        <div class="card-body">
                                            @if($msg1 != '')
                                                <div class="mb-20 mt-20 text-center">
                                                    <h4 style="color: darkgoldenrod">{{$msg1}}</h4>
                                                </div>
                                            @endif
                                            <section class="section-padding">
                                                <div class="container">
                                                    <h3 class="section-title mb-20 wow fadeIn animated"><span>Select
                                                            categorie to update the name</span> </h3>
                                                    <div
                                                        class="carausel-6-columns-cover position-relative wow fadeIn animated">
                                                        <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow"
                                                            id="carausel-6-columns-3-arrows"></div>
                                                        <div class="carausel-6-columns text-center"
                                                            id="carausel-6-columns-3">
                                                            @foreach ($categories as $category )
                                                            <li><a class="text-dark" href="{{route('admin.categories',['change_category'=>$category->id])}}">{{$category->name}}</a></li>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="container">
                                                    <div class="row text-center">
                                                        <form action="{{route('admin.update.category',['category'=>$upcat])}}" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <h5 class="font-heading mb-30 mt-30">Name Category</h5>
                                                            <input type="text" name="name" value="{{$name}}" required>
                                                            <input type="submit" class="btn btn-fill-out btn-block mt-30" value="Update Category">
                                                        </form>
                                                        </div>
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
                                            @if ($msg2 != '')
                                                <div class="mb-20 mt-20 text-center">
                                                    <h4 style="color: darkgoldenrod">{{$msg2}}</h4>
                                                </div>
                                            @endif
                                            <section class="section-padding">
                                                <div class="container">
                                                    <h3 class="section-title mb-20 wow fadeIn animated"><span>Select categorie to remove</span> </h3>
                                                    <div
                                                        class="carausel-6-columns-cover position-relative wow fadeIn animated">
                                                        <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow" id="carausel-7-columns-arrows"></div>
                                                        <div class="carausel-6-columns text-center" id="carausel-7-columns">
                                                            @foreach ($categories as $category )

                                                            <li><a class="text-dark" name="delete" data-bs-toggle="modal"
                                                                data-bs-target="#confirmationModal"
                                                                data-msgLine1="Are you sure to delete category '{{$category->name}}'?"
                                                                data-action="{{ route('admin.destroy.category',['category' => $category]) }}" href="#">{{$category->name}}</a></li>

                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="container mt-40">
                                                    <h4 class="font-heading ">Select arrow to show categories</h4>
                                                </div>
                                            </section>
                                        </div>



                                    </div>
                                </div>

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
                                                    <div class="row text-center">
                                                    <form action="{{route('admin.create.category')}}" method="post">
                                                        @csrf
                                                        <h3 class="font-heading mb-40">Name Category</h3>
                                                        <input type="text" name="name" required>
                                                        <input type="submit" class="btn btn-fill-out btn-block mt-30" value="Save New Category">
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

@include('shared.confirmationDialog',[
    'title' => 'Delete Category',
    'msgLine1' => 'Clique no botão "Apagar" para confirmar a operação',
    'msgLine2' => '',
    'confirmationButton' => 'Apagar',
    'formMethod' => 'DELETE',
])
