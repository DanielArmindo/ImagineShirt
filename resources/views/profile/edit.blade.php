<x-app-layout>
    <main class="main">
        <div class="page-header breadcrumb-wrap">

            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Profile') }}
                </h2>
            </x-slot>

            <div class="container">
                <div class="breadcrumb">
                    <a href="{{route('home.index')}}" rel="nofollow">Home</a>
                    <span></span> My Account
                </div>
            </div>
        </div>

        <section class="pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 m-auto">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="dashboard-menu">
                                    <ul class="nav flex-column" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link
                                            @if ($errors->has('name') or $errors->has('email') or session('status') === 'verification-link-sent' or session('status') === 'not_updated' or session('status') === 'profile-updated')
                                                active
                                            @endif
                                            @if ($stand)
                                                active
                                            @endif
                                            " id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="false"><i class="fi-rs-info mr-10"></i>Global Information</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link
                                            @if ($errors->has('ref') or $errors->has('nif') or $errors->has('address') or session('status') === 'address-not-updated' or session('status') === 'address-updated')
                                                active
                                            @endif
                                            " id="address-tab" data-bs-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="false"><i class="fi-rs-marker mr-10"></i>Address Information</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link
                                            @if ($errors->updatePassword->has('current_password') or $errors->updatePassword->has('password') or $errors->updatePassword->get('password_confirmation') or session('status') === 'password-updated')
                                                active
                                            @endif
                                            " id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false"><i class="fi-rs-key mr-10"></i>Update Password</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link
                                            @if ($errors->userDeletion->has('password'))
                                                active
                                            @endif
                                            " id="track-orders-tab" data-bs-toggle="tab" href="#track-orders" role="tab" aria-controls="track-orders" aria-selected="false"><i class="fi-rs-trash mr-10"></i>Delete Account</a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="tab-content dashboard-content">
                                    <div class="tab-pane fade
                                    @if ($errors->has('name') or $errors->has('email') or session('status') === 'verification-link-sent' or session('status') === 'not_updated' or session('status') === 'profile-updated')
                                        active show
                                    @endif
                                    @if ($stand)
                                        active show
                                    @endif
                                    " id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Account Information</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="container text-center" style="margin-bottom:15px">
                                                    <div class="row">
                                                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                                        @if (session('status') === 'verification-link-sent')
                                                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                                            {{ __('A new verification link has been sent to your email address.') }}
                                                        </p>
                                                        @endif

                                                        @if (session('status') === 'not_updated')
                                                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                                            {{ __('Information NOT Updated') }}
                                                        </p>
                                                        @endif

                                                        @if (session('status') === 'profile-updated')
                                                        <p
                                                            x-data="{ show: true }"
                                                            x-show="show"
                                                            x-transition
                                                            x-init="setTimeout(() => show = false, 2000)"
                                                            class="text-sm text-gray-600 dark:text-gray-400"
                                                        >{{ __('Information Updated') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                @include('profile.partials.update-profile-information-form')
                                            </div>
                                        </div>
                                    </div>

                                    <!--Address-->
                                    <div class="tab-pane fade
                                    @if ($errors->has('ref') or $errors->has('nif') or $errors->has('address') or session('status') === 'address-not-updated' or session('status') === 'address-updated')
                                        active show
                                    @endif
                                    " id="address" role="tabpanel" aria-labelledby="address-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Address Information</h5>
                                            </div>
                                            <div class="card-body">

                                                <div class="container text-center">
                                                    <div class="row">
                                                        @if($errors->any())
                                                            <p>{{ implode('', $errors->all(':message')) }}</p>
                                                        @endif
                                                        @if(session('status') === 'address-not-updated')
                                                            <p>Address NOT updated</p>
                                                        @endif
                                                        @if(session('status') === 'address-updated')
                                                            <p>Address updated</p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <form method="post" action="{{route('profile.update.address',['customer'=>$customer])}}">
                                                    @csrf
                                                    @method('patch')

                                                    <div class="form-group">
                                                    <h5>Address</h5>
                                                    <input type="text" name="address" required placeholder="Address *" value="{{$customer->address != null ? $customer->address : ''}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <h5>Nif</h5>
                                                    <input required type="text" name="nif" placeholder="Nif" value="{{$customer->nif != null ? $customer->nif : ''}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <h5>Payment Reference</h5>
                                                    <input required type="text" name="ref" placeholder="Referency payment" value="{{$customer->default_payment_ref != null ? $customer->default_payment_ref : ''}}">
                                                    </div>

                                                    <div class="mb-15">
                                                        <h5>Type of payment</h5>
                                                    </div>

                                                    <div class="form-group" style="margin-left:15px">
                                                        <div class="custome-radio">
                                                            <input class="form-check-input" {{$customer->default_payment_type == 'VISA' ? 'checked' : ''}} required type="radio" name="payment_option" value="VISA" id="exampleRadios3">
                                                            <label class="form-check-label" for="exampleRadios3" data-bs-toggle="collapse" data-target="#cashOnDelivery" aria-controls="cashOnDelivery">VISA</label>
                                                        </div>
                                                        <div class="custome-radio">
                                                            <input class="form-check-input" {{$customer->default_payment_type == 'MC' ? 'checked' : ''}} required type="radio" name="payment_option" value="MC" id="exampleRadios4">
                                                            <label class="form-check-label" for="exampleRadios4" data-bs-toggle="collapse" data-target="#cardPayment" aria-controls="cardPayment">Master Card</label>
                                                        </div>
                                                        <div class="custome-radio">
                                                            <input class="form-check-input" {{$customer->default_payment_type == 'PAYPAL' ? 'checked' : ''}} required type="radio" name="payment_option" value="PAYPAL" id="exampleRadios5">
                                                            <label class="form-check-label" for="exampleRadios5" data-bs-toggle="collapse" data-target="#paypal" aria-controls="paypal">Paypal</label>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn">Alterar Endereço</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Update Password-->
                                    <div class="tab-pane fade
                                    @if ($errors->updatePassword->has('current_password') or $errors->updatePassword->has('password') or $errors->updatePassword->get('password_confirmation') or session('status') === 'password-updated')
                                        active show
                                    @endif
                                    " id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Update Password</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="container text-center" style="margin-bottom:10px">
                                                    <div class="row">
                                                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                                                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                                                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                                                        @if (session('status') === 'password-updated')
                                                        <p
                                                            x-data="{ show: true }"
                                                            x-show="show"
                                                            x-transition
                                                            x-init="setTimeout(() => show = false, 2000)"
                                                            class="text-sm text-gray-600 dark:text-gray-400"
                                                        >{{ __('Password Updated') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                @include('profile.partials.update-password-form')
                                            </div>
                                        </div>
                                    </div>

                                    <!--Delete Account-->
                                    <div class="tab-pane fade
                                    @if ($errors->userDeletion->has('password'))
                                        active show
                                    @endif
                                    " id="track-orders" role="tabpanel" aria-labelledby="track-orders-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Delete Account</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="container text-center" style="margin-bottom:15px">
                                                    <div class="row">
                                                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                                                    </div>
                                                </div>

                                                @include('profile.partials.delete-user-form')
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
</x-app-layout>



