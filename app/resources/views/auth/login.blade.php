@extends('layouts.auth')

@section('content')




   <div class="row">
        <div class="m-auto relative bg-white m-6 px-6 pt-12 pb-6 w-9/12 h-auto">
            <div class="panel panel-default">
                <div class="panel-heading"><h2 class="text-3xl w-full text-center mb-6">Log in</h2></div>
                <div class="panel-body">
                    
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>there were some problems</strong> 
                            <br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="form-horizontal"
                          role="form"
                          method="POST"
                          action="{{ url('login') }}">
                        <input type="hidden"
                               name="_token"
                               value="{{ csrf_token() }}">
                        
                       <div class="mb-8">
                        <div class="form-group">
                            <label class="block text-dimmedTxt text-sm mb-2 control-label">EMAIL</label>

                                <input type="email"
                                       class="border border-box rounded-lg w-full py-2 px-3 border-gray-500 focus:outline-none focus:shadow-outline form-control"
                                       name="email"
                                       value="{{ old('email') }}">
                                </div>
                        </div>

                        <div class="mb-12">

                        <div class="form-group">

                            <label class="block text-dimmedTxt text-sm mb-2 control-label">PASSWORD</label>

                            <div class="col-md-6">
                                <input type="password"
                                       class="border border-box rounded-lg w-full py-2 px-3 border-gray-500 focus:outline-none focus:shadow-outline form-control"
                                       name="password">
                                    </div>
                            </div>
                        </div>

                    
                        <div class="form-group">
                            <div class="block w-40 m-auto bg-transparent text-center text-teal-400 font-semibold py-2 px-4 border-4 border-teal-400 rounded-full">
                                <button type="submit"
                                        class="text-center"
                                        >
                                    Login
                                </button>
                            </div>
                        </div>



                    </form>
                </div>
            </div>
        </div>
    </div> 
@endsection