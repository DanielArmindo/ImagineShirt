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
                <a href="{{route('home.index')}}" rel="nofollow">Home</a>
                <span></span> My Account
            </div>
        </div>
    </div>
    <section class="pt-80 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="dashboard-menu">
                                <ul class="nav flex-column" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link
                                        @if ($user_type_view == 1)
                                            active
                                        @endif"
                                        id="admins-tab" data-bs-toggle="tab" href="#admins" role="tab" aria-controls="dashboard" aria-selected="false"><i class="fi fi-rs-settings mr-10"></i>Admins</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link
                                        @if ($user_type_view == 2)
                                            active
                                        @endif"
                                        id="employees-tab" data-bs-toggle="tab" href="#employees" role="tab" aria-controls="employees" aria-selected="false"><i class="fi fi-rs-pencil mr-10"></i>Employees</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link
                                        @if ($user_type_view == 3)
                                            active
                                        @endif"
                                        id="clients-tab" data-bs-toggle="tab" href="#clients" role="tab" aria-controls="track-orders" aria-selected="false"><i class="fi fi-rs-users mr-10"></i>Clients</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link
                                        @if ($user_type_view == 4)
                                            active
                                        @endif"
                                        id="removed-users-tab" data-bs-toggle="tab" href="#removed-users" role="tab" aria-controls="removed-users" aria-selected="false"><i class="fi fi-rs-delete mr-10"></i>Removed Users</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('admin.create')}}" ><i class="fi fi-rs-user-add mr-10"></i>Create Perfil (Admin or Employee)</a>
                                    </li>

                                    <li class="nav-item">
                                        <form method="POST" action="{{route('logout')}}">
                                            @csrf
                                            <a class="nav-link" href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();"><i class="fi-rs-sign-out mr-10"></i>Logout</a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="tab-content dashboard-content">

                                <!--Admins-->
                                <div class="tab-pane fade
                                @if ($user_type_view == 1)
                                active show
                                @endif"
                                id="admins" role="tabpanel" aria-labelledby="admins-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Information about all administrators</h5>
                                        </div>
                                        <!--Listagem Admins-->
                                        <div class="card-body">

                                            <div class="search-style-1">
                                                <form action="{{route('admin.search')}}" method="GET">
                                                    <input style="display: none" type="text" value="admins" name="type_search" readonly>
                                                    <input style="width: 75%" type="text" placeholder="Search for Admins..." name="search_name" value="{{$msg1}}">
                                                    <input class="improviso btn-buscar-top" style="display: inline-block;width:20%;padding:0" type="submit" value="Search">
                                                </form>
                                            </div>

                                                @if($admins->onFirstPage() && $admins->count() == 0)
                                                    <h4 class="mb-0">Without admins</h4>
                                                @else
                                                    @foreach ($admins as $admin)
                                                    <div class="row" style="margin-bottom:15px">
                                                    <div class="col-lg-2 mb-lg-0 mb-4 text-center"><img alt="Sem Imagem" class="border" src="{{asset('/storage/photos/'.$admin->photo_url)}}" alt=""></div>
                                                    <div class="col-lg-10 mb-lg-0 mb-4" style="mar">
                                                        <p><span style="font-weight: 600;">Nome:</span> {{$admin->name}}</p>
                                                        <p><span style="font-weight: 600;">Email:</span> {{$admin->email}}</p>
                                                        @if ($admin->blocked)
                                                            <p><span style="font-weight: 600;">Status Account:</span> Blocked</p>
                                                        @endif

                                                            <a href="{{route('admin.edit',['admin' => $admin])}}">Editar Perfil</a> /
                                                            @if ($admin->blocked)
                                                                <form action="{{route('admin.blockChange',['admin' => $admin])}}" method="post" style="display:inline-block">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="number" name="flag" value="2" readonly style="display:none">
                                                                    <input type="submit" class="autosize_button" value="Desbloquear Perfil" style="padding-left: 0;">
                                                                </form>
                                                            @else
                                                                <form action="{{route('admin.blockChange',['admin' => $admin])}}" method="post" style="display:inline-block">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="number" name="flag" value="1" readonly style="display:none">
                                                                    <input type="submit" class="autosize_button" value="Bloquear Perfil" style="padding-left: 0;">
                                                                </form>
                                                            @endif
                                                            /<button class="autosize_button" name="delete" data-bs-toggle="modal"
                                                            data-bs-target="#confirmationModal"
                                                            data-msgLine1="Quer realmente apagar o utilizador <strong>&quot;{{ $admin->name }}&quot;</strong>?"
                                                            data-action="{{ route('admin.destroy', ['admin' => $admin]) }}">
                                                            Delete User</button>

                                                    </div>
                                                    </div>
                                                    @endforeach
                                                @endif

                                                @if(!($admins->onFirstPage() && $admins->count() == 0))
                                                    {{$admins->appends(['user_type_view'=>1])->links("pagination::bootstrap-5")}}
                                                @endif

                                        </div>
                                        <!--Fim Listagem Admins-->
                                    </div>

                                </div>

                                <!--Empregados-->
                                <div class="tab-pane fade
                                @if ($user_type_view == 2)
                                    active show
                                @endif"
                                id="employees" role="tabpanel" aria-labelledby="employees-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Information about all employees</h5>
                                        </div>
                                        <!--Listagem Empregados-->
                                        <div class="card-body">

                                            <div class="search-style-1">
                                                <form action="{{route('admin.search')}}" method="GET">
                                                    <input style="display: none" type="text" value="employees" name="type_search" readonly>
                                                    <input style="width: 75%" type="text" placeholder="Search for Employees..." name="search_name" value="{{$msg2}}">
                                                    <input class="improviso btn-buscar-top" style="display: inline-block;width:20%;padding:0" type="submit" value="Search">
                                                </form>
                                            </div>

                                                @if($employees->onFirstPage() && $employees->count() == 0)
                                                    <h4 class="mb-0">Without Employees</h4>
                                                @else
                                                    @foreach ($employees as $employee)
                                                    <div class="row" style="margin-bottom:15px">
                                                    <div class="col-lg-2 align-self-center mb-lg-0 mb-4"><img alt="Sem Imagem" class="border" src="{{asset('/storage/photos/'.$employee->photo_url)}}" alt=""></div>
                                                    <div class="col-lg-10 align-self-center mb-lg-0 mb-4" style="mar">
                                                        <p><span style="font-weight: 600;">Nome:</span> {{$employee->name}}</p>
                                                        <p><span style="font-weight: 600;">Email:</span> {{$employee->email}}</p>
                                                        @if ($employee->blocked)
                                                        <p><span style="font-weight: 600;">Status Account:</span> Blocked</p>
                                                        @endif

                                                        <a href="{{route('admin.edit',['admin' => $employee])}}">Editar Perfil</a> /
                                                        @if ($employee->blocked)
                                                            <form action="{{route('admin.blockChange',['admin' => $employee])}}" method="post" style="display:inline-block">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="number" name="flag" value="2" readonly style="display:none">
                                                                <input type="submit" class="autosize_button" value="Desbloquear Perfil" style="padding-left: 0;">
                                                            </form>
                                                        @else
                                                            <form action="{{route('admin.blockChange',['admin' => $employee])}}" method="post" style="display:inline-block">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="number" name="flag" value="1" readonly style="display:none">
                                                                <input type="submit" class="autosize_button" value="Bloquear Perfil" style="padding-left: 0;">
                                                            </form>
                                                        @endif
                                                        /<button class="autosize_button" name="delete" data-bs-toggle="modal"
                                                        data-bs-target="#confirmationModal"
                                                        data-msgLine1="Quer realmente apagar o utilizador <strong>&quot;{{ $employee->name }}&quot;</strong>?"
                                                        data-action="{{ route('admin.destroy', ['admin' => $employee]) }}">
                                                        Delete User</button>
                                                    </div>
                                                    </div>
                                                    @endforeach
                                                @endif

                                                @if(!($employees->onFirstPage() && $employees->count() == 0))
                                                    {{$employees->appends(['user_type_view'=>2])->links("pagination::bootstrap-5")}}
                                                @endif

                                        </div>
                                        <!--Fim Listagem Empregados-->
                                    </div>
                                </div>

                                <!--Clientes-->
                                <div class="tab-pane fade
                                @if ($user_type_view == 3)
                                active show
                                @endif"
                                id="clients" role="tabpanel" aria-labelledby="clients-tab">
                                    <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">Information about all clients</h5>
                                    </div>
                                    <!--Listagem Clientes-->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="search-style-1">
                                                <form action="{{route('admin.search')}}" method="GET">
                                                    <input style="display: none" type="text" value="clients" name="type_search" readonly>
                                                    <input style="width: 75%" type="text" placeholder="Search for Clients..." name="search_name" value="{{$msg3}}">
                                                    <input class="improviso btn-buscar-top" style="display: inline-block;width:20%;padding:0" type="submit" value="Search">
                                                </form>
                                            </div>

                                                @if($clients->onFirstPage() && $clients->count() == 0)
                                                    <h4 class="mb-0">Without Clients</h4>
                                                @else
                                                    @foreach ($clients as $client)
                                                    <div class="row" style="margin-bottom:15px">
                                                    <div class="col-lg-2 align-self-center mb-lg-0 mb-4"><img alt="Sem Imagem" class="border" src="{{asset('/storage/photos/'.$client->photo_url)}}" alt=""></div>
                                                    <div class="col-lg-10 align-self-center mb-lg-0 mb-4" style="mar">
                                                        <p><span style="font-weight: 600;">Nome:</span> {{$client->name}}</p>
                                                        <p><span style="font-weight: 600;">Email:</span> {{$client->email}}</p>
                                                        <p><span style="font-weight: bold;">Customer_ID:</span> {{$client->id}}</p>
                                                        @if ($client->blocked)
                                                            <p><span style="font-weight: 600;">Status Account:</span> Blocked</p>
                                                        @endif
                                                            @if ($client->blocked)
                                                                <form action="{{route('admin.blockChange',['admin' => $client])}}" method="post" style="display:inline-block">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="number" name="flag" value="2" readonly style="display:none">
                                                                    <input type="submit" class="autosize_button" value="Desbloquear Perfil" style="padding-left: 0;">
                                                                </form>
                                                            @else
                                                                <form action="{{route('admin.blockChange',['admin' => $client])}}" method="post" style="display:inline-block">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="number" name="flag" value="1" readonly style="display:none">
                                                                    <input type="submit" class="autosize_button" value="Bloquear Perfil" style="padding-left: 0;">
                                                                </form>
                                                            @endif
                                                            /<button class="autosize_button" name="delete" data-bs-toggle="modal"
                                                            data-bs-target="#confirmationModal"
                                                            data-msgLine1="Quer realmente apagar o utilizador <strong>&quot;{{ $client->name }}&quot;</strong>?"
                                                            data-action="{{ route('admin.destroy', ['admin' => $client]) }}">
                                                            Delete User</button>
                                                    </div>
                                                    </div>
                                                    @endforeach
                                                @endif

                                                @if(!($clients->onFirstPage() && $clients->count() == 0))

                                                    {{$clients->appends(['user_type_view'=>3])->links("pagination::bootstrap-5")}}

                                                @endif

                                        </div>
                                    </div>
                                    <!--Fim Listagem Clientes-->
                                </div>
                                </div>

                                <!--Removed Users-->
                                <div class="tab-pane fade
                                @if ($user_type_view == 4)
                                active show
                                @endif"
                                id="removed-users" role="tabpanel" aria-labelledby="removed-users-tab">
                                    <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">Information about all deleted users</h5>
                                    </div>
                                    <!--Listagem Clientes-->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="search-style-1">
                                                <form action="{{route('admin.search')}}" method="GET">
                                                    <input style="display: none" type="text" value="revoked" name="type_search" readonly>
                                                    <input style="width: 75%" type="text" placeholder="Search for Clients..." name="search_name" value="{{$msg4}}">
                                                    <input class="improviso btn-buscar-top" style="display: inline-block;width:20%;padding:0" type="submit" value="Search">
                                                </form>
                                            </div>

                                                @if($users_deleted->onFirstPage() && $users_deleted->count() == 0)
                                                    <h4 class="mb-0">Without Removed Users</h4>
                                                @else

                                                    <div class="container mb-3">
                                                        <form action="{{route('admin.undoAllDeleted')}}" method="post" style="display:inline-block">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="submit" class="btn" value="Undo delete to all users">
                                                        </form>
                                                    </div>

                                                    @foreach ($users_deleted as $user)
                                                    <div class="row" style="margin-bottom:15px">
                                                    <div class="col-lg-2 align-self-center mb-lg-0 mb-4"><img alt="Sem Imagem" class="border" src="{{asset('/storage/photos/'.$user->photo_url)}}" alt=""></div>
                                                    <div class="col-lg-10 align-self-center mb-lg-0 mb-4" style="mar">
                                                        <p><span style="font-weight: 600;">Nome:</span> {{$user->name}}</p>
                                                        <p><span style="font-weight: 600;">Type User:</span>
                                                        @switch($user->user_type)
                                                            @case('A')
                                                                Admin
                                                                @break
                                                            @case('E')
                                                                Employee
                                                                @break
                                                            @case('C')
                                                                Client
                                                                @break

                                                        @endswitch
                                                        </p>
                                                        <form action="{{route('admin.undo.delete')}}" method="post" style="display:inline-block">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="number" name="user" value="{{$user->id}}" style="display: none">
                                                            <input type="submit" class="autosize_button" value="Undo Delete" style="padding-left: 0;">
                                                        </form>

                                                    </div>
                                                    </div>
                                                    @endforeach
                                                @endif

                                                @if(!($users_deleted->onFirstPage() && $users_deleted->count() == 0))
                                                    {{$users_deleted->appends(['user_type_view'=>4])->links("pagination::bootstrap-5")}}
                                                @endif

                                        </div>
                                    </div>
                                    <!--Fim Listagem Clientes-->
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
    'title' => 'Apagar User',
    'msgLine1' => 'Clique no botão "Apagar" para confirmar a operação',
    'msgLine2' => '',
    'confirmationButton' => 'Apagar',
    'formMethod' => 'DELETE',
])
