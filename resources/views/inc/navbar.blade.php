<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="#">CR</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        {{-- <li class="nav-item">
          <a class="nav-link" href="/">Home</a>
        </li> --}}
       
      </ul>
      <ul class="navbar-nav">

        @if (empty(session('admin')))
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/') }}">Login</a>
          </li>
        @else
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/complaints') }}">Complaints</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/logout') }}">Logout</a>
          </li>
        @endif
        
      </ul>
      
    </div>
  </nav>