
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('dist/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">KidsApp</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('admin.home') }}" 
              class="nav-link {{ in_array(request()->route()->getName(), ['admin.home', 'admin.']) ? 'active' : ''}} ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a> 
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.user.index') }}" 
              class="nav-link {{ request()->is('admin/user*') ? 'active' : ''}} ">
              <i class="nav-icon fas fa-user"></i>
              <p>User</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.category.index') }}" 
              class="nav-link {{ request()->is('admin/category*') ? 'active' : ''}} ">
              <i class="nav-icon fas fa-list-alt"></i>
              <p>Category</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.post.index') }}" 
              class="nav-link {{ request()->is('admin/post*') ? 'active' : ''}} ">
              <i class="nav-icon fas fa-th"></i>
              <p>Post</p>
            </a>
          </li>           
          <li class="nav-item">
            <a href="{{ route('admin.content.index') }}"
              class="nav-link {{ request()->is('admin/content*') ? 'active' : ''}} ">
              <i class="nav-icon fas fa-th"></i>
              <p>Content</p>
            </a>
          </li>           
          <li class="nav-item">
            <a href="{{ route('admin.school.index') }}"
              class="nav-link {{ request()->is('admin/school*') ? 'active' : ''}} ">
              <i class="nav-icon fas fa-school"></i>
              <p>School</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>