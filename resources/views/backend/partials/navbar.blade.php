<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
      <ul class="navbar-nav">
        {{-- <li class="nav-item">
            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
            </a>
        </li> --}}

        <li class="nav-item d-none d-md-block">
            <a href="{{ url('') }}" class="nav-link" target="_blank">
                Frontend
            </a>
        </li>

        <!-- DASHBOARD SWITCHER -->
        <li class="nav-item d-none d-md-flex align-items-center ms-3">
            <div class="dashboard-switcher">
                <a href="{{ url('68b467d9-34c8-4163-8740-e256750ac1eb') }}"
                  class="dashboard-switch {{ request()->is('68b467d9-34c8-4163-8740-e256750ac1eb') ? 'active' : '' }}">
                    <i class="bi bi-grid"></i>
                    Dashboard V1
                </a>

                <a href="{{ url('c7575fea-63f0-4956-a95d-e4988f75bf98') }}"
                  class="dashboard-switch {{ request()->is('c7575fea-63f0-4956-a95d-e4988f75bf98') ? 'active' : '' }}">
                    <i class="bi bi-grid"></i>
                    Dashboard V2
                </a>
            </div>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        {{-- <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="bi bi-search"></i>
          </a>
        </li> --}}
        {{-- <li class="nav-item dropdown">
          <a class="nav-link" data-bs-toggle="dropdown" href="#">
            <i class="bi bi-chat-text"></i>
            <span class="navbar-badge badge text-bg-danger">3</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
            <a href="#" class="dropdown-item">
              <div class="d-flex">
                <div class="flex-shrink-0">
                  <img
                    src="assets/backend/img/user1-128x128.jpg"
                    alt="User Avatar"
                    class="img-size-50 rounded-circle me-3"
                  />
                </div>
                <div class="flex-grow-1">
                  <h3 class="dropdown-item-title">
                    Brad Diesel
                    <span class="float-end fs-7 text-danger"
                      ><i class="bi bi-star-fill"></i
                    ></span>
                  </h3>
                  <p class="fs-7">Call me whenever you can...</p>
                  <p class="fs-7 text-secondary">
                    <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                  </p>
                </div>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <div class="d-flex">
                <div class="flex-shrink-0">
                  <img
                    src="assets/backend/img/user8-128x128.jpg"
                    alt="User Avatar"
                    class="img-size-50 rounded-circle me-3"
                  />
                </div>
                <div class="flex-grow-1">
                  <h3 class="dropdown-item-title">
                    John Pierce
                    <span class="float-end fs-7 text-secondary">
                      <i class="bi bi-star-fill"></i>
                    </span>
                  </h3>
                  <p class="fs-7">I got your message bro</p>
                  <p class="fs-7 text-secondary">
                    <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                  </p>
                </div>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <div class="d-flex">
                <div class="flex-shrink-0">
                  <img
                    src="assets/backend/img/user3-128x128.jpg"
                    alt="User Avatar"
                    class="img-size-50 rounded-circle me-3"
                  />
                </div>
                <div class="flex-grow-1">
                  <h3 class="dropdown-item-title">
                    Nora Silvester
                    <span class="float-end fs-7 text-warning">
                      <i class="bi bi-star-fill"></i>
                    </span>
                  </h3>
                  <p class="fs-7">The subject goes here</p>
                  <p class="fs-7 text-secondary">
                    <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                  </p>
                </div>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
          </div>
        </li> --}}
        {{-- <li class="nav-item dropdown">
          <a class="nav-link" data-bs-toggle="dropdown" href="#">
            <i class="bi bi-bell-fill"></i>
            <span class="navbar-badge badge text-bg-warning">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
            <span class="dropdown-item dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="bi bi-envelope me-2"></i> 4 new messages
              <span class="float-end text-secondary fs-7">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="bi bi-people-fill me-2"></i> 8 friend requests
              <span class="float-end text-secondary fs-7">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="bi bi-file-earmark-fill me-2"></i> 3 new reports
              <span class="float-end text-secondary fs-7">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer"> See All Notifications </a>
          </div>
        </li> --}}
        <li class="nav-item">
          <a class="nav-link" href="#" data-lte-toggle="fullscreen">
            <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
            <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
          </a>
        </li>
        <li class="nav-item dropdown user-menu">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            <img
              src="{{ url('storage/' . get_pengguna()[0]->photo) }}"
              class="user-image rounded-circle shadow"
              alt="User Image"
            />
            <span class="d-none d-md-inline">{{ ucwords(get_pengguna()[0]->pemilik) }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
            <li class="user-header text-bg-primary">
              <img
                src="{{ url('storage/' . get_pengguna()[0]->photo) }}"
                class="rounded-circle shadow"
                alt=""
              />
              <p>
                {{ ucwords(get_pengguna()[0]->pemilik) }} - {{ ucwords(get_pengguna()[0]->nama) }}
                <small>{{ get_pengguna()[0]->bergabung }}</small>
              </p>
            </li>
            {{-- <li class="user-body">
              <div class="row">
                <div class="col-4 text-center"><a href="#">Followers</a></div>
                <div class="col-4 text-center"><a href="#">Sales</a></div>
                <div class="col-4 text-center"><a href="#">Friends</a></div>
              </div>
            </li> --}}
            <li class="user-footer">
              <form method="post">
                @csrf
                <a href="javascript:;" class="btn btn-default btn-flat float-end" onclick="Page.Keluar()">
                  Keluar
                </a>
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
</nav>

<div class="modal fade" id="Loader" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" style="background-color:transparent; border:0px solid;">
      <div class="modal-body">
        <center><img src="/assets/backend/img/loader.gif" alt="" class="img-fluid d-block w-7" style="width:50px;" /></center>
      </div>
    </div>
  </div>
</div>