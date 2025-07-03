<!DOCTYPE html>
<html lang="en">

<head>
    @include('template.header_admin')
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper" class="d-flex">
        @include('template.sidebar_admin')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column w-100">
            <!-- Main Content -->
            <div id="content">
                @include('template.topbar_admin')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- End Page Content -->
            </div>

            @include('template.footer_admin')
        </div>
        <!-- End Content Wrapper -->
    </div>
    <!-- End Page Wrapper -->
</body>

</html>
