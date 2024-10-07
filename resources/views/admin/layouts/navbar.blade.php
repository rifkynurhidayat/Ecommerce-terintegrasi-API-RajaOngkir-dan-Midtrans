<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>



    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        @php
        $admin = 1;
    @endphp
        <!-- Nav Item - Alerts -->
        @if(Auth::user()->role_id !=  $admin )
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                @php
                    // Menghitung jumlah pesan di tabel 'chat'
                    $chatCount = \App\Models\Chat::count();
                    $ekspedisiRoleId = 3;
                @endphp
                <span class="badge badge-danger badge-counter">{{ $chatCount > 3 ? '0' : $chatCount }}</span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>
                    @php
                        $chats = \App\Models\Chat::all();
                    @endphp
                    @foreach ($chats as $chat)
                        <div class="chat-message">
                            <div class="small text-gray-500">{{ $chat->created_at }}</div>
                            <span class="font-weight-bold">{{ $chat->pesan }}</span>
                        </div>
                    @endforeach
                </a>

            </div>
        </li>
        @endif


        @php
        $ekspedisiRoleId = 3;
    @endphp
        <!-- Nav Item - Messages -->
        @if(Auth::user()->role_id !=  $ekspedisiRoleId )
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="modal"
                data-target="#messageModal" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                {{-- <span class="badge badge-danger badge-counter">7</span> --}}
            </a>
            <!-- Modal -->

            <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="messageModalLabel">Message Center</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form untuk mengirim pesan -->
                            <form method="post" action="/ekspedisi">
                                @csrf
                                <div class="form-group">
                                    <label for="recipient">Kepada</label>
                                    <input type="text" class="form-control" id="recipient" placeholder="Ekspedisi"
                                           readonly>
                                </div>
                                <div class="form-group">
                                    <label for="pesan">Pesan</label>
                                    <textarea class="form-control" id="pesan" name="pesan" rows="4" placeholder="Pesan"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary" onclick="sendMessage()">Kirim</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- End Modal -->
        </li>
        @endif


        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Welcome, {{ Auth::user()->name }}</span>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/logout">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
