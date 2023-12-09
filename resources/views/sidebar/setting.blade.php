<aside class="col-12 col-md-2 p-0 bg-dark flex-shrink-1">
    <nav class="navbar navbar-expand navbar-dark bg-dark flex-md-column flex-row align-items-start py-2">
        <div class="collapse navbar-collapse ">
            <ul class="flex-md-column flex-row navbar-nav w-100 justify-content-between">
                <li class="nav-item {{ Request::is('home/page') ? 'active' : '' }}">
                    <a class="nav-link pl-0 text-nowrap" href="{{ route('home/page') }}"><i class="fa fa-bullseye fa-fw"></i> <span class="font-weight-bold">Dashboard</span></a>
                </li>
                @if(Auth::user()->role!=3)
                <li class="nav-item {{ Request::is('form/personal/new') ? 'active' : '' }}">
                    <a class="nav-link pl-0" href="{{ route('form/personal/new') }}"><i class="fa fa-book fa-fw"></i> <span class="d-none d-md-inline">Form</span></a>
                </li>
                @endif
                <li class="nav-item {{ Request::is('form/report') ? 'active' : '' }}">
                    <a class="nav-link pl-0" href="{{ route('form/report') }}"><i class="fa fa-file-excel-o fa-fw"></i> <span class="d-none d-md-inline">Report</span></a>
                </li>
                
                <!--<li class="nav-item {{ Request::is('#') ? 'active' : '' }}">
                    <a class="nav-link pl-0" href="#"><i class="fa fa-heart codeply fa-fw"></i> <span class="d-none d-md-inline">Maintenance</span></a>
                </li>
                
                <li class="nav-item {{ Request::is('#') ? 'active' : '' }}">
                    <a class="nav-link pl-0" href="#"><i class="fa fa-star codeply fa-fw"></i> <span class="d-none d-md-inline">Promission</span></a>
                </li>-->
                @if(Auth::user()->role==1)
                <style>
                 .submenu {
                         display: none;
                        }
                </style>
                <li class="nav-item active">
                    <a class="nav-link pl-0" href="#" onclick="toggleSubmenu('submenu1')"><i class="fa fa-cog fa-fw"></i> <span class="d-none d-md-inline">Setting</span></a>
                    <ul class="submenu" id="submenu1">
                        <li class="nav-item {{ Request::is('form/addoperator') ? 'active' : '' }}">
                             <a class="nav-link pl-0" href="{{ route('form/addoperator') }}"><i class="fa fa-plus"></i> <span class="d-none d-md-inline">Add Operator</span></a>
                        </li>                 
                        <li class="nav-item {{ Request::is('form/addmachine') ? 'active' : '' }}">
                             <a class="nav-link pl-0" href="{{ route('form/addmachine') }}"><i class="fa fa-plus"></i> <span class="d-none d-md-inline">Add Machine</span></a>
                        </li>             
                        <li class="nav-item {{ Request::is('form/addproduct') ? 'active' : '' }}">
                             <a class="nav-link pl-0" href="{{ route('form/addproduct') }}"><i class="fa fa-plus"></i> <span class="d-none d-md-inline">Add Product</span></a>
                        </li>       
                        <li class="nav-item {{ Request::is('form/adduser') ? 'active' : '' }}">
                             <a class="nav-link pl-0" href="{{ route('form/adduser') }}"><i class="fa fa-plus"></i> <span class="d-none d-md-inline">Add User</span></a>
                        </li>
                    </ul>
                </li>
                @endif 
                <li class="nav-item {{ Request::is('form/logout') ? 'active' : '' }}">
                    <a class="nav-link pl-0" href="{{ route('form/logout') }}"><i class="fa fa-sign-out"></i> <span class="d-none d-md-inline">Logout</span></a>
                </li>
            </ul>
        </div>
    </nav>
</aside>
<script>
    function toggleSubmenu(submenuId) {
        var submenu = document.getElementById(submenuId);
        if (submenu.style.display === 'block') {
            submenu.style.display = 'none';
        } else {
            // Hide all other submenus before displaying the selected one
            var allSubmenus = document.querySelectorAll('.submenu');
            allSubmenus.forEach(function (element) {
                element.style.display = 'none';
            });
            submenu.style.display = 'block';
        }
    }
</script>