<div>
    <section class="p-4" id="main-content">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary rounded">
            <div class="container-fluid">
                <button class="btn btn-primary ms-3" id="button-toggle">
                    <i class="bi bi-list"></i>
                </button>
                <a class="navbar-brand" href="index.php">
                    <img src="asset/img/kasir.png" style="width: 60px;"
                        alt="Gambar Logo">
                    <b id="name">KasirKu</b>
                </a>

                <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNavDropdown">
                    <ul class="navbar-nav mt-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle bg-secondary rounded me-3" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> Profile
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="logout.php"
                                        onclick="javascript:return confirm('Yakin Ingin Logout?');">logout</a></li>
                            </ul>

                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <br>