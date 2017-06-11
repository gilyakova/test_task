<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Appointments</title>
        <link rel="stylesheet" href="/assets/dist/style.min.css">
    </head>
    <body>
        <div class="container">
            <div class="header clearfix">
                <nav>
                    <ul class="nav nav-pills float-right">
                        <li class="nav-item">
                            <a class="nav-link {{ $page_type == 'index' ? 'active' : '' }}" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $page_type == 'create' ? 'active' : '' }}" href="/create">New appointment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/get_csv">Download all appointments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/get_pdf">Download pdf</a>
                        </li>
                    </ul>
                </nav>
                <div class="h3 text-muted">Appointments</div>
            </div>
            <main>@yield('content')</main>
            <footer class="footer">
                <p>&copy; Elena 2017</p>
            </footer>
        </div>
        <script async src="/assets/dist/script.min.js"></script>
    </body>
</html>