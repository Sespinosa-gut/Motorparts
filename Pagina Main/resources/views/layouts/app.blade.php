<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Motorparts')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/car-solid-full.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fugaz+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
        }
        .navbar-nav .nav-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
        }
        .navbar-nav .nav-item {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <nav class="barra-navegacion navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
                <img src="{{ asset('img/car-solid-full.svg') }}" width="30" height="30" class="d-inline-block align-top me-2" alt="">
                <span class="fw-bold">Motorparts Diesel</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavegacion" aria-controls="menuNavegacion" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuNavegacion">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link linkestilo" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i>Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link linkestilo" href="{{ route('catalog') }}">
                            <i class="fas fa-th-large me-1"></i>Catálogo
                        </a>
                    </li>
                    
                    @auth
                        <li class="nav-item">
                            <a class="nav-link linkestilo" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart me-1"></i>Carrito
                            </a>
                        </li>
                        
                        @if(Auth::user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link linkestilo" href="{{ route('products.create') }}">
                                    <i class="fas fa-box me-1"></i>Productos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link linkestilo" href="{{ route('brands.index') }}">
                                    <i class="fas fa-tags me-1"></i>Marcas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link linkestilo" href="{{ route('suppliers.index') }}">
                                    <i class="fas fa-truck me-1"></i>Proveedores
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link linkestilo" href="{{ route('customers.index') }}">
                                    <i class="fas fa-users me-1"></i>Clientes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link linkestilo" href="{{ route('payment-methods.index') }}">
                                    <i class="fas fa-credit-card me-1"></i>Pagos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link linkestilo" href="{{ route('sales.index') }}">
                                    <i class="fas fa-shopping-cart me-1"></i>Ventas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link linkestilo" href="{{ route('admin.orders.index') }}">
                                    <i class="fas fa-clipboard-list me-1"></i>Órdenes
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link linkestilo" href="{{ route('orders.index') }}">
                                    <i class="fas fa-clipboard-list me-1"></i>Órdenes
                                </a>
                            </li>
                        @endif
                        
                        <li class="nav-item">
                            <a class="nav-link linkestilo-inicio" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link linkestilo-inicio" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Iniciar Sesión
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <main class="py-4">
        @yield('content')
    </main>

    <footer class="pie-pagina">
        <div class="container">
            <p>© 2024 Motorparts. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
