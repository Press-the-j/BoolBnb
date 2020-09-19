<nav class="col-md-2 d-none d-md-block sidebar sidebar-admin">
    <div class="sidebar-sticky">
        <ul class="nav flex-column list-group-flush">
            <li class="nav-item list-group-item">
                <a class="nav-link active" href="{{route("admin.home")}}">
                  <i class="fas fa-user"></i>
                  Profilo
                </a>
            </li>
            <li class="nav-item list-group-item">
                <a class="nav-link" href="{{route("admin.flats.index")}}">
                  <i class="fas fa-building"></i>
                  Appartamenti
                </a>
            </li>
            <li class="nav-item list-group-item">
                <a class="nav-link" href="{{route("admin.messages")}}">
                  <i class="fas fa-inbox"></i>
                  Messaggi
                </a>
            </li>
            <li class="nav-item list-group-item">
                <a class="nav-link" href="{{route('admin.flats.statistics')}}">
                  <i class="fas fa-chart-pie"></i>
                  Statistiche
                </a>
            </li>

        </ul>
        <div>
            <a href="{{route('admin.flats.create')}}" class="btn btn-create btn-sidebar"><i class="fas fa-plus"></i> Appartamento</a>
        </div>
    </div>
</nav>