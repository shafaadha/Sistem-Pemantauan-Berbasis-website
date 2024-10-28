@extends('manajemen.layouts.main')

@section('container')
<title>Data Admin</title>
<div class="col-md-12">
    <div class="page-people-directory">
        <div class="row">
            <div class="col-md-5">
                <div class="list-group contact-group">
                    @foreach ($admin as $adm)
                    <a href="#" class="list-group-item">
                        <div class="media">
                            <div class="media-left">
                                <img class="img-circle" src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="...">
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">{{ $adm->name }}</h4>
                                <div class="media-content">
                                    <i class="fa fa-map-marker"></i> {{ $adm->location }}
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-skype"></i> {{ $adm->skype }}</li>
                                        <li><i class="fa fa-mobile"></i> {{ $adm->phone }}</li>
                                        <li><i class="fa fa-envelope-o"></i> {{ $adm->email }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
