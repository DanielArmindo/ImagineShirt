<style>
    .photo_perfil{
        max-width: 100px;
    }
</style>
<x-app-layout>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{route('home.index')}}" rel="nofollow">Home</a>
                    <span></span> Admin
                    <span></span> @yield('operation')
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                @yield('operation_action')
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-25">
                                <h4>@yield('operation')</h4>
                            </div>

                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Full Name" value="{{ old('name', $user->name) }}" required>
                                </div>
                                @error('name')
                                    {{$message}}
                                @enderror

                                <div class="form-group">
                                    <input type="email" name="email" placeholder="Email Address" value="{{ old('email', $user->email) }}" required>
                                </div>
                                @error('email')
                                    {{$message}}
                                @enderror

                                <div class="form-group">
                                    <div class="custom_select">
                                        <select class="form-control select-active" name="user_type" required>
                                            <option {{ $user->user_type == 'A' ? 'selected' : '' }} value="A">Administrator</option>
                                            <option {{ $user->user_type == 'E' ? 'selected' : '' }} value="E">Employee</option>
                                        </select>
                                    </div>
                                </div>
                                @error('user_type')
                                    {{$message}}
                                @enderror

                                @yield('password')

                        </div>
                        <div class="col-md-6">
                            <div class="order_review">
                                <div class="mb-20">
                                    <h4>Perfil Photo</h4>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <img id="perfil_photo" src="{{asset('/storage/photos/'.$user->photo_url)}}" class="border photo_perfil" alt="Whithout Photo">
                                    </div>
                                    <div class="col-md-9">
                                        <input type="file" name="file_photo" accept="image/png, image/jpeg" onchange="readURL(this);">
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-fill-out btn-block mt-30" value="@yield('operation')">
                        </div>

                    </div>
                </form>
            </div>
        </section>
    </main>
</x-app-layout>
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
