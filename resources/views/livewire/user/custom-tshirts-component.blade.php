<x-app-layout>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow">Home</a>
                    <span></span> Custom tshirts from {{$name}}
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <h3 style="margin-bottom:20px">Choose your custom tshirt created previously to choose de color</h3>
                <div class="row">
                    <div class="col-lg-9">
                        <div class="row product-grid-3">
                            @if ($products->count() == 0)
                            <h1 style="margin-bottom:20px">Without Custom Tshirts</h1>
                            @else
                                @foreach ($products as $product)
                                <div class="col-lg-4 col-md-4 col-6 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <!--Add custom tshirt to customize-->
                                                <a href="{{route('user.select.custom.tshirts',['tshirt'=>$product])}}" class="text-center">
                                                    <img class="default-img" src="
                                                    {{$images[$loop->index]}}
                                                    " alt="Sem foto Disponivel">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-action-1 show">
                                                @if ($product->order_itemRef->count() ==0)

                                                <a aria-label="Delete" class="action-btn hover-up" name="delete" data-bs-toggle="modal"
                                                            data-bs-target="#confirmationModal"
                                                            data-msgLine1="Quer realmente apagar esta Tshirt que customizou?"
                                                            data-action="{{route('user.delete.custom.tshirt',['tshirt'=>$product])}}">
                                                            <i class="fi-rs-trash"></i>
                                                </a>
                                                @endif
                                                <a aria-label="Customize" class="action-btn hover-up" href="{{route('user.select.custom.tshirts',['tshirt'=>$product])}}"><i class="fi-rs-plus"></i></a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('shared.confirmationDialog',[
        'title' => 'Apagar Tshirt',
        'msgLine1' => 'Clique no botão "Apagar" para confirmar a operação',
        'msgLine2' => '',
        'confirmationButton' => 'Apagar',
        'formMethod' => 'DELETE',
    ])
</x-app-layout>
