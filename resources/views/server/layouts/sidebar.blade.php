<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('templates/dist/img/rikai.png') }}" alt="Rikai Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Rikai</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-column">
      <div class="p-2">
        <div class="image">
          <img src="/upload/{{Auth::user()->avatar}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>
      <div class="p-2"><a href="{{route('signout')}}" class="nav-link">{{__('views.logout')}}</a></div>
      
      </div>
      
      <!-- SidebarSearch Form -->
      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{route('server.index')}}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                {{__('views.dashboard')}}
              </p>
            </a>
            
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                {{__('views.profile')}}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="{{route('server.user.show', ['user' => Auth::id()])}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{__('views.my_profile')}}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('server.user.trainee')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{__('views.trainee')}}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('server.user.supervisor')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{__('views.supervisor')}}</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{route('server.course.index')}}" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                {{__('views.course')}}
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('server.subject.index')}}" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                {{__('views.subject')}}
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                {{__('views.action')}}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="{{route('server.course.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{__('views.addCourse')}}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('server.subject.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{__('views.addSubject')}}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('server.user.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{__('views.addUser')}}</p>
                </a>
              </li>
            </ul>
          </li>
          


          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>