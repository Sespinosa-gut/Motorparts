@extends('layouts.app')

@section('title', 'Motorparts')

@section('content')
    <header class="encabezado-principal text-center">
        <div class="contenido-hero">
            <h1 class="titulo-hero">Partes de Motor de Calidad</h1>
            <p class="subtitulo-hero">Encuentra las mejores piezas para tu vehículo con garantía de calidad</p>
            <div class="botones-hero">
                <a class="btn btn-primary btn-lg me-3" href="{{ route('catalog') }}">
                    <i class="fas fa-th-large me-2"></i>Ver Catálogo
                </a>
                <a class="btn btn-outline-light btn-lg" href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                </a>
            </div>
        </div>
    </header>

    <section id="productos" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="titulo-seccion">Productos Destacados</h2>
                    <p class="subtitulo-seccion">Las mejores piezas de motor con garantía de calidad</p>
                </div>
        </div>
        
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        <div class="row g-4">
                @foreach ($productos->take(8) as $p)
                  <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card tarjeta-producto h-100 shadow-sm">
                      <div class="contenedor-imagen-producto">
                        <img src="{{ route('image', $p->id) }}" class="card-img-top imagen-producto" alt="{{ $p->nombre }}" />
                        <div class="etiqueta-producto">
                          <span class="badge bg-success">En Stock</span>
                        </div>
                      </div>
                      <div class="card-body d-flex flex-column">
                        <h6 class="card-title titulo-producto">{{ $p->nombre }}</h6>
                        <p class="card-text info-producto">
                          <small class="text-muted">
                            <i class="fas fa-tag me-1"></i>{{ $p->brand->nombre ?? 'Sin marca' }}
                          </small>
                          <br>
                          <small class="text-muted">
                            <i class="fas fa-boxes me-1"></i>Stock: {{ $p->stock }}
                          </small>
                        </p>
                        <div class="mt-auto">
                          <div class="d-flex justify-content-between align-items-center">
                            <span class="precio-producto">${{ number_format($p->precio, 0, ',', '.') }}</span>
                        @auth
                          @if(Auth::user()->isCustomer())
                            <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                              @csrf
                              <input type="hidden" name="id_producto" value="{{ $p->id }}">
                              <input type="hidden" name="cantidad" value="1">
                                  <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-shopping-cart me-1"></i>Comprar
                                  </button>
                            </form>
                          @else
                                <a href="#" class="btn btn-outline-primary btn-sm">
                                  <i class="fas fa-eye me-1"></i>Ver
                                </a>
                          @endif
                        @else
                              <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-shopping-cart me-1"></i>Comprar
                              </a>
                        @endauth
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            
            <div class="text-center mt-5">
              <a href="{{ route('catalog') }}" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-th-large me-2"></i>Ver Todos los Productos
              </a>
              </div>
            </div>
    </section>

    <section id="nosotros" class="py-5 bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="titulo-seccion mb-4">Sobre Nosotros</h2>
                    <p class="lead">
                        Somos una empresa especializada en la venta de partes de motor con más de 10 años de experiencia en el mercado colombiano.
                    </p>
                    <p>
                        Nuestro compromiso es ofrecer productos de la más alta calidad y un servicio excepcional para que tu vehículo siempre esté en las mejores condiciones. Trabajamos con las mejores marcas del mercado y garantizamos la autenticidad de todos nuestros productos.
                    </p>
                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="item-caracteristica text-center">
                                <i class="fas fa-award fa-2x text-primary mb-2"></i>
                                <h5>Calidad Garantizada</h5>
                                <p class="small text-muted">Productos originales con garantía</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="item-caracteristica text-center">
                                <i class="fas fa-shipping-fast fa-2x text-primary mb-2"></i>
                                <h5>Envío Rápido</h5>
                                <p class="small text-muted">Entrega en 3-5 días hábiles</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="imagen-nosotros">
                        <div class="placeholder-imagen bg-light rounded shadow">
                            <i class="fas fa-cogs fa-5x text-muted"></i>
                            <p class="mt-3 text-muted">Especialistas en Partes de Motor</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="FAQ" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="titulo-seccion">Preguntas Frecuentes</h2>
                    <p class="subtitulo-seccion">Resolvemos tus dudas más comunes</p>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button boton-acordeon" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <i class="fas fa-truck me-2 text-primary"></i>
                                    ¿Cuál es el tiempo de entrega?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body cuerpo-acordeon">
                                    El tiempo de entrega varía según la ubicación, pero generalmente es de 3 a 5 días hábiles. Para envíos a Bogotá y principales ciudades, el tiempo puede ser de 1 a 2 días hábiles.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button boton-acordeon collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                    ¿Hacen envíos a todo el país?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body cuerpo-acordeon">
                                    Sí, realizamos envíos a todas las ciudades de Colombia. Trabajamos con las mejores empresas de mensajería para garantizar que tu pedido llegue seguro y a tiempo.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button boton-acordeon collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <i class="fas fa-undo me-2 text-primary"></i>
                                    ¿Puedo devolver un producto si no estoy satisfecho?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body cuerpo-acordeon">
                                    Sí, aceptamos devoluciones dentro de los 30 días posteriores a la compra. El producto debe estar en perfecto estado y con su empaque original. Los gastos de envío de la devolución corren por cuenta del cliente.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button boton-acordeon collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <i class="fas fa-shield-alt me-2 text-primary"></i>
                                    ¿Ofrecen garantía en sus productos?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                <div class="accordion-body cuerpo-acordeon">
                                    Todos nuestros productos cuentan con garantía del fabricante. Además, ofrecemos garantía de autenticidad y calidad. Si tienes algún problema con tu producto, contáctanos y te ayudaremos a resolverlo.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contacto" class="py-5 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="titulo-seccion">Contáctanos</h2>
                    <p class="subtitulo-seccion">Estamos aquí para ayudarte con todas tus necesidades</p>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="item-contacto text-center p-4 border rounded shadow-sm">
                                <i class="fas fa-map-marker-alt fa-3x text-primary mb-3"></i>
                                <h5>Dirección</h5>
                                <p class="text-muted">Calle 1 C #19 D - 54<br>Bogotá, Colombia</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="item-contacto text-center p-4 border rounded shadow-sm">
                                <i class="fas fa-phone fa-3x text-primary mb-3"></i>
                                <h5>Teléfono</h5>
                                <p class="text-muted">
                                    <a href="tel:+573209556691" class="text-decoration-none">320 955 66 91</a>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="item-contacto text-center p-4 border rounded shadow-sm">
                                <i class="fas fa-envelope fa-3x text-primary mb-3"></i>
                                <h5>Email</h5>
                                <p class="text-muted">
                                    <a href="mailto:Motorpartssas@gmail.com" class="text-decoration-none">Motorpartssas@gmail.com</a>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="item-contacto text-center p-4 border rounded shadow-sm">
                                <i class="fas fa-clock fa-3x text-primary mb-3"></i>
                                <h5>Horario de Atención</h5>
                                <p class="text-muted">Lunes a Sábado<br>8:00 AM - 6:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


